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
use app\validate\OilAnalysisItemValidate;

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

    public function addOilAnalysisItem() {
        (new OilAnalysisItemValidate())->goCheck();
        $excelHandle            = new ExcelHandle();
        $_POST['equ_key_no']    = $_POST['equ_no'] . config('salt') . $_POST['equ_oil_no'];
        $_POST['sampling_time'] = Tools::getTimestamp($_POST['sampling_time']);
        $_POST['work_hour']     = $excelHandle->howLong($_POST['equ_key_no'], $_POST['sampling_time']);
        $_POST['oil_no']        = $excelHandle->getOilNoFromInfo($_POST['equ_key_no']);
        $_POST['oil_status']    = implode('<br>', $excelHandle->getOilStatus($_POST));
        $_POST['advise']        = empty($_POST['oil_status']) ? 1 : 0;
        $OilAnalysis            = new OilAnalysis($_POST);
        $result                 = $OilAnalysis->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '新增油脂分析条目失败'
            ]);
        }
        return $this->ajaxReturn('新增油脂分析条目成功');
    }
}