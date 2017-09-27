<?php

namespace app\model;


use app\lib\tools\Tools;
use think\Request;

class InfoWarning extends BaseModel {
//    protected $visible = ['equ_key_no','del_warning_time','status','how_long','warning_type','postpone','postpone_reason','oil_no','quantity','user'];
    protected $hidden = ['create_time', 'update_time'];

    public function user() {
        return $this->hasOne('user', 'id', 'user_id');
    }

    public static function getWarningMessage() {
        $getEquKeyNos = OilStandard::field('equ_key_no')->select();
        $equKeyNos    = Tools::listMoveToArray($getEquKeyNos, 'equ_key_no');
        $arr          = [];
        foreach ($equKeyNos as $v) {
            $temp = self::where("equ_key_no='{$v}'")
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            array_push($arr, $temp);
        }
        foreach ($arr as $k => $v) {
            if ($v['status'] < 2) {
                unset($arr[$k]);
            }
        }
        return $arr;
    }

    public static function getInfoList() {
        //获得equ_key_no组成的数组
        $OilStandardModel = OilStandard::field('equ_key_no')->select();
        $equKeyNos        = Tools::listMoveToArray($OilStandardModel, 'equ_key_no');
        $result           = [];
        foreach ($equKeyNos as $v) {
            $item = self::where('equ_key_no', '=', $v)
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($result, $item);
            }
        }

        return $result;
    }

    public static function getInfoListByIds($ids) {
        $result     = self::select($ids);
        $collection = collection($result)
            ->visible(['equ_no', 'equ_oil_no', 'equ_oil_name', 'del_warning_time', 'warning_type', 'how_long', 'postpone', 'status', 'is_first_period'])
            ->toArray();
        return $collection;
    }

    public static function getInfoListByDate($before, $after) {
        $result = self::where('del_warning_time', '>=', $before)
            ->where('del_warning_time', '<=', $after)
            ->order('del_warning_time desc')
            ->order('equ_key_no asc')
            ->select();
        return $result;
    }

    public static function getInfoWarningListByKeyword($keyword) {
        $equKeyNoLists = OilStandard::where('equ_oil_name', 'LIKE', "%$keyword%")
            ->field('equ_key_no')->select();
        $equKeyNos     = Tools::listMoveToArray($equKeyNoLists, 'equ_key_no');
        $result        = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', '=', $equKeyNo)
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            array_push($result, $item);
        }
        if (empty($result)) {
            return null;
        }
        return $result;
    }

    public static function getRecentInfoWarningIds() {
        $equKeyNoList = self::field('equ_key_no')->select();
        $equKeyNos = Tools::listMoveToArray($equKeyNoList, 'equ_key_no');
        $arr = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', $equKeyNo)
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($arr, $item);
            }
        }
        return Tools::listMoveToArray($arr,'id');
    }
}