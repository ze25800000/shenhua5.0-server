<?php

namespace app\oiling\controller;


use app\model\InfoWarning;
use app\service\BaseController;
use app\service\ExcelHandle;

class Manager extends BaseController {
    public function warning() {
        $WarningMessage = InfoWarning::getWarningMessage();
        $count          = count($WarningMessage);
        $userName       = session('userName');
        $userScope      = session('userScope');
        $account        = session('account');
        $this->assign([
            'userScope'      => $userScope,
            'userName'       => $userName,
            'account'        => $account,
            'warningMessage' => $WarningMessage ? $WarningMessage : 0,
            'count'          => $count
        ]);
        return $this->fetch();
    }

    public function standard() {

    }

    public function uploadExcel() {
        $objExcelHandle = new ExcelHandle();
        $excel_array    = $objExcelHandle->excelToArray();
        $param          = input('get.exceltype');
        switch ($param) {
            case 'workhour':
                $result = $objExcelHandle->workHour($excel_array);
                break;
            case 'infowarning':
                $result = $objExcelHandle->infoWarning($excel_array);
                break;
        }
        if ($result) {
            return $this->ajaxReturn('信息录入成功');
        }
    }
}