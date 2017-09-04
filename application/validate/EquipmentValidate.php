<?php

namespace app\validate;


class EquipmentValidate extends BaseValidate {
    protected $rule = [
        'equ_no'   => 'require|isPositiveInt',
        'equ_name' => 'require'
    ];
}