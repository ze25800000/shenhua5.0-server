<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13 0013
 * Time: 14:25
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
use app\model\OilStandard;
use app\service\BaseController;
use app\validate\KeywordMustBeHanZiValidate;
use think\Request;

class Search extends BaseController {
    public function getListByKeyword($keyword) {
        $url = Request::instance()->url();
        preg_match('/oiling\/(\w+)\/search/', $url, $matches);
        $type = $matches[1];
        switch ($type) {
            case 'standard':
                $result = OilStandard::getOilStandardListByKeyword($keyword);
                break;
            case 'info':
                $result = InfoWarning::getInfoWarningListByKeyword($keyword);
                break;
            case 'analysis':
                $result = OilAnalysis::getOilAnalysisListByKeyword($keyword);
                break;
            case 'oildetail':
                $result = OilDetail::getOilDetailListByKeyword($keyword);
                break;
        }
        if (!$result) {
            throw new DocumentException([
                'msg' => '通过关键字获取列表信息失败'
            ]);
        }
        return $this->ajaxReturn('通过关键字获取列表信息成功', 0, $result);
    }
}