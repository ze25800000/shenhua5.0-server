<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8 0008
 * Time: 10:17
 */

namespace app\validate;


class EquipmentKeyNoValidate extends BaseValidate {
    protected $rule = [
        'equ_key_no' => 'require|isPositiveInt'
    ];

}