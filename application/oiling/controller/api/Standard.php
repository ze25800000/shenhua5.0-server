<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 16:09
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\OilStandard;
use app\service\BaseController;
use app\validate\EquipmentNoValidate;
use app\validate\KeywordMustBeHanZiValidate;

class Standard extends BaseController {
    public function getStandardByEquNo($equ_no) {
        (new EquipmentNoValidate())->goCheck();
        $EquModel = new Equipment();
        $result   = $EquModel->with(['oilStandardList'])->where('equ_no', '=', $equ_no)->find();
        if (!$result) {
            throw new DocumentException([
                'msg' => '获取设备列表信息失败'
            ]);
        }
        return $this->ajaxReturn('获取设备列表信息成功', 0, $result);
    }

    public function getEquipmentDetailBySearch($keyword) {
        (new KeywordMustBeHanZiValidate())->goCheck();
        $result = OilStandard::where("equ_oil_name like '%{$keyword}%'")->select();
        if (!$result) {
            throw new DocumentException([
                'msg' => '没有查询结果'
            ]);
        }
        return $this->ajaxReturn('查询成功', 0, $result);
    }
}