<?php

namespace app\common\validate;


class EquipmentNoValidate extends BaseValidate {
    protected $rule = [
        'equ_no'     => 'require|isPositiveInt',
        'equ_oil_no' => 'isPositiveInt'
    ];
}