<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 14:51
 */

namespace app\user\controller;


use app\lib\exception\DocumentException;
use app\lib\exception\UserException;
use app\model\Equipment;
use app\model\OilStandard;
use app\service\BaseController;
use app\model\User;
use app\service\ExcelHandle;
use app\validate\EquipmentNoValidate;
use app\validate\EquipmentValidate;
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

    public function member() {
        $users    = User::order('scope desc')->select();
        $userName = session('userName');
        $scope    = session('userScope');
        $this->assign('users', $users);
        $this->assign('userName', $userName);
        $this->assign('scope', $scope);
        return $this->fetch();
    }

    public function addEquipment() {
        (new EquipmentValidate())->goCheck();
        $param = Request::instance()->param();
        $sql   = "SELECT * FROM equipment WHERE equ_no={$param['equ_no']} or name='{$param['name']}'";
        $info  = Equipment::execute($sql);
        if ($info) {
            throw new DocumentException([
                'msg' => '设备编号或者设备名称重复，请重新输入'
            ]);
        }
        $result = Equipment::insert($_POST);
        if (!$result) {
            throw new DocumentException([
                'msg' => '添加设备失败'
            ]);
        }
        return $this->ajaxReturn('添加设备成功');
    }

    public function deleteEquipmentByNo($equ_no) {
        (new EquipmentNoValidate())->goCheck();
        $equ_info          = Equipment::where('equ_no', '=', $equ_no)->delete();
        $oil_standard_info = OilStandard::where('equ_no', '=', $equ_no)->delete();
        if ($equ_info) {
            return $this->ajaxReturn('删除设备成功');
        } else {
            throw new DocumentException([
                'msg' => '设备删除失败'
            ]);
        }
    }

    public function uploadExcel() {

        $excel_array = ExcelHandle::excelToArray();
        $param       = Request::instance()->param();
        switch ($param['exceltype']) {
            case 'oilstandard':
                $result = ExcelHandle::oilStandard($excel_array, $param['equ_no']);
                break;
            case 'oilanalysis':
                $result = ExcelHandle::oilAnalysis($excel_array);
                break;
        }
        if ($result) {
            return $this->ajaxReturn('信息录入成功');
        }
    }

    public function getUserById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $user = User::find($id);
        if (!$user) {
            throw new UserException([
                'msg' => '用户不存在'
            ]);
        }
        return $this->ajaxReturn('获取成功', 0, $user);
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
        return $this->ajaxReturn('用户信息更新成功');
    }

    public function addUser() {
        (new UserValidate())->goCheck();
        $result = User::insert($_POST);
        if (!$result) {
            throw new UserException([
                'msg' => '创建用户失败，请创新输入'
            ]);
        }
        return $this->ajaxReturn('创建用户成功');
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
        return $this->ajaxReturn('删除用户成功');
    }
}