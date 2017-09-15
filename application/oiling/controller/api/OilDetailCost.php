<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 16:43
 */

namespace app\oiling\controller\api;


use app\model\OilDetail;
use app\service\BaseController;
use app\validate\DetailDateValidate;

class OilDetailCost extends BaseController {
    public function getCostListByDate($before, $after) {
        (new DetailDateValidate())->goCheck();
        $temp = OilDetail::getCostList($before, $after);
        return $this->ajaxReturn('success', 0, $temp);
    }
}