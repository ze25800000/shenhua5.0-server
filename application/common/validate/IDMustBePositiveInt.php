<?php

namespace app\common\validate;


class IDMustBePositiveInt extends BaseValidate {
    protected $rule = [
        'id' => 'require|isPositiveInt'
    ];
}