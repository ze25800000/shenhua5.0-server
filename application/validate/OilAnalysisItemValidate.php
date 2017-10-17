<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/21 0021
 * Time: 15:58
 */

namespace app\validate;


class OilAnalysisItemValidate extends BaseValidate {
    protected $rule = [
        'sampling_time' => 'require|FDate',
        'Fe'            => 'require|number',
        'Cu'            => 'require|number',
        'Al'            => 'require|number',
        'Si'            => 'require|number',
        'Na'            => 'require|number',
        'PQ'            => 'require|number',
        'viscosity'     => 'require|number'
    ];
    protected $message = [
        'sampling_time' => '时间格式错误，必须为年XXXX年XX月XX日形式',
        'Fe'            => 'Fe必须为数字',
        'Cu'            => 'Cu必须为数字',
        'Al'            => 'Al必须为数字',
        'Si'            => 'Si必须为数字',
        'Na'            => 'Na必须为数字',
        'PQ'            => 'PQ必须为数字',
        'viscosity'     => 'viscosity必须为数字'
    ];
}