<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 10:52
 */

namespace app\oiling\controller;


use app\service\BaseController;

class User extends BaseController {
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'system']
    ];

    public function center() {
        $this->assign([
            'scope'    => $this->userScope,
            'account'  => $this->account,
            'userName' => $this->userName
        ]);
        return $this->fetch();
    }

    public function system() {
        $this->assign([
            'scope'    => $this->userScope,
            'account'  => $this->account,
            'userName' => $this->userName
        ]);
        return $this->fetch();
    }
}