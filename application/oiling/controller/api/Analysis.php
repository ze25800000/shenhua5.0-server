<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 17:31
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\lib\tools\Tools;
use app\model\OilAnalysis;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\DetailDateValidate;
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
        $analysis    = OilAnalysis::get($id);
        $excelHandle = new ExcelHandle();
        $post        = input('post.');
        $keys        = array_keys($post);
        if ($keys[0] == 'sampling_time') {
            $timestamp          = Tools::getTimestamp($post[$keys[0]]);
            $analysis->$keys[0] = $timestamp;
        } else {
            $analysis->$keys[0] = $post[$keys[0]];
        }
        $analysis->oil_status = implode('<br>', $excelHandle->getOilStatus($analysis));
        $analysis->advise     = empty($analysis->oil_status) ? 1 : 0;
        $result               = $analysis->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改详细信息失败'
            ]);
        }
        return $this->ajaxReturn('修改详细信息成功');
    }

    public function getOilAnalysisListByDate($before, $after) {
        (new DetailDateValidate())->goCheck();
        $result = OilAnalysis::getOilAnalysisListByDate($before, $after);
        if (!$result) {
            throw  new DocumentException(['msg' => '通过时间获取油脂分析失败']);
        }
        return $this->ajaxReturn('通过时间获取油脂分析成功', 0, $result);
    }


}