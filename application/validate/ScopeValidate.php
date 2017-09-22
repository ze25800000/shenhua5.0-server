<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/20 0020
 * Time: 9:08
 */

namespace app\validate;


class ScopeValidate extends BaseValidate {
    protected $rule = [
        'id'    => 'require|isPositiveInt',
        'scope' => 'require|in:9,18,36'
    ];
}