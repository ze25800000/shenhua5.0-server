<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 16:46
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\OilStandard;
use app\service\BaseController;
use app\validate\EquipmentKeyNoValidate;

class Detail extends BaseController {
    public function getEquipmentDetailByNo($equ_key_no) {
        (new EquipmentKeyNoValidate())->goCheck();
        $oilStandard = OilStandard::getEquipmentByKeyNo($equ_key_no);
        if (!$oilStandard) {
            throw new DocumentException([
                'msg' => '获得设备详细信息失败'
            ]);
        }
        return $this->ajaxReturn('获得设备详细信息成功', 0, $oilStandard);
    }
}