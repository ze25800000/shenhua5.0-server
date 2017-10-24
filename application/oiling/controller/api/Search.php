<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13 0013
 * Time: 14:25
 */

namespace app\oiling\controller\api;


use app\common\exception\DocumentException;
use app\common\model\InfoWarning;
use app\common\model\OilAnalysis;
use app\common\model\OilDetail;
use app\common\model\OilStandard;
use app\common\controller\BaseController;
use app\common\validate\KeywordMustBeHanZiValidate;
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
            return $this->ajaxReturn('没有找到相应内容', 1);
        }
        return $this->ajaxReturn('通过关键字获取列表信息成功', 0, $result);
    }
}