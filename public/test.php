<?php
$arr = [15.1, 25.2];
$b   = json_encode($arr);
echo $b;
echo "<hr>";
var_dump(json_decode($b)[0]);
var_dump(json_decode($b)[1]);
echo "<hr>";
echo empty("");