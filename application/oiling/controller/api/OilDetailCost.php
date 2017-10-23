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
use app\model\OilUsed;
use app\service\BaseController;
use app\validate\DetailDateValidate;
use app\validate\IDMustBePositiveInt;
use think\Db;

class OilDetailCost extends BaseController {
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'editOilDetailItemById,deleteOilDetailItemById']
    ];

    public function getCostListByDate($before, $after) {
        (new DetailDateValidate())->goCheck();
        $temp       = OilDetail::getCostList($before, $after, input('get.equ_no'));
        $totalPrice = 0;
        $totals     = listMoveToArray($temp, 'total', false);
        foreach ($totals as $total) {
            $totalPrice += $total;
        }
        return $this->ajaxReturn('success', 0, $temp, $totalPrice);
    }

    public function getEquTotalPriceByDate($before, $after) {
        $equNo      = input('get.equ_no');
        $temp       = OilDetail::getEquCostList($before, $after, $equNo);
        $totalPrice = 0;
        $totals     = listMoveToArray($temp, 'total', false);
        foreach ($totals as $total) {
            $totalPrice += $total;
        }
        $this->result(round($totalPrice, 2));
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

    public function getEquOilNameByOilNo($oil_no, $before, $after) {
        $equNo = input('get.equ_no');
        $equNo = $equNo == 'all' ? null : " AND equ_no={$equNo}";
        $sql   = "SELECT equ_key_no,equ_oil_name,del_warning_time,quantity
                FROM info_warning
                WHERE warning_type=1 AND del_warning_time BETWEEN $before AND $after" . $equNo . ' AND oil_no=' . $oil_no . " 
                ORDER BY equ_no ASC ,equ_oil_no ASC ";
        $list  = Db::query($sql);

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
        $OilDetail = OilDetail::get($id);
        $result    = $OilDetail->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        OilUsed::where([
            'oil_no' => $OilDetail->oil_no
        ])->delete();
        InfoWarning::where([
            'oil_no' => $OilDetail->oil_no
        ])->delete();
        return $this->ajaxReturn('删除成功');
    }
}