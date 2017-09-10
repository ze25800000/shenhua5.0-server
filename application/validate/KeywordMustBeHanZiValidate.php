<?php

namespace app\validate;


class KeywordMustBeHanZiValidate extends BaseValidate {
    protected $rule = [
        'keywork' => 'chsAlpha'
    ];
}