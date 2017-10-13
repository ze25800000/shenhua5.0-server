<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 14:45
 */

namespace app\model;


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

    public static function getEquCostList($before, $after) {

    }
    public static function getOilDetailListByKeyword($keyword) {
        $result = self::where('oil_name', 'like', "%$keyword%")
            ->whereOr('oil_no', 'like', "%$keyword%")
            ->whereOr('detail','like',"%$keyword%")
            ->select();
        return $result;
    }
}