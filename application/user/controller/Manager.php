<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 14:51
 */

namespace app\user\controller;


use app\lib\exception\UserException;
use app\service\BaseController;
use app\user\model\User;
use app\validate\IDMustBePositiveInt;

class Manager extends BaseController {
    protected $beforeActionList = [
        'checkStaffScope' => ['only' => 'index']
    ];

    public function oilDocumentManager() {
        $userName = session('userName');
        $this->assign('userName', $userName);
        return $this->fetch();
    }

    public function member() {
        $users    = User::select();
        $userName = session('userName');
        $scope    = session('userScope');
        $this->assign('users', $users);
        $this->assign('userName', $userName);
        $this->assign('scope', $scope);
        return $this->fetch();
    }

    public function getUserById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $user = User::find($id);
        if (!$user) {
            throw new UserException([
                'msg' => '用户不存在'
            ]);
        }
        return json([
            'errorcode' => 0,
            'user'      => $user
        ], 201);
    }

    public function updateUserById() {
        (new IDMustBePositiveInt())->goCheck();
        if ($_POST['password']) {
            $_POST['password'] = md5($_POST['password']);
        } else {
            unset($_POST['password']);
        }
        $result = User::update($_POST);
        if (!$result) {
            throw new UserException([
                'msg'       => '更新用户信息失败',
                'errorCode' => 1
            ]);
        }
        return json([
            'errorCode' => 0,
            'msg'       => '用户信息更新成功'
        ], 201);
    }
}