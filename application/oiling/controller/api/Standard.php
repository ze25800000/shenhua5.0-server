<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 16:09
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\lib\tools\Tools;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilNoList;
use app\model\OilStandard;
use app\model\OilUsed;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\EquipmentNoValidate;
use app\validate\EquipmentValidate;
use app\validate\IDMustBePositiveInt;
use think\Validate;

class Standard extends BaseController {
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'editOilStandardDetailById,deleteOilStandardItemById,addEquipment,delEquipmentById,delEquipmentById']
    ];

    /** 获取设备润滑标准列表
     * @param $equ_no
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function getStandardByEquNo($equ_no) {
        (new EquipmentNoValidate())->goCheck();
        $result = Equipment::getStandardByEquNo($equ_no);
        if (!$result) {
            throw new DocumentException([
                'msg' => '获取设备列表信息失败'
            ]);
        }
        return $this->ajaxReturn('获取设备列表信息成功', 0, $result);
    }

    public function getOilNoByEquNo($equNo) {
        $result = Equipment::getOilNoListByEquNo($equNo);
        return $result;
    }

    public function modifyOilNo() {
        $OilStandard         = OilStandard::get(input('post.id'));
        $OilStandard->oil_no = input('post.oil_no');
        $result              = $OilStandard->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改物料编号失败'
            ]);
        }
        return $this->ajaxReturn('修改物料编号成功');
    }

    /**删除设备润滑标准条目
     * @param $id
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function deleteOilStandardItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $OilStandard = OilStandard::get($id);
        $result      = $OilStandard->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }

    /**添加设备
     * @throws DocumentException
     */
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

    /** 删除设备
     * @param $id
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function delEquipmentById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = Equipment::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }

    /**编辑润滑标准
     * @param $id
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function editOilStandardDetailById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $excelHandle = new ExcelHandle();

        $param       = input('post.');
        $OilStandard = OilStandard::get($id);
        if (!empty($param['period']) || !empty($param['first_period'])) {
            $validate = new Validate([
                'period'       => 'number',
                'first_period' => 'number'
            ]);
            if (!$validate->check($param)) {
                throw new DocumentException([
                    'msg' => '周期必须为数字'
                ]);
            }
            if (!empty($param['period'])) {
                $isFirstPeriod = 0;
            }
            if (!empty($param['first_period'])) {
                $isFirstPeriod = 1;
            }
            $OilStandard->save($param);
            $equKeyNoList = OilStandard::field('equ_key_no')->select();
            $equKeyNos    = Tools::listMoveToArray($equKeyNoList, 'equ_key_no');
            foreach ($equKeyNos as $equKeyNo) {
                $item = InfoWarning::where('equ_key_no', '=', $equKeyNo)
                    ->where('is_first_period', '=', $isFirstPeriod)
                    ->order('del_warning_time desc')
                    ->find();
                if ($item) {
                    $item->how_long = $excelHandle->howLong($item);
                    $item->status   = $excelHandle->getStatus($item, $item->how_long);
                    $item->deadline = $excelHandle->getDeadline($item, $item->how_long);
                    $item->save();
                }
            }

        } else {

            $result = $OilStandard->save($param);
            if (!$result) {
                throw new DocumentException([
                    'msg' => '修改详细信息失败'
                ]);
            }
        }
        return $this->ajaxReturn('修改详细信息成功');
    }
}