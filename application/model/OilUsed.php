<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/18
 * Time: 8:27
 */

namespace app\model;


use app\lib\tools\Tools;

class OilUsed extends BaseModel {
    public static function getRecentOilUsedIds() {
        $equKeyNoList = self::field('equ_key_no')->select();
        $equKeyNos    = Tools::listMoveToArray($equKeyNoList, 'equ_key_no');
        $arr          = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', $equKeyNo)
                ->order('del_warning_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($arr, $item);
            }
        }
        return Tools::listMoveToArray($arr, 'id');
    }
}