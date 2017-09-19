<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 10:52
 */

namespace app\oiling\controller;


use app\model\OilConfig;
use app\service\BaseController;
use app\model\User as UserModel;

class User extends BaseController {
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'system']
    ];

    public function center() {
        $userDetail = UserModel::get($this->user_id);
        $this->assign([
            'userDetail' => $userDetail,
            'scope'      => $this->userScope,
            'account'    => $this->account,
            'userName'   => $this->userName
        ]);
        return $this->fetch();
    }

    public function system() {
        $config = OilConfig::get(1);
        $this->assign([
            'config'   => $config,
            'scope'    => $this->userScope,
            'account'  => $this->account,
            'userName' => $this->userName
        ]);
        return $this->fetch();
    }
}