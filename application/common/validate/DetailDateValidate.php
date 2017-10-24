<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 16:49
 */

namespace app\common\validate;


class DetailDateValidate extends BaseValidate {
    protected $rule = [
        'before' => 'require|isPositiveInt',
        'after'  => 'require|isPositiveInt',
    ];
}