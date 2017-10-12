<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 9:10
 */

namespace app\model;


use app\lib\tools\Tools;
use think\Db;

class OilAnalysis extends BaseModel {
    protected $hidden = ['create_time', 'update_time'];

    public function getSamplingTimeAttr($value) {
        return date('Y年m月d日', $value);
    }

    public function infoItem() {
        return $this->hasMany('InfoWarning', 'equ_key_no', 'equ_key_no')
//            ->field('oil_no')
            ->order('del_warning_time desc')
            ->limit(1);
    }

    public static function getAnalysisList() {
        $sql    = "SELECT *
                FROM oil_analysis AS a
                WHERE sampling_time = (SELECT max(a1.sampling_time)
                                          FROM oil_analysis AS a1
                                          WHERE a1.equ_key_no = a.equ_key_no
                )
                ORDER BY equ_key_no ASC";
        $result = Db::query($sql);
        return $result;
    }

    public static function getOilAnalysisByIds($ids) {
        $result     = self::select($ids);
        $collection = collection($result)
            ->toArray();
        foreach ($collection as &$v) {
            $info          = InfoWarning::field('oil_no')
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            $v['oil_no']   = $info['oil_no'];
            $OilDetail     = OilDetail::field('oil_name')
                ->where(['oil_no' => $v['oil_no']])
                ->find();
            $v['oil_name'] = $OilDetail['oil_name'];
        }
        return $collection;
    }

    public static function getOilAnalysisListByDate($before, $after) {
        $result = self::where('sampling_time', '>=', $before)
            ->where('sampling_time', '<=', $after)
            ->order('sampling_time desc')
            ->order('equ_key_no asc')
            ->select();
        return $result;
    }

    public static function getOilAnalysisListByKeyword($keyword) {
        $equKeyNoLists = OilStandard::where('equ_oil_name', 'LIKE', "%$keyword%")
            ->field('equ_key_no')->select();
        $equKeyNos     = Tools::listMoveToArray($equKeyNoLists, 'equ_key_no');
        $result        = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', '=', $equKeyNo)
                ->order('sampling_time desc')
                ->limit(1)
                ->find();
            array_push($result, $item);
        }
        if (empty($result)) {
            return null;
        }
        return $result;
    }

    public static function getRecentOilAnalysisIds() {
        $equKeyNoList = self::field('equ_key_no')->select();
        $equKeyNos    = Tools::listMoveToArray($equKeyNoList, 'equ_key_no');
        $arr          = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', $equKeyNo)
                ->order('sampling_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($arr, $item);
            }
        }
        return Tools::listMoveToArray($arr, 'id');
    }

    public static function getElementValues($equKeyNo) {
        $elementList = self::where('equ_key_no', $equKeyNo)
            ->field('Fe,Cu,Al,Si,Na,PQ,viscosity,sampling_time,oil_no')
            ->select();
        $collection  = array_slice(collection($elementList)->toArray(), -12);
        return [
            'Fe'        => self::eleDetail($collection, 'Fe'),
            'Cu'        => self::eleDetail($collection, 'Cu'),
            'Si'        => self::eleDetail($collection, 'Si'),
            'Al'        => self::eleDetail($collection, 'Al'),
            'Na'        => self::eleDetail($collection, 'Na'),
            'PQ'        => self::eleDetail($collection, 'PQ'),
            'viscosity' => self::eleDetail($collection, 'viscosity')
        ];
    }

    public static function eleDetail($OilAnalysisList, $ele) {
        $dates = Tools::listMoveToArray($OilAnalysisList, 'sampling_time', false);
        if ($ele != 'viscosity') {
            $arr = [
                'normal' => self::config($OilAnalysisList, $ele),
                'value'  => Tools::listMoveToArray($OilAnalysisList, $ele, false),
                'date'   => $dates
            ];
        } else {
            $arr = [
                'normalMax' => self::config($OilAnalysisList, 'viscosity_max'),
                'normalMin' => self::config($OilAnalysisList, 'viscosity_min'),
                'value'     => Tools::listMoveToArray($OilAnalysisList, 'viscosity', false),
                'date'      => $dates,
            ];
        }
        return $arr;

    }

    public static function config($OilAnalysisList, $ele) {
        $arr = [];
        foreach ($OilAnalysisList as $item) {
            $config = OilDetail::where(['unit' => 'L', 'oil_no' => $item['oil_no']])->find();
            array_push($arr, $config->$ele);
        }
        return $arr;
    }
}