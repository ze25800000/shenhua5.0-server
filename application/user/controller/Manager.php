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
use app\model\User;
use app\service\ExcelHandle;
use app\validate\IDMustBePositiveInt;
use app\validate\UserValidate;
use app\lib\exception\UploadException;
use think\Request;
use think\Db;

class Manager extends BaseController {
    protected $beforeActionList = [
        'checkStaffScope' => ['only' => 'member,getUserById,updateUserById,addUser,deleteUserById']
    ];

    public function oilDocumentManager() {
        $userName     = session('userName');
        $equ_list     = Db::table('equipment')->select();
        $oil_standard = Db::table('oil_standard')->select();
        $this->assign('oil_standard', $oil_standard);
        $this->assign('equ_list', $equ_list);
        $this->assign('userName', $userName);
        return $this->fetch();
    }

    public function uploadExcel() {

        $excel_array = ExcelHandle::excelToArray();
        $ex_type     = Request::instance()->param();
        switch ($ex_type['exceltype']) {
            case 'oilstandard':
                $result = ExcelHandle::oilStandard($excel_array);
                break;
            case 'oilanalysis':
                $result = ExcelHandle::oilAnalysis($excel_array);
                break;
        }
        if ($result) {
            return $this->ajaxReturn('信息录入成功');
        }
    }

    public function member() {
        $users    = User::order('scope desc')->select();
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
        (new UserValidate())->goCheck();
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

    public function addUser() {
        (new UserValidate())->goCheck();
        $result = User::insert($_POST);
        if (!$result) {
            throw new UserException([
                'msg' => '创建用户失败，请创新输入'
            ]);
        }
        return json([
            'errorCode' => 0,
            'msg'       => '创建用户成功'
        ], 201);
    }

    public function deleteUserById() {
        (new IDMustBePositiveInt())->goCheck();
        $delete = Request::instance()->delete();
        $result = User::where('id', '=', $delete['id'])->delete();
        if (!$result) {
            throw new UserException([
                'msg' => '删除用户失败'
            ]);
        }
        return json([
            'errorCode' => 0,
            'msg'       => '删除用户成功'
        ], 201);
    }
}