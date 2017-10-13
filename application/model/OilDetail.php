<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 14:45
 */

namespace app\model;


use think\Db;

class OilDetail extends BaseModel {
    protected $hidden = ['create_time', 'update_time'];

    public function infowarning() {
        return $this->hasMany('InfoWarning', 'oil_no', 'oil_no');
    }

    public static function getCostList($before, $after) {
        $result = self::with(['infowarning'])->select();
        foreach ($result as $v) {
            $howMuch = 0;
            if (!empty($v['infowarning'])) {
                foreach ($v['infowarning'] as $vv) {
                    if ($vv['del_warning_time'] >= $before && $vv['del_warning_time'] <= $after) {
                        $howMuch += $vv['quantity'];
                    }
                }
            }
            $v['how_much'] = $howMuch;
            $v['total']    = $howMuch * $v['price'];
        }
        return $result;
    }

    public static function getEquCostList($before, $after, $equNo) {
        $equNo     = $equNo == 'all' ? null : " AND equ_no={$equNo}";
        $sql       = "SELECT
                    equ_no,
                    equ_oil_no,
                    equ_oil_name,
                    oil_no,
                    sum(quantity) AS how_much
                    FROM info_warning
                    WHERE warning_type = 1 AND del_warning_time BETWEEN $before AND $after" . $equNo . " 
                    GROUP BY equ_key_no 
                    ORDER BY equ_no asc,equ_oil_no asc";
        $infoWarns = Db::query($sql);
        foreach ($infoWarns as &$infoWarn) {
            $oilDetail            = OilDetail::where(['oil_no' => $infoWarn['oil_no']])->find();
            $infoWarn['oil_name'] = $oilDetail->oil_name;
            $infoWarn['detail']   = $oilDetail->detail;
            $infoWarn['unit']     = $oilDetail->unit;
            $infoWarn['price']    = $oilDetail->price;
            $infoWarn['total']    = $infoWarn['how_much'] * $infoWarn['price'];
        }
        return $infoWarns;
    }

    public static function getOilDetailListByKeyword($keyword) {
        $result = self::where('oil_name', 'like', "%$keyword%")
            ->whereOr('oil_no', 'like', "%$keyword%")
            ->whereOr('detail', 'like', "%$keyword%")
            ->select();
        return $result;
    }
}