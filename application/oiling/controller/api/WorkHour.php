<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/21 0021
 * Time: 17:00
 */

namespace app\oiling\controller\api;


use app\common\exception\DocumentException;
use app\common\model\InfoWarning;
use app\common\controller\BaseController;
use app\common\validate\IDMustBePositiveInt;
use app\common\validate\WorkHourValidate;
use app\oiling\service\DataHandle;
use think\Db;

class WorkHour extends BaseController {
    public function deleteWorkHourItemById($id) {
        (new IDMustBePositiveInt())->goCheck();
        $workHourItem = \app\common\model\WorkHour::get($id);
        $result       = $workHourItem->delete();
        if (!$result) {
            throw new DocumentException([
                'msg' => '删除运行时间失败'
            ]);
        }
        DataHandle::changeInfoWarning($workHourItem->equ_no);
        return $this->ajaxReturn('删除运行时间成功');
    }

    public function addWorkHourItem() {
        (new WorkHourValidate())->goCheck();

        $_POST['start_time'] = getTimestamp($_POST['start_time']);
        $workHour            = new \app\common\model\WorkHour($_POST);
        $result              = $workHour->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '添加运行时间失败'
            ]);
        }
        $equNo = $_POST['equ_no'];
        DataHandle::changeInfoWarning($equNo);
        return $this->ajaxReturn('添加运行时间成功');
    }
}