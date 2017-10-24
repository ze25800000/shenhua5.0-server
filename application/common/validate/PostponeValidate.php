<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 11:36
 */

namespace app\common\validate;


class PostponeValidate extends BaseValidate {
    protected $rule = [
        'postpone'         => 'require|isPositiveInt',
        'postpone_reason'  => 'chsAlpha',
        'del_warning_time' => 'require|FDate',
    ];
}