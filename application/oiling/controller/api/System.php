<?php

namespace app\oiling\controller\api;


use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilConfig;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\SystemVariableValidate;

class System extends BaseController {
    public function editSystemDetail() {
        (new SystemVariableValidate())->goCheck();
        $config      = OilConfig::get(1);
        $re          = $config->save($_POST);
        $excelHandle = new ExcelHandle();
        if ($re && !empty($_POST['postpone'])) {
            $infoList = InfoWarning::getInfoList();
            foreach ($infoList as $infoItem) {
                $infoItem->status = $excelHandle->getStatus($infoItem, $infoItem->how_long);
                $infoItem->save();
            }
        }
        if ($re &&
            !empty($_POST['Fe']) ||
            !empty($_POST['Cu']) ||
            !empty($_POST['Al']) ||
            !empty($_POST['Si']) ||
            !empty($_POST['Na']) ||
            !empty($_POST['pq']) ||
            !empty($_POST['viscosity_max']) ||
            !empty($_POST['viscosity_min'])
        ) {
            $oilAnalysisList = OilAnalysis::getAnalysisList();
            foreach ($oilAnalysisList as $oilAnalysisItem) {
                unset($oilAnalysisItem['oil_no']);
                unset($oilAnalysisItem['oil_name']);
                $oilAnalysisItem->oil_status = implode('<br>', $excelHandle->getOilStatus($oilAnalysisItem));
                $oilAnalysisItem->save();
            }
        }
//            Log::record($e);
        return $this->ajaxReturn('修改参数成功');
    }
}