<?php
$arr  = [
    ['oil_name' => '一号破碎站', 'equ_no' => '100'],
    ['oil_name' => '一号破碎站', 'equ_no' => '100'],
    ['oil_name' => '一号破碎站', 'equ_no' => '100'],
    ['oil_name' => '二号破碎站', 'equ_no' => '200'],
    ['oil_name' => '二号破碎站', 'equ_no' => '200'],
    ['oil_name' => '二号破碎站', 'equ_no' => '200'],
];
$a    = [];
$b    = [];
$arr2 = [];
foreach ($arr as $k => $v) {
    array_push($a, $v['oil_name']);
    array_push($b, $v['equ_no']);

}

$result1 = array_unique($a);
$result2 = array_unique($b);

foreach ($result1 as $k => $v) {
    array_push($arr2, ['name' => $result1[$k], 'equ_no' => $result2[$k]]);
}
echo '<pre>';
print_r($arr2);
echo '<pre>';
