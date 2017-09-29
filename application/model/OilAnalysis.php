<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 9:10
 */

namespace app\model;


use app\lib\tools\Tools;

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
        $result    = OilStandard::field('equ_key_no')->select();
        $equKeyNos = Tools::listMoveToArray($result, 'equ_key_no');
        $arr       = [];
        foreach ($equKeyNos as $k => $v) {
            $oil = self::where('equ_key_no', '=', $v)
                ->order('sampling_time desc')
                ->limit(1)
                ->find();
            if ($oil) {
                array_push($arr, $oil);
            }
        }
        return $arr;
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
            ->field('Fe,Cu,Al,Si,Na,pq,viscosity,sampling_time')
            ->select();
        $collection = collection($elementList)->toArray();
        $config      = OilConfig::get(1);
        $dates       = array_column($collection, 'sampling_time');
        $Fe          = [
            'normal' => $config->Fe,
            'value'  => array_column($collection, 'Fe'),
            'date'   => $dates
        ];
        $Cu          = [
            'normal' => $config->Cu,
            'value'  => array_column($collection, 'Cu'),
            'date'   => $dates,
        ];
        $Si          = [
            'normal' => $config->Si,
            'value'  => array_column($collection, 'Si'),
            'date'   => $dates,
        ];
        $Al          = [
            'normal' => $config->Al,
            'value'  => array_column($collection, 'Al'),
            'date'   => $dates,
        ];
        $Na          = [
            'normal' => $config->Na,
            'value'  => array_column($collection, 'Na'),
            'date'   => $dates,
        ];
        $pq          = [
            'normal' => $config->pq,
            'value'  => array_column($collection, 'pq'),
            'date'   => $dates,
        ];
        $viscosity   = [
            'normal' => [$config->viscosity_min, $config->viscosity_max],
            'value'  => array_column($collection, 'viscosity'),
            'date'   => $dates,
        ];
        return [
            'Fe'        => $Fe,
            'Cu'        => $Cu,
            'Si'        => $Si,
            'Al'        => $Al,
            'Na'        => $Na,
            'pq'        => $pq,
            'viscosity' => $viscosity
        ];
    }
}