<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 15:42
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\service\BaseController;

class WarningInfo extends BaseController {
    public function getWarningMessage() {
        $info = InfoWarning::where('status', '>=', 2)->field('equ_oil_name,status')->select();
        if (!$info) {
            throw new DocumentException([
                'msg' => '获取报警信息失败'
            ]);
        }
        return $this->ajaxReturn('获取信息成功', 0, $info);
    }
}