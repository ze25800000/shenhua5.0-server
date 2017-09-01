<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 14:51
 */

namespace app\user\controller;


use app\service\BaseController;
use app\user\model\User;

class Manager extends BaseController {
    protected $beforeActionList = [
        'checkStaffScope' => ['only' => 'index']
    ];

    public function index() {
        $users    = User::select();
        $userName = session('userName');
        $this->assign('users', $users);
        $this->assign('userName', $userName);
        return $this->fetch();
    }
}