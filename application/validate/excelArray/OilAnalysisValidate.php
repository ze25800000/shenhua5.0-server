<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 16:11
 */

namespace app\validate\excelArray;


class OilAnalysisValidate extends ExcelArrayValidate {
    protected $rule = [
        'equ_no'        => 'integer|require',
        'equ_oil_no'    => 'integer|require',
        'equ_key_no'    => 'isInOilStandardList',
        'equ_name'      => 'chsAlphaNum',
        'equ_oil_name'  => 'chsAlphaNum|require',
        'sampling_time' => 'integer|require',
        'Fe'            => 'number',
        'Cu'            => 'number',
        'Al'            => 'number',
        'Si'            => 'number',
        'Na'            => 'number',
        'PQ'            => 'number',
        'viscosity'     => 'number',
    ];
    protected $message = [
        'equ_no.require'           => '设备编号不能为空',
        'equ_no.integer'           => '设备编号必须为数字',
        'equ_key_no'               => '设备润滑标准中没有找到该设备',
        'equ_oil_no.require'       => '润滑点编号必须为数字',
        'equ_oil_no.integer'       => '润滑点编号必须为数字',
        'equ_name.chsAlphaNum'     => '设备名称只能由汉字、字母和数字组成',
        'equ_name.require'         => '设备名称不能为空',
        'equ_oil_name.chsAlphaNum' => '润滑点名称只能由汉字、字母和数字组成',
        'equ_oil_name.require'     => '润滑点名称不能为空',
        'sampling_time'            => '采样日期格式错误，请在设置单元格格式时，将日期格式设置为xxxx年xx月xx日',
        'Fe'                       => 'Fe元素必须为数字',
        'Cu'                       => 'Cu元素必须为数字',
        'Al'                       => 'Al元素必须为数字',
        'Si'                       => 'Si元素必须为数字',
        'Na'                       => 'Na元素必须为数字',
        'PQ'                       => 'PQ元素必须为数字',
        'viscosity'                => '粘度必须为数字',
    ];

}