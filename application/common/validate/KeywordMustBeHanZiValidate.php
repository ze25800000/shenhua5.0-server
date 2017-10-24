<?php

namespace app\common\validate;


class KeywordMustBeHanZiValidate extends BaseValidate {
    protected $rule = [
        'keywork' => 'chsAlpha'
    ];
}