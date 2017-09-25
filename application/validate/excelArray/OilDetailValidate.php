<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 16:50
 */

namespace app\validate\excelArray;


class OilDetailValidate extends ExcelArrayValidate {
    protected $rule = [
        'oil_no'   => 'require|integer',
        'oil_name' => 'require|chsDash',
        'detail'   => 'require',
        'unit'     => 'require|alpha',
        'price'    => 'require|number',

    ];
    protected $message = [
        'oil_no.require'   => '物料编号不能为空',
        'oil_no.integer'   => '物料编号必须为数字',
        'oil_name.require' => '油品名称不能为空',
        'oil_name.chsDash' => '油品名称只能由汉字、字母、数字和下划线_及破折号-组成',
        'detail'           => '物料描述不能为空',
        'unit.require'     => '单位不能为空',
        'unit.alpha'       => '单位必须使用英文字母',
        'price.require'    => '价格不能为空',
        'price.number'     => '价格必须为数字',
    ];
}