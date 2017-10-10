<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 10:59
 */

namespace app\validate\excelArray;


class WorkHourValidate extends ExcelArrayValidate {
    protected $rule = [
        'equ_no'       => 'integer|require',
        'working_hour' => 'integer|require',
        'start_time'   => 'integer|require|isDataExceedNow'
    ];
    protected $message = [
        'equ_no.require'           => '设备编号不能为空',
        'equ_no.integer'           => '设备编号必须为数字',
        'working_hour.integer'     => '运行时间必须为数字',
        'working_hour.require'     => '运行时间不能为空',
        'start_time'               => '起始时间格式有误，格式必须为xxxx年xx月xx日格式，并且不能超过当前时间'
    ];
}