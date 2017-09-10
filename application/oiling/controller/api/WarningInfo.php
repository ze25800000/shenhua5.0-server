<?php

namespace app\oiling\controller\api;


use app\service\ExcelHandle;
use app\validate\IDCollection;
use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\service\BaseController;

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

    public function downLoadExcelByIds($ids) {
        (new IDCollection())->goCheck();
        $result      = InfoWarning::getInfoListByIds($ids);
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($result, input('get.exceltype'));
    }
}