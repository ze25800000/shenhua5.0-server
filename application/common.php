<?php
function listMoveToArray($arr, $str, $isUnique = true) {
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

function getTimestamp($time) {
    return strtotime(rtrim(preg_replace('/[\"]?年[\"]?|[\"]?月[\"]?|[\"]?日[\"]?/', '/', $time), '/'));

}