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
use app\service\BaseController;
use app\validate\EquipmentNoValidate;

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

}