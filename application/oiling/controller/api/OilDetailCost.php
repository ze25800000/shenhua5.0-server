<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 16:43
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\model\OilDetail;
use app\service\BaseController;
use app\validate\DetailDateValidate;
use app\validate\IDMustBePositiveInt;

class OilDetailCost extends BaseController {
    public function getCostListByDate($before, $after) {
        (new DetailDateValidate())->goCheck();
        $temp = OilDetail::getCostList($before, $after);
        return $this->ajaxReturn('success', 0, $temp);
    }

    public function editOilDetailItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $model  = OilDetail::get($id);
        $result = $model->save($_POST);
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改润滑成本管理失败'
            ]);
        }
        return $this->ajaxReturn('修改润滑成本管理成功');
    }

    public function getEquOilNameByOilNo($oil_no) {
        $list = InfoWarning::where('oil_no', '=', $oil_no)
            ->field('equ_oil_name,del_warning_time,quantity')
            ->select();
        foreach ($list as &$v) {
            $v['del_warning_time'] = date('Y年m月d日', $v['del_warning_time']);
        }
        if (!$list) {
            throw new DocumentException([
                'msg' => '获取润滑点信息失败'
            ]);
        }
        return $this->ajaxReturn('获取润滑点信息成功', '0', $list);
    }

    public function deleteOilDetailItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = OilDetail::get($id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }
}