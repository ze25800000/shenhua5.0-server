<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 11:36
 */

namespace app\validate;


class LubricateValidate extends BaseValidate {
    protected $rule = [
        'quantity'         => 'require|isPositiveInt',
        'oil_no'           => 'require|isPositiveInt',
        'del_warning_time' => 'require|FDate'
    ];
}