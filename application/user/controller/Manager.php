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
        $this->assign([
            'oil_standard' => Db::table('oil_standard')->order('equ_oil_no asc')->select(),
            'equ_list'     => Db::table('equipment')->select(),
            'userName'     => session('userName')
        ]);
        return $this->fetch();
    }

    public function oilAnalysisView() {
        $oil_analysis_list = Db::table('oil_analysis')->select();
        if (!$oil_analysis_list) {
            throw new DocumentException([
                'msg' => '油液分析报告数据读取失败'
            ]);
        }
        return $this->ajaxReturn('读取成功', 0, $oil_analysis_list);
    }

    public function addEquipment() {
        (new EquipmentValidate())->goCheck();
        $equ_no   = input('post.equ_no');
        $equ_name = input('post.equ_name');
        $info     = Equipment::where("equ_no='{$equ_no}' or equ_name='{$equ_name}'")->find();
        if ($info) {
            throw new DocumentException([
                'msg' => '您所输入的设备名称或者编号已经存在'
            ]);
        }
        $equ    = new Equipment();
        $result = $equ->save(input('post.'));
        if (!$result) {
            throw new DocumentException([
                'msg' => '添加设备失败'
            ]);
        }
        $this->ajaxReturn('添加设备成功', 0);

    }

    public function getEquipmentList() {
        $list = Equipment::select();
        if (!$list) {
            throw new DocumentException([
                'msg' => '获得设备列表失败'
            ]);
        }
        return $this->ajaxReturn('获得设备列表成功', 0, $list);
    }

    /*public function editEquipmentByNo($id) {
        $edit_equ_no   = input('post.equ_no');
        $edit_equ_name = input('post.equ_name');
        $test          = Equipment::where("equ_no='$edit_equ_no'  equ_name='$edit_equ_name'")->find();
        if ($test) {
            throw new DocumentException([
                'msg' => '该设备编号或者设备名称已经存在'
            ]);
        }
        $equ           = Equipment::get($id);
        $equ->equ_no   = $edit_equ_no;
        $equ->equ_name = $edit_equ_name;
        $result        = $equ->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '编辑设备信息失败'
            ]);
        }
        return $this->ajaxReturn('编辑设备信息成功');
    }*/

    public function deleteEquipmentByNo($equ_no) {
        (new EquipmentNoValidate())->goCheck();
        $equ = Equipment::where("equ_no='$equ_no'")->delete();
        OilStandard::where('equ_no', '=', $equ_no)->delete();
        if (!$equ) {
            throw new DocumentException([
                'msg' => '删除设备失败'
            ]);
        }
        return $this->ajaxReturn('删除设备成功');
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


    public function uploadExcel() {

        $excel_array = ExcelHandle::excelToArray();
        $param       = Request::instance()->param();
        switch ($param['exceltype']) {
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