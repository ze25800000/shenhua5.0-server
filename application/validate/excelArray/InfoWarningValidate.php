<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 11:47
 */

namespace app\validate\excelArray;


class InfoWarningValidate extends ExcelArrayValidate {
    protected $rule = [
        'equ_no'           => 'integer|require',
        'equ_oil_no'       => 'integer|require',
        'equ_name'         => 'chsAlphaNum|require',
        'equ_oil_name'     => 'chsAlphaNum|require',
        'del_warning_time' => 'integer|require',
        'is_first_period'  => 'integer|require',
        'warning_type'     => 'integer|require',
        'postpone'         => 'integer',
        'postpone_reason'  => 'chsAlphaNum',
        'oil_no'           => 'integer',
        'quantity'         => 'integer'
    ];
    public $message = [
        'equ_no.require'           => '设备编号不能为空',
        'equ_no.integer'           => '设备编号必须为数字',
        'equ_oil_no.require'       => '润滑点编号必须为数字',
        'equ_oil_no.integer'       => '润滑点编号必须为数字',
        'equ_name.chsAlphaNum'     => '设备名称只能由汉字、字母和数字组成',
        'equ_name.require'         => '设备名称不能为空',
        'equ_oil_name.chsAlphaNum' => '润滑点名称只能由汉字、字母和数字组成',
        'equ_oil_name.require'     => '润滑点名称不能为空',
        'del_warning_time'         => '消警日期格式错误，请在设置单元格格式时，将日期格式设置为xxxx年xx月xx日',
        'is_first_period'          => '是否在首保周期只能填是或否',
        'warning_type'             => '消警类型只能填\'润滑\'或者\'延期\'',
        'postpone'                 => '延期时长只能填写数字',
        'postpone_reason'          => '延期原因只能由汉字、字母和数字组成',
        'oil_no'                   => '物料编号必须为数字',
        'quantity'                 => '用量必须为数字'
    ];
}