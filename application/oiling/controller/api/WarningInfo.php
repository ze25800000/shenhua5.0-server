<?php

namespace app\oiling\controller\api;


use app\lib\tools\Tools;
use app\service\ExcelHandle;
use app\validate\IDCollection;
use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\service\BaseController;
use app\validate\LubricateValidate;
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
        $InfoWarningItem           = $infoWarningModel
            ->where('equ_key_no', '=', $posts['equ_key_no'])
            ->where('del_warning_time', '=', $posts['del_warning_time'])
            ->find();
        if ($InfoWarningItem) {
            unset($posts['id']);
            throw new DocumentException([
                'msg' => '润滑操作失败，日期已经存在'
            ]);
        }
        $excelHandle       = new ExcelHandle();
        $posts['how_long'] = $excelHandle->howLong($posts);
        $posts['status']   = $excelHandle->getStatus($posts, $posts['how_long']);
//        $result            = $infoWarningModel->save($posts);
//        if (!$result) {
//            throw new DocumentException([
//                'msg' => '润滑操作失败'
//            ]);
//        }
        return $this->ajaxReturn('润滑操作成功');
    }
}