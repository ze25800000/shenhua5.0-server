<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 17:05
 */

namespace app\validate\excelArray;


class OilStandardValidate extends ExcelArrayValidate {
    protected $rule = [
        'equ_no'       => 'integer|require',
        'equ_oil_no'   => 'integer|require',
        'equ_name'     => 'chsAlphaNum|require',
        'equ_oil_name' => 'chsAlphaNum|require',
        'oil_no'       => 'isInOilDetailList',
        'quantity'     => 'require|integer',
//        'unit'         => 'require|alpha',
        'first_period' => 'require|integer',
        'period'       => 'require|integer',
        'interval'     => 'require|integer'
    ];
    protected $message = [
        'equ_no.require'           => '设备编号不能为空',
        'equ_no.integer'           => '设备编号必须为数字',
        'equ_oil_no.require'       => '润滑点编号必须为数字',
        'equ_oil_no.integer'       => '润滑点编号必须为数字',
        'equ_name.chsAlphaNum'     => '设备名称只能由汉字、字母和数字组成',
        'equ_name.require'         => '设备名称不能为空',
        'equ_oil_name.chsAlphaNum' => '润滑点名称只能由汉字、字母和数字组成',
        'equ_oil_name.require'     => '润滑点名称不能为空',
        'oil_no'                   => '物料编号不存在',
        'quantity.require'         => '用量不能为空',
        'quantity.integer'         => '用量必须为数字',
        'unit.require'             => '单位不能为空',
        'unit.alpha'               => '单位必须为字母',
        'first_period.require'     => '首保周期不能为空',
        'first_period.integer'     => '首保周期必须为数字',
        'period.require'           => '最长保养周期不能为空',
        'period.integer'           => '最长保养周期必须为数字',
        'interval.require'         => '采样间隔不能为空',
        'interval.integer'         => '采样间隔必须为数字'
    ];
    protected $scene = [
        'oil_no' => ['oil_no']
    ];
}