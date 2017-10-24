<?php

namespace app\oiling\controller\api;


use app\common\controller\BaseController;
use app\oiling\service\ExcelHandle;

class Upload extends BaseController {
    public function uploadExcel() {
        $objExcelHandle = new ExcelHandle();
        $excel_array    = \Excel::excelToArray();
        $param          = input('get.exceltype');
        switch ($param) {
            case 'oilstandard':
                $result = $objExcelHandle->oilStandard($excel_array);
                break;
            case 'oilanalysis':
                $result = $objExcelHandle->oilAnalysis($excel_array);
                break;
            case 'oildetail':
                $result = $objExcelHandle->oilDetail($excel_array);
                break;
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