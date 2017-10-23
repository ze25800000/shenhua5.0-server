<?php
$time  = '2017"年"12"月"1"日"';
$time1 = '2018年12月2日';
echo strtotime(rtrim(preg_replace('/[\"]?年[\"]?|[\"]?月[\"]?|[\"]?日[\"]?/', '/', $time1), '/'));