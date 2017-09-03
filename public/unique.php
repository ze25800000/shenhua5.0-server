<?php
$arr  = [
    ['一号破碎站', '100'],
    ['一号破碎站', '100'],
    ['一号破碎站', '100'],
    ['一号破碎站', '100'],
    ['一号破碎站', '100'],
    ['二号破碎站', '200'],
    ['二号破碎站', '200'],
    ['二号破碎站', '200'],
    ['二号破碎站', '200'],
    ['二号破碎站', '200'],
];
$a    = [];
$b    = [];
$arr2 = [];
foreach ($arr as $k => $v) {
    array_push($a, $v[0]);
    array_push($b, $v[1]);

}

$result1 = array_unique($a);
$result2 = array_unique($b);

foreach ($result1 as $k => $v) {
    array_push($arr2, ['name' => $result1[$k], 'equ_no' => $result2[$k]]);
}
echo '<pre>';
print_r($arr2);
echo '<pre>';
