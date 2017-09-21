<?php

namespace app\oiling\controller\api;


use app\lib\tools\Tools;
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

class WarningInfo extends BaseController {
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
        $posts['del_warning_time'] = Tools::getTimestamp($posts['del_warning_time']);
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
        $posts['how_long'] = $excelHandle->howLong($posts['equ_key_no'], $posts['del_warning_time']);
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
        return $this->ajaxReturn('润滑操作成功');
    }

    public function postpone() {
        (new PostponeValidate())->goCheck();
        $posts                     = input('post.');
        $posts['del_warning_time'] = Tools::getTimestamp($posts['del_warning_time']);
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
        $posts['status']   = $excelHandle->getStatus($posts, $posts['how_long']);
        $posts['deadline'] = $excelHandle->getDeadline($posts, $posts['how_long']);
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

    public function deleteInfoItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = InfoWarning::where('id', '=', $id)
            ->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除消警记录失败'
            ]);
        }
        return $this->ajaxReturn('删除消警记录成功');
    }

    public function deleteWorkHourItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = WorkHour::where('id', '=', $id)
            ->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除运行时间失败'
            ]);
        }
        return $this->ajaxReturn('删除运行时间成功');
    }
}