<?php
$data=array(
    0=>array('one'=>34,'two'=>'d'),
    1=>array('one'=>45,'two'=>'e'),
    2=>array('one'=>47,'two'=>'h'),
    3=>array('one'=>12,'two'=>'c'),
    4=>array('one'=>15,'two'=>'w'),
    5=>array('one'=>85,'two'=>'r'),
);

var_dump(array_column($data,'one'));
 array_multisort(array_column($data, 'one'), SORT_DESC, $data);
var_dump($data);