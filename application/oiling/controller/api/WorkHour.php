<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/21 0021
 * Time: 17:00
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\lib\tools\Tools;
use app\model\InfoWarning;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\IDMustBePositiveInt;
use app\validate\WorkHourValidate;

class WorkHour extends BaseController {
    public function deleteWorkHourItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $excelHandle  = new ExcelHandle();
        $workHourItem = \app\model\WorkHour::get($id);
        $result       = $workHourItem->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除运行时间失败'
            ]);
        }
        $infoWarning           = InfoWarning::where('equ_key_no', '=', $workHourItem->equ_key_no)
            ->order('del_warning_time desc')
            ->limit(1)
            ->find();
        $howLong               = $excelHandle->howLong($workHourItem->equ_key_no, $infoWarning->del_warning_time);
        $infoWarning->how_long = $howLong;
        $infoWarning->status   = $excelHandle->getStatus($infoWarning, $howLong);
        $infoWarning->deadline = $excelHandle->getDeadline($infoWarning, $howLong);
        $infoWarning->save();
        return $this->ajaxReturn('删除运行时间成功');
    }

    public function addWorkHourItem() {
        (new WorkHourValidate())->goCheck();
        $excelHandle = new ExcelHandle();

        $_POST['equ_key_no'] = $_POST['equ_no'] . config('salt') . $_POST['equ_oil_no'];
        $_POST['start_time'] = Tools::getTimestamp($_POST['start_time']);
        $workHour            = new \app\model\WorkHour($_POST);
        $result              = $workHour->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '添加运行时间失败'
            ]);
        }
        $infoWarning           = InfoWarning::where('equ_key_no', '=', $_POST['equ_key_no'])
            ->order('del_warning_time desc')
            ->limit(1)
            ->find();
        $howLong               = $excelHandle->howLong($_POST['equ_key_no'], $infoWarning->del_warning_time);
        $infoWarning->how_long = $howLong;
        $infoWarning->status   = $excelHandle->getStatus($infoWarning, $howLong);
        $infoWarning->deadline = $excelHandle->getDeadline($infoWarning, $howLong);
        $infoWarning->save();
        return $this->ajaxReturn('添加运行时间成功');
    }
}