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
use think\Db;

class WorkHour extends BaseController {
    public function deleteWorkHourItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $workHourItem = \app\model\WorkHour::get($id);
        $result       = $workHourItem->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除运行时间失败'
            ]);
        }
        $this->changeInfoWarning($workHourItem->equ_no);
        return $this->ajaxReturn('删除运行时间成功');
    }

    public function addWorkHourItem() {
        (new WorkHourValidate())->goCheck();

        $_POST['start_time'] = Tools::getTimestamp($_POST['start_time']);
        $workHour            = new \app\model\WorkHour($_POST);
        $result              = $workHour->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '添加运行时间失败'
            ]);
        }
        $equNo            = $_POST['equ_no'];
        $this->changeInfoWarning($equNo);
        return $this->ajaxReturn('添加运行时间成功');
    }

    private function changeInfoWarning($equNo) {
        $excelHandle      = new ExcelHandle();
        $sql              = "SELECT *
                             FROM info_warning AS i1
                             WHERE equ_no = $equNo AND del_warning_time = (SELECT max(i2.del_warning_time)
                                     FROM info_warning AS i2
                                     WHERE i1.equ_key_no = i2.equ_key_no)";
        $infoWarningList  = Db::query($sql);
        foreach ($infoWarningList as $item) {
            $howLong = $excelHandle->howLong($item);
            InfoWarning::where(['id' => $item['id']])->update([
                'how_long' => $howLong,
                'status'   => $excelHandle->getStatus($item, $howLong),
                'deadline' => $excelHandle->getDeadline($item, $howLong)
            ]);
        }
    }
}