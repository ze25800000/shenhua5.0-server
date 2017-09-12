<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 16:09
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\OilStandard;
use app\service\BaseController;
use app\validate\EquipmentNoValidate;
use app\validate\EquipmentValidate;
use app\validate\IDMustBePositiveInt;
use app\validate\KeywordMustBeHanZiValidate;

class Standard extends BaseController {
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

    /**搜索功能
     * @param $keyword
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function getEquipmentDetailBySearch($keyword) {
        (new KeywordMustBeHanZiValidate())->goCheck();
        $result = OilStandard::where("equ_oil_name like '%{$keyword}%'")->select();
        if (!$result) {
            throw new DocumentException([
                'msg' => '没有查询结果'
            ]);
        }
        return $this->ajaxReturn('查询成功', 0, $result);
    }

    /**删除设备润滑标准条目
     * @param $id
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function deleteOilStandardItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = OilStandard::where('id', '=', $id)->delete();
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
    public function delOilStandardItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = OilStandard::where('id', '=', $id)->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除失败'
            ]);
        }
        return $this->ajaxReturn('删除成功');
    }
}