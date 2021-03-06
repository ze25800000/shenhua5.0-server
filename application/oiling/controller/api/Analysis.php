<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 17:31
 */

namespace app\oiling\controller\api;


use app\common\exception\DocumentException;
use app\common\model\OilAnalysis;
use app\common\controller\BaseController;
use app\common\validate\DetailDateValidate;
use app\common\validate\EquipmentKeyNoValidate;
use app\common\validate\IDMustBePositiveInt;
use app\common\validate\OilAnalysisItemValidate;
use app\oiling\service\DataHandle;
use app\oiling\service\ExcelHandle;
use think\Db;

class Analysis extends BaseController {
    protected $beforeActionList = [
        'checkStaffScope' => ['only' => 'changeAdviseType,deleteOilAnalysisItemById,editOilAnalysisItemById,addOilAnalysisItem']
    ];

    public function changeAdviseType($id) {
        $OilAnalysis         = OilAnalysis::get($id);
        $OilAnalysis->advise = 1;
        $result              = $OilAnalysis->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '取消报警失败'
            ]);
        }
        return $this->ajaxReturn('取消报警成功');
    }

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
        $analysis = OilAnalysis::get($id);
        $post     = input('post.');
        $keys     = array_keys($post);
        if ($keys[0] == 'sampling_time') {
            $timestamp          = getTimestamp($post[$keys[0]]);
            $analysis->$keys[0] = $timestamp;
        } else {
            $analysis->$keys[0] = $post[$keys[0]];
        }
        $analysis->oil_status = implode('<br>', DataHandle:: getOilStatus($analysis));
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
        $_POST['equ_key_no']    = $_POST['equ_no'] . config('salt') . $_POST['equ_oil_no'];
        $_POST['sampling_time'] = getTimestamp($_POST['sampling_time']);
        $_POST['oil_no']        = DataHandle::getOilNoFromInfo($_POST['equ_key_no']);
        $_POST['oil_status']    = implode('<br>', DataHandle::getOilStatus($_POST));
        $_POST['advise']        = empty($_POST['oil_status']) ? 1 : 0;
        $_POST['work_hour']     = DataHandle::howLong($_POST);
        $OilAnalysis            = new OilAnalysis($_POST);
        $MaxSamplingTime        = $OilAnalysis
            ->where('equ_key_no', '=', $_POST['equ_key_no'])
            ->max('sampling_time');
        if ($MaxSamplingTime >= $_POST['sampling_time']) {
            throw new DocumentException([
                'msg' => '输入的采样时间不能小于等于上一次采样时间'
            ]);
        }
        $result = $OilAnalysis->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '新增油脂分析条目失败'
            ]);
        }
        return $this->ajaxReturn('新增油脂分析条目成功');
    }

    public function getElementValues($equ_key_no) {
        (new EquipmentKeyNoValidate())->goCheck();
        $result = OilAnalysis::getElementValues($equ_key_no);
        return $this->ajaxReturn('获取元素成功', 0, $result);
    }
}