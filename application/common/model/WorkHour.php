<?php

namespace app\common\model;


class WorkHour extends BaseModel {
    protected $visible = ['start_time', 'working_hour'];

    public static function getRecentWorkHourIds() {
        $equNoList = self::field('equ_no')->select();
        $equNos    = listMoveToArray($equNoList, 'equ_no');
        $arr          = [];
        foreach ($equNos as $equNo) {
            $item = self::where('equ_key_no', $equNo)
                ->order('start_time desc')
                ->limit(1)
                ->find();
            if ($item) {
                array_push($arr, $item);
            }
        }
        return listMoveToArray($arr, 'id');
    }
}