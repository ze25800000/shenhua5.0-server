<?php

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\model\OilConfig;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\SystemVariableValidate;
use think\Db;
use think\Exception;
use think\Log;

class System extends BaseController {
    public function editSystemDetail() {
        (new SystemVariableValidate())->goCheck();
        Db::startTrans();
        try {
            $config = OilConfig::get(1);
            $re     = $config->save($_POST);
            if (!empty($_POST['postpone']) && $re) {
                $excelHandle = new ExcelHandle();
                $infoList    = InfoWarning::getInfoList();
                foreach ($infoList as $infoItem) {
                    $infoItem->status = $excelHandle->getStatus($infoItem, $infoItem->how_long);
                    $infoItem->save();
                }
            }
        } catch (Exception $e) {
            Db::rollback();
            Log::record($e);
            throw new DocumentException([
                'msg' => '修改参数失败'
            ]);
        }
        return $this->ajaxReturn('修改参数成功');
    }
}