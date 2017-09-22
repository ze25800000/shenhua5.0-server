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
        $OilConfig       = OilConfig::get(1);
        $this->assign([
            'c'       => $OilConfig,
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
        $result    = OilStandard::getEquipmentByKeyNo($equ_key_no);
        $OilConfig = OilConfig::get(1);
        $oilNoList = OilDetail::field('oil_no,oil_name,detail')->select();
        $this->assign([
            'account'   => $this->account,
            'userId'    => $this->user_id,
            'detail'    => $result,
            'scope'     => $this->userScope,
            'c'         => $OilConfig,
            'oilNoList' => $oilNoList
        ]);
        return $this->fetch();
    }

    public function detail($equ_key_no) {
        $result = OilStandard::getEquipmentByKeyNo($equ_key_no);
        return $this->ajaxReturn('success', 0, $result);
    }
}