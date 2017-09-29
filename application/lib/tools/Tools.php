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

    public static function listMoveToArray($arr, $str, $isUnique = true) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        if ($isUnique) {
            return array_unique($result);
        } else {
            return $result;
        }
    }

    public static function itemArray($item, $count) {
        $arr = [];
        for ($i = 0; $i < $count; $i++) {
            array_push($arr, $item);
        }
        return $arr;
    }
}