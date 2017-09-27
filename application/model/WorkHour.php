<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6 0006
 * Time: 9:37
 */

namespace app\model;


use app\lib\tools\Tools;

class WorkHour extends BaseModel {
    protected $visible=['start_time','working_hour'];
    public static function getRecentWorkHourIds() {
        $equKeyNoList = self::field('equ_key_no')->select();
        $equKeyNos = Tools::listMoveToArray($equKeyNoList, 'equ_key_no');
        $arr = [];
        foreach ($equKeyNos as $equKeyNo) {
            $item = self::where('equ_key_no', $equKeyNo)
                ->order('start_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($arr, $item);
            }
        }
        return Tools::listMoveToArray($arr,'id');
    }
}