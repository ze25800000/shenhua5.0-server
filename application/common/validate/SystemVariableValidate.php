<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19 0019
 * Time: 16:40
 */

namespace app\common\validate;


class SystemVariableValidate extends BaseValidate {
    protected $rule = [
        'postpone'      => 'integer',
        'Fe'            => 'number',
        'Cu'            => 'number',
        'Al'            => 'number',
        'Si'            => 'number',
        'Na'            => 'number',
        'PQ'            => 'number',
        'viscosity_max' => 'number',
        'viscosity_min' => 'number',
    ];
}