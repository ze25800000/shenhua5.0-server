<?php

namespace app\oiling\controller\api;


use app\model\OilAnalysis;
use app\model\OilUsed;
use app\model\WorkHour;
use app\service\ExcelHandle;
use app\validate\DetailDateValidate;
use app\validate\IDCollection;
use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\service\BaseController;
use app\validate\IDMustBePositiveInt;
use app\validate\LubricateValidate;
use app\validate\PostponeValidate;
use think\Config;
use think\Db;
use think\Validate;

class WarningInfo extends BaseController {
    protected $beforeActionList = [
        'checkStaffScope' => ['only' => 'lubricate,postpone,editInfoWarningDetailById,deleteInfoItemById'],
        'checkAdminScope' => ['only' => 'deleteRecentUploadData']
    ];

    public function getWarningMessage() {
        $info = InfoWarning::getWarningMessage();
        if (!$info) {
            throw new DocumentException([
                'msg' => '获取报警信息失败'
            ]);
        }
        return $this->ajaxReturn('获取报警信息成功', 0, $info);
    }

    public function getInfoListByDate($before, $after) {
        (new DetailDateValidate())->goCheck();
        $result = InfoWarning::getInfoListByDate($before, $after);
        if (!$result) {
            throw new DocumentException([
                'msg' => '通过时间获取润滑提示列表失败'
            ]);
        }
        return $this->ajaxReturn('通过时间获取润滑提示列表成功', 0, $result);
    }

    public function lubricate() {
        (new LubricateValidate())->goCheck();
        $posts                     = input('post.');
        $posts['del_warning_time'] = getTimestamp($posts['del_warning_time']) + 86399;
        $posts['equ_key_no']       = $posts['equ_no'] . config('salt') . $posts['equ_oil_no'];
        $infoWarningModel          = new InfoWarning();
        $maxDelTime                = $infoWarningModel
            ->where("equ_key_no={$posts['equ_key_no']}")
            ->max('del_warning_time');
        if ($maxDelTime > $posts['del_warning_time']) {
            throw new DocumentException([
                'msg' => "最近一次消警日期为：" . date('Y年m月d日', $maxDelTime) . "，请输入大于该时间的消警日期"
            ]);
        }
        $excelHandle       = new ExcelHandle();
        $posts['how_long'] = $excelHandle->howLong($posts);
        $posts['status']   = $excelHandle->getStatus($posts, $posts['how_long']);
        $posts['deadline'] = $excelHandle->getDeadline($posts, $posts['how_long']);
        $InfoWarningItem   = $infoWarningModel
            ->where('equ_key_no', '=', $posts['equ_key_no'])
            ->where('del_warning_time', '=', $posts['del_warning_time'])
            ->where('warning_type', '=', '1')
            ->find();
        if (!$InfoWarningItem) {
            unset($posts['id']);
            $result = $infoWarningModel->save($posts);
        } else {
            $result = $infoWarningModel->save($posts, ['id' => $posts['id']]);
        }
        if (!$result) {
            throw new DocumentException([
                'msg' => '润滑操作失败'
            ]);
        }
        $excelHandle->saveToOilUsed($posts);
        $OilAnalysisItem = OilAnalysis::where(['equ_key_no' => $posts['equ_key_no']])->order('sampling_time desc')->find();
        if (!empty($OilAnalysisItem)) {
            $OilAnalysisItem->advise = 1;
            $OilAnalysisItem->save();
        }
        return $this->ajaxReturn('润滑操作成功');
    }

