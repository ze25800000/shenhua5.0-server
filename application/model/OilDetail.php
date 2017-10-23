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

    public static function getCostList($before, $after, $equNo = 'all') {
        $equNo      = $equNo == 'all' ? null : " AND equ_no={$equNo}";
        $sql        = "SELECT
                      id,
                      oil_no,
                      oil_name,
                      detail,
                      unit,
                      price
                      FROM oil_detail";
        $oilDetail  = Db::query($sql);
        $totalPrice = 0;
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
                $oilDetail[$k]['total']    = round($v['price'] * $oilDetail[$k]['how_much'], 2);
                array_push($oilDetail[$k]['equs'], $vv);
            }
            $totalPrice += $oilDetail[$k]['total'];
        }
        $x = $totalPrice;
        return $oilDetail;

    }

    public static function getEquCostList($before, $after, $equNo) {
        $equNo      = $equNo == 'all' ? null : " AND equ_no={$equNo}";
        $sql        = "SELECT
                    id,
                    equ_no,
                    equ_key_no,
                    equ_oil_no,
                    equ_oil_name,
                    oil_no
                    FROM info_warning
                    WHERE del_warning_time BETWEEN $before AND $after AND warning_type = 1" . $equNo . " 
                    GROUP BY equ_key_no 
                    ORDER BY equ_no asc,equ_oil_no asc";
        $infoWarns  = Db::query($sql);
        $totalPrice = 0;
        foreach ($infoWarns as &$infoWarn) {
//            $OilUsed  = OilUsed::where(['equ_key_no' => $infoWarn['equ_key_no'],])
//                ->where("del_warning_time between $before and $after")
//                ->select();
            $sql      = "select * from oil_used where equ_key_no={$infoWarn['equ_key_no']} AND del_warning_time between $before and $after";
            $OilUsed  = Db::query($sql);
            $oil_no   = [];
            $oil_name = [];
            $detail   = [];
            $unit     = [];
            $price    = [];
            $quantity = [];
            $date     = [];
            $total    = 0;
            foreach ($OilUsed as $k => $item) {
                array_push($oil_no, $item['oil_no']);
                array_push($oil_name, $item['oil_name']);
                array_push($detail, $item['detail']);
                array_push($unit, $item['unit']);
                array_push($price, $item['price']);
                array_push($quantity, $item['quantity']);
                array_push($date, date('Y年m月d日', $item['del_warning_time']));
                $total += round($item['cost'], 2);
            }
            $infoWarn['oil_no']   = implode('<hr>', $oil_no);
            $infoWarn['oil_name'] = implode('<hr>', $oil_name);
            $infoWarn['detail']   = implode('<hr>', $detail);
            $infoWarn['unit']     = implode('<hr>', $unit);
            $infoWarn['price']    = implode('<hr>', $price);
            $infoWarn['date']     = implode('<hr>', $date);
            $infoWarn['quantity'] = implode('<hr>', $quantity);
            $infoWarn['total']    = $total;
            $totalPrice           += $infoWarn['total'];
        }
        $x = $totalPrice;
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