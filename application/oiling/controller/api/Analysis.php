<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 17:31
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\OilAnalysis;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\IDMustBePositiveInt;

class Analysis extends BaseController {
    public function deleteOilAnalysisItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = OilAnalysis::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除油脂指标分析条目失败'
            ]);
        }
        return $this->ajaxReturn('删除油脂指标分析条目成功');
    }

    public function editOilAnalysisItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $analysis             = OilAnalysis::get($id);
        $excelHandle          = new ExcelHandle();
        $post                 = input('post.');
        $keys                 = array_keys($post);
        $analysis->$keys[0]   = $post[$keys[0]];
        $analysis->oil_status = implode('<br>', $excelHandle->getOilStatus($analysis));

        $result = $analysis->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改详细信息失败'
            ]);
        }
        return $this->ajaxReturn('修改详细信息成功');
    }
}