<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/21 0021
 * Time: 17:02
 */

namespace app\common\validate;


class WorkHourValidate extends BaseValidate {
    protected $rule = [
        'start_time' => 'require|FDate',
        'working_hour'=>'require|number'
    ];
}