<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13 0013
 * Time: 14:25
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\OilStandard;
use app\service\BaseController;
use app\validate\KeywordMustBeHanZiValidate;

class Search extends BaseController {
    /**搜索功能
     * @param $keyword
     * @return \think\response\Json
     * @throws DocumentException
     */
    public function getEquipmentDetailByKeyWord($keyword) {
        (new KeywordMustBeHanZiValidate())->goCheck();
        $result = OilStandard::where("equ_oil_name like '%{$keyword}%'")->field('equ_key_no,equ_oil_name')->limit(10)->select();
        if (!$result) {
            throw new DocumentException([
                'msg'     => '没有查询结果',
                'code'    => '201',
                'errcode' => '1'
            ]);
        }
        return $this->ajaxReturn('查询成功', 0, $result);
    }
}