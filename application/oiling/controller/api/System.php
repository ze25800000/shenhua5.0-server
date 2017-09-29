<?php

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilConfig;
use app\model\User;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\IDMustBePositiveInt;
use app\validate\ScopeValidate;
use app\validate\SystemVariableValidate;
use app\validate\UserValidate;

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
                $oilAnalysisItem->advise     = empty($oilAnalysisItem->oil_status) ? 1 : 0;
                $oilAnalysisItem->save();
            }
        }
//            Log::record($e);
        return $this->ajaxReturn('修改参数成功');
    }

    public function deleteUserById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = User::where('id', '=', $id)
            ->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除用户失败'
            ]);
        }
        return $this->ajaxReturn('删除用户成功');
    }

    public function modifyUserScope() {
        (new ScopeValidate())->goCheck();
        $user = User::get($_POST['id']);
        if ($user->scope == $_POST['scope']) {
            return;
        }
        $user->scope = $_POST['scope'];
        $result      = $user->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改用户权限失败'
            ]);
        }
        return $this->ajaxReturn('修改用户权限成功');
    }

    public function addUser() {
        (new UserValidate())->goCheck();
        $model = new User();
        $item  = $model->where('account', '=', $_POST['account'])->find();
        if ($item) {
            throw new DocumentException([
                'msg' => '该账号已经存在'
            ]);
        }
        $_POST['password'] = empty($_POST['password']) ? md5('123456') : md5($_POST['password']);
        $result            = $model->save($_POST);
        if (!$result) {
            throw new DocumentException([
                'msg' => '新建用户失败'
            ]);
        }
        return $this->ajaxReturn('新建用户成功');
    }
}