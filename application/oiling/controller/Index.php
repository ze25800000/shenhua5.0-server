<?php

namespace app\oiling\controller;


use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\service\BaseController;
use app\model\User;
use think\Request;

class Index extends BaseController {


    public function login() {
        $request = Request::instance();
        if ($request->isPost()) {
            $account  = $_POST['userName'];
            $password = $_POST['pwd'];
            $info     = User::get(['account' => $account]);
            if ($info) {
                if ($info->password === md5($password)) {
                    session('userName', $info->name);
                    session('account', $info->account);
                    session('user_id', $info->id);
                    session('userScope', $info->scope);
                    throw new SuccessMessage([
                        'msg'       => '成功',
                        'code'      => 201,
                        'errorCode' => 0
                    ]);
                } else {
                    throw new UserException([
                        'msg'       => '密码错误',
                        'code'      => 201,
                        'errorCode' => 2
                    ]);
                }
            } else {
                throw new UserException([
                    'msg'       => '用户名错误',
                    'code'      => 201,
                    'errorCode' => 1
                ]);
            }

        } else {
            return $this->fetch();
        }
    }

    public function logout() {
        session(null);
        $this->redirect('/login');
    }

    public function index() {
        $userName  = session('userName');
        $userScope = session('userScope');
        $account   = session('account');
        $this->assign([
            'userScope' => $userScope,
            'userName'  => $userName,
            'account'   => $account
        ]);
        return $this->fetch();
    }
}