    public function postpone() {
        (new PostponeValidate())->goCheck();
        $posts                     = input('post.');
        $posts['del_warning_time'] = getTimestamp($posts['del_warning_time']);
        $posts['equ_key_no']       = $posts['equ_no'] . config('salt') . $posts['equ_oil_no'];
        $infoWarningModel          = new InfoWarning();
        $maxDelTime                = $infoWarningModel
            ->where("equ_key_no={$posts['equ_key_no']}")
            ->max('del_warning_time');
        if ($maxDelTime > $posts['del_warning_time']) {
            throw new DocumentException([
                'msg' => "最近一次消警日期为：" . date('Y年m月d日', $maxDelTime) . "，请输入大于该时间的消警日期"
            ]);
        }
        $excelHandle       = new ExcelHandle();
        $lastLubricate     = $infoWarningModel
            ->where("equ_key_no={$posts['equ_key_no']}")
            ->where('warning_type=1')
            ->order('del_warning_time desc')
            ->limit(1)
            ->find();
        $posts['how_long'] = $lastLubricate->how_long;
        $posts['status']   = $excelHandle->getStatus($posts, $lastLubricate->how_long);
        $posts['deadline'] = $excelHandle->getDeadline($posts, $lastLubricate->how_long);
        $InfoWarningItem   = $infoWarningModel
            ->where('equ_key_no', '=', $posts['equ_key_no'])
            ->where('del_warning_time', '=', $posts['del_warning_time'])
            ->where('warning_type=0')
            ->find();
        if (!$InfoWarningItem) {
            unset($posts['id']);
            $result = $infoWarningModel->save($posts);
        } else {
            $result = $infoWarningModel->save($posts, ['id' => $posts['id']]);
        }
        if (!$result) {
            throw new DocumentException([
                'msg' => '延期操作失败'
            ]);
        }
        return $this->ajaxReturn('延期操作成功');
    }

    public function editInfoWarningDetailById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $InfoWarningItem = InfoWarning::get($id);
        $excelHandle     = new ExcelHandle();
        $param           = input('post.');
        if (!empty($param['del_warning_time'])) {
            $validate = new Validate([
                'del_warning_time' => '/^\d{4}年\d{1,2}月\d{1,2}日$/'
            ]);
            $re       = $validate->check($param);
            if (!$re) {
                throw new DocumentException([
                    'msg' => '日期格式有误，请输入xxxx年xx月xx日格式的时间'
                ]);
            }
            $param['del_warning_time'] = getTimestamp($param['del_warning_time']);
            $InfoWarningItem->how_long = $excelHandle->howLong($InfoWarningItem->equ_key_no, $param['del_warning_time']);
            $InfoWarningItem->status   = $excelHandle->getStatus($InfoWarningItem, $InfoWarningItem->how_long);
            $InfoWarningItem->deadline = $excelHandle->getDeadline($InfoWarningItem, $InfoWarningItem->how_long);
            $result                    = $InfoWarningItem->save($param);
        }
        if (!empty($param['is_first_period'])) {
            $validate = new Validate([
                'is_first_period' => ['regex' => '/^(是|否)$/']
            ]);
            $re       = $validate->check($param);
            if (!$re) {
                throw new DocumentException([
                    'msg' => '首保周期只能填写\'是\'或\'否\''
                ]);
            }
            $param['is_first_period'] = preg_match('/^是$/', $param['is_first_period']) ? 1 : (preg_match('/^否$/', $param['is_first_period']) ? 0 : null);
            $InfoWarningItem->save($param);
            $InfoWarningItem->status   = $excelHandle->getStatus($InfoWarningItem, $InfoWarningItem->how_long);
            $InfoWarningItem->deadline = $excelHandle->getDeadline($InfoWarningItem, $InfoWarningItem->how_long);
            $result                    = $InfoWarningItem->save($param);
        }
        if (!empty($param['postpone'])) {
            $validate = new Validate([
                'postpone' => 'number'
            ]);
            $re       = $validate->check($param);
            if (!$re) {
                throw new DocumentException([
                    'msg' => '延期时长只能填写数字'
                ]);
            }
            $InfoWarningItem->save($param);
            $param['status']   = $excelHandle->getStatus($InfoWarningItem, $InfoWarningItem->how_long);
            $param['deadline'] = $excelHandle->getDeadline($InfoWarningItem, $InfoWarningItem->how_long);
            $result            = $InfoWarningItem->save($param);
        }
        if (empty($result)) {
            throw new DocumentException([
                'msg' => '修改消警记录失败'
            ]);
        }
        return $this->ajaxReturn('修改消警记录成功');
    }

    public function deleteInfoItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $InfoWarning = InfoWarning::get($id);
        $result      = $InfoWarning->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除消警记录失败'
            ]);
        }
        $res = OilUsed::where([
            'equ_key_no'       => $InfoWarning->equ_key_no,
            'del_warning_time' => $InfoWarning->del_warning_time,
        ])->delete();
        return $this->ajaxReturn('删除消警记录成功');
    }

    public function deleteRecentUploadData() {
        $ids    = InfoWarning::getRecentInfoWarningIds();
        $result = Db::table('info_warning')->delete($ids);
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除最近一次上传的消警记录失败'
            ]);
        }
        return $this->ajaxReturn('删除最近一次上传的消警记录成功');
    }
}