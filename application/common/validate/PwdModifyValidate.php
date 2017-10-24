<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19 0019
 * Time: 15:46
 */

namespace app\common\validate;


class PwdModifyValidate extends BaseValidate {
    protected $rule = [
        'oldpwd' => 'require|min:6',
        'newpwd' => 'require|min:6'
    ];
}