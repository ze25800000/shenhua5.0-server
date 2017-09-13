<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13 0013
 * Time: 11:36
 */

namespace app\oiling\controller\api;


use app\service\BaseController;
use app\service\ExcelHandle;

class Upload extends BaseController {
    public function uploadExcel() {
        $objExcelHandle = new ExcelHandle();
        $excel_array    = $objExcelHandle->excelToArray();
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