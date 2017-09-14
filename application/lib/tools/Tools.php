<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 14:50
 */

namespace app\lib\tools;


class Tools {
    public static function getTimestamp($time) {
        return strtotime(rtrim(preg_replace('/年|月|日/', '/', $time), '/'));

    }

    public static function listMoveToArray($arr, $str) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        return array_unique($result);
    }
}