<?php

namespace app\oiling\controller;


use app\service\BaseController;
use app\service\ExcelHandle;

class Manager extends BaseController {
    public function warning() {
        return $this->fetch();
    }

    public function facilityList() {
        return $this->fetch();
    }

    public function uploadExcel() {
        $excel_array = ExcelHandle::excelToArray();
        $param       = input('get.exceltype');
        switch ($param) {
            case 'workhour':
                $result = ExcelHandle::workHour($excel_array);
                break;
            case 'infowarning':
                $result = ExcelHandle::infoWarning($excel_array);
                break;
        }
        if ($result) {
            return $this->ajaxReturn('信息录入成功');
        }
    }
}