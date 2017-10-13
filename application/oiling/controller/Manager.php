<?php

namespace app\oiling\controller;


use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilConfig;
use app\model\OilDetail;
use app\model\OilStandard;
use app\service\BaseController;

class Manager extends BaseController {
    public function warning() {
        $WarningMessage = InfoWarning::getWarningMessage();
        $count          = count($WarningMessage);
        $this->assign([
            'userScope'      => $this->userScope,
            'userName'       => $this->userName,
            'account'        => $this->account,
            'warningMessage' => $WarningMessage ? $WarningMessage : 0,
            'count'          => $count
        ]);
        return $this->fetch();
    }

    public function standard() {
        $list = Equipment::select();
        $this->assign([
            'scope'   => $this->userScope,
            'account' => $this->account,
            'list'    => $list
        ]);
        return $this->fetch();
    }

    public function info() {
        $infoList  = InfoWarning::getInfoList();
        $oilNoList = OilDetail::field('oil_no,oil_name,detail')->select();
        $standard  = OilStandard::field('oil_no')->select();
        $this->assign([
            'scope'         => $this->userScope,
            'userId'        => $this->user_id,
            'account'       => $this->account,
            'infoList'      => $infoList,
            'oilNoList'     => $oilNoList,
            'oilNoStandard' => $standard
        ]);
        return $this->fetch();
    }

    public function analysis() {
        $OilAnalysisList = OilAnalysis::getAnalysisList();
        $OilDetail       = OilDetail::where(['unit' => 'L'])->select();
        $this->assign([
            'norms'   => $OilDetail,
            'OilList' => $OilAnalysisList,
            'scope'   => $this->userScope,
            'account' => $this->account
        ]);
        return $this->fetch();
    }

    public function oildetail() {
        $this->assign([
            'scope'   => $this->userScope,
            'account' => $this->account,
        ]);
        return $this->fetch();
    }

    public function equdetail($equ_key_no) {
        $result      = OilStandard::getEquipmentByKeyNo($equ_key_no);
        $postpone    = OilConfig::get(1);
        $oilNoList   = OilDetail::field('oil_no,oil_name,detail')->select();
        $infoWarning = InfoWarning::where(['equ_key_no' => $equ_key_no])->field('oil_no')->order('del_warning_time desc')->find();
        if ($infoWarning) {
            $OilDetail = OilDetail::where(['oil_no' => $infoWarning->oil_no])->find();
        }
        $this->assign([
            'account'   => $this->account,
            'userId'    => $this->user_id,
            'detail'    => $result,
            'scope'     => $this->userScope,
            'postpone'  => $postpone->postpone,
            'norms'     => empty($OilDetail) ? null : $OilDetail,
            'oilNoList' => $oilNoList
        ]);
        return $this->fetch();
    }

    public function oildetailbyequ() {
        $equs = InfoWarning::field('equ_no,equ_name')->group('equ_no')->select();
        $this->assign([
            'scope'   => $this->userScope,
            'account' => $this->account,
            'equs'    => $equs
        ]);
        return $this->fetch();
    }

    public function detail($equ_key_no) {
        $result = OilStandard::getEquipmentByKeyNo($equ_key_no);
        return $this->ajaxReturn('success', 0, $result);
    }
}