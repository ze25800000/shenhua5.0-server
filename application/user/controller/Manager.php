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
use app\model\OilAnalysis;
use app\model\OilDetail;
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

    /****************************对数据录入和用户管理页面渲染******************************************/
    public function oilDocumentManager() {
        $this->assign([
            'oil_standard' => Db::table('oil_standard')->order('equ_oil_no asc')->select(),
            'equ_list'     => Db::table('equipment')->select(),
            'userName'     => session('userName')
        ]);
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

    /*****************************设备管理*************************************************************/


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

    /************************润滑标准管理*******************************************************/
    public function editOilStandardDetailById($id) {
//        (new IDMustBePositiveInt())->goCheck();
        $OilStandard = OilStandard::get($id);
        $result      = $OilStandard->save(input('post.'));
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改详细信息失败'
            ]);
        }
        return $this->ajaxReturn('修改详细信息成功');
    }

    public function delOilStandardItemById($id) {
//        (new IDMustBePositiveInt())->goCheck();
        $result = OilStandard::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }

    public function getOilStandardList() {
        $list = Equipment::with(['oilStandardList'])->select();
        if (!$list) {
            throw new DocumentException([
                'msg' => '获取润滑标准失败'
            ]);
        }
        return $this->ajaxReturn('获得润滑标准成功', 0, $list);
    }

    /******************************excel上传**********************************/
    public function uploadExcel() {

        $excel_array = ExcelHandle::excelToArray();
        $param       = input('get.exceltype');
        switch ($param) {
            case 'oilstandard':
                $result = ExcelHandle::oilStandard($excel_array);
                break;
            case 'oilanalysis':
                $result = ExcelHandle::oilAnalysis($excel_array);
                break;
            case 'oildetail':
                $result = ExcelHandle::oilDetail($excel_array);
        }
        if ($result) {
            return $this->ajaxReturn('信息录入成功');
        }
    }

    /*********************************油液分析报告**********************************************/
    public function getOilAnalysisList() {
        $oil_analysis_list = Equipment::with(['oilAnalysisList'])->select();
        if (!$oil_analysis_list) {
            throw new DocumentException([
                'msg' => '油液分析报告数据读取失败'
            ]);
        }
        return $this->ajaxReturn('读取成功', 0, $oil_analysis_list);
    }

    public function editOilAnalysisDetailById($id) {
        $OilStandard = OilAnalysis::get($id);
        $result      = $OilStandard->save(input('post.'));
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改详细信息失败'
            ]);
        }
        return $this->ajaxReturn('修改详细信息成功');
    }

    public function delOilAnalysisItemById($id) {
        $result = OilAnalysis::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }

    /********************************润滑保养成本管理************************************/
    public function getOilDetailList() {
        $OilDetailList = OilDetail::select();
        if (!$OilDetailList) {
            throw new DocumentException([
                'msg' => '获得列表信息失败'
            ]);
        }
        return $this->ajaxReturn('获得润滑保养成本列表成功', 0, $OilDetailList);
    }

    public function editOilDetailById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $oilDetail = OilDetail::get($id);
        $oilDetail->save(input('post.'));
        if (!$oilDetail) {
            throw new DocumentException([
                'msg' => '修改详细信息失败'
            ]);
        }
        return $this->ajaxReturn('修改详细信息成功');
    }

    public function delOilDetailItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = OilDetail::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }

    /****************************用户操作*****************************************/
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