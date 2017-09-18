<?php

namespace app\oiling\controller\api;


use app\lib\tools\Tools;
use app\service\ExcelHandle;
use app\validate\IDCollection;
use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\service\BaseController;
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

    public function getInfoList($page) {
        $info = InfoWarning::getInfoList($page);
        if (!$info) {
            throw new DocumentException([
                'msg' => '获取润滑提示信息失败'
            ]);
        }
        return $this->ajaxReturn('获取润滑提示信息成功', 0, $info);
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
        if ($maxDelTime >= $posts['del_warning_time']) {
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
}