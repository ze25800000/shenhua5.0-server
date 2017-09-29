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
        $collection  = array_slice(collection($elementList)->toArray(), -12);
        $config      = OilConfig::get(1);
        $dates       = Tools::listMoveToArray($collection, 'sampling_time', false);
        $count       = count($collection);
        $Fe          = [
            'normal' => Tools::itemArray($config->Fe, $count),
            'value'  => Tools::listMoveToArray($collection, 'Fe', false),
            'date'   => $dates
        ];
        $Cu          = [
            'normal' => Tools::itemArray($config->Cu, $count),
            'value'  => Tools::listMoveToArray($collection, 'Cu', false),
            'date'   => $dates,
        ];
        $Si          = [
            'normal' => Tools::itemArray($config->Si, $count),
            'value'  => Tools::listMoveToArray($collection, 'Si', false),
            'date'   => $dates,
        ];
        $Al          = [
            'normal' => Tools::itemArray($config->Al, $count),
            'value'  => Tools::listMoveToArray($collection, 'Al', false),
            'date'   => $dates,
        ];
        $Na          = [
            'normal' => Tools::itemArray($config->Na, $count),
            'value'  => Tools::listMoveToArray($collection, 'Na', false),
            'date'   => $dates,
        ];
        $pq          = [
            'normal' => Tools::itemArray($config->pq, $count),
            'value'  => Tools::listMoveToArray($collection, 'pq', false),
            'date'   => $dates,
        ];
        $viscosity   = [
            'normalMax' => Tools::itemArray($config->viscosity_max, $count),
            'normalMin' => Tools::itemArray($config->viscosity_min, $count),
            'value'     => Tools::listMoveToArray($collection, 'viscosity', false),
            'date'      => $dates,
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