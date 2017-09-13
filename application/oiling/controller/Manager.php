<?php

namespace app\oiling\controller;


use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilStandard;
use app\service\BaseController;
use app\service\ExcelHandle;

class Manager extends BaseController {
    public $userName;
    public $userScope;
    public $account;

    public function __construct() {
        parent::__construct();
        $this->userName  = session('userName');
        $this->userScope = session('userScope');
        $this->account   = session('account');
    }

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
        $this->assign([
            'account' => $this->account,
        ]);
        return $this->fetch();
    }

    public function analysis() {
        $this->assign([
            'account' => $this->account,
        ]);
        return $this->fetch();
    }

    public function oildetail() {
        $this->assign([
            'account' => $this->account,
        ]);
        return $this->fetch();
    }

    public function equdetail($equ_key_no) {
        $result = OilStandard::getEquipmentByKeyNo($equ_key_no);
        if (!$result) {
            throw new DocumentException([
                'msg' => '获取详细数据失败'
            ]);
        }
        $this->assign([
            'account' => $this->account,
            'detail'  => $result
        ]);
        return $this->fetch();
    }
}