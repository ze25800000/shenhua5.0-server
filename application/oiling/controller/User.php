<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 10:52
 */

namespace app\oiling\controller;


use app\common\model\OilConfig;
use app\common\model\OilDetail;
use app\common\controller\BaseController;
use app\common\model\User as UserModel;

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
        $postpone  = OilConfig::get(1);
        $OilDetail = OilDetail::where(['unit' => 'L'])->select();
        $users     = UserModel::order('scope desc')->select();
        $this->assign([
            'users'     => $users,
            'postpone'  => $postpone,
            'oilDetail' => $OilDetail,
            'scope'     => $this->userScope,
            'account'   => $this->account,
            'userName'  => $this->userName
        ]);
        return $this->fetch();
    }
}