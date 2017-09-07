<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 16:46
 */

namespace app\oiling\controller\api;


use app\model\Equipment;
use app\service\BaseController;
use app\validate\IDMustBePositiveInt;

class Detail extends BaseController {
    public function getEquipmentDetailByNo() {
        (new IDMustBePositiveInt())->goCheck();
        $EquModel = new Equipment();
    }
}