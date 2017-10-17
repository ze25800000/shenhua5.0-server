<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 14:45
 */

namespace app\model;


use app\lib\tools\Tools;
use think\Db;

class OilDetail extends BaseModel {
    protected $hidden = ['create_time', 'update_time'];

    public function infowarning() {
        return $this->hasMany('InfoWarning', 'oil_no', 'oil_no');
    }

    public static function getCostList($before, $after, $equNo = 'all') {
        $equNo     = $equNo == 'all' ? null : " AND equ_no={$equNo}";
        $sql       = "SELECT
                      id,
                      oil_no,
                      oil_name,
                      detail,
                      unit,
                      price
                      FROM oil_detail";
        $oilDetail = Db::query($sql);
        foreach ($oilDetail as $k => $v) {
            $sql = "SELECT equ_oil_name,del_warning_time,quantity
                    FROM info_warning
                    WHERE del_warning_time BETWEEN $before AND $after AND warning_type = 1 AND oil_no = {$v['oil_no']}" . $equNo . "
                    ORDER BY equ_no asc,equ_oil_no asc;";

            $infoWarn = Db::query($sql);

            $oilDetail[$k]['how_much'] = 0;
            $oilDetail[$k]['total']    = 0;
            $oilDetail[$k]['equs']     = [];
            foreach ($infoWarn as &$vv) {
                $oilDetail[$k]['how_much'] += $vv['quantity'];
                $oilDetail[$k]['total']    = $v['price'] * $oilDetail[$k]['how_much'];
                array_push($oilDetail[$k]['equs'], $vv);
            }
        }
        return $oilDetail;

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
                    WHERE del_warning_time BETWEEN $before AND $after AND warning_type = 1" . $equNo . " 
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