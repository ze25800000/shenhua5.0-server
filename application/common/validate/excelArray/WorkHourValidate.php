<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 10:59
 */

namespace app\common\validate\excelArray;


class WorkHourValidate extends ExcelArrayValidate {
    protected $rule = [
        'equ_no'       => 'isInEquipment',
        'working_hour' => 'integer|require',
        'start_time'   => 'integer|require|isDataExceedNow'
    ];
    protected $message = [
        'equ_no'               => '设备编号不存在，请先添加设备',
        'working_hour.integer' => '运行时间必须为数字',
        'working_hour.require' => '运行时间不能为空',
        'start_time'           => '起始时间格式有误，格式必须为xxxx年xx月xx日格式，并且不能超过当前时间'
    ];
}