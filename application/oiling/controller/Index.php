<?php

namespace app\oiling\controller;


use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\model\InfoWarning;
use app\service\BaseController;
use app\model\User;
use app\service\ExcelHandle;
use think\Db;
use think\Request;

class Index extends BaseController {
    public function _initialize() {
        $timeFlag    = cache('timeFlag');
        $excelTools = new ExcelHandle();
        if (!$timeFlag) {
            $sql          = "SELECT *
                             FROM info_warning AS a
                             WHERE del_warning_time = (SELECT max(a1.del_warning_time)
                                                       FROM info_warning AS a1
                                                       WHERE a.del_warning_time = a1.del_warning_time)
                                  AND oil_no = (SELECT d.oil_no
                                                FROM oil_detail AS d
                                                WHERE a.oil_no = d.oil_no AND d.unit = 'KG')";
            $infoWarnings = Db::query($sql);
            foreach ($infoWarnings as &$infoWarning) {
                $howLong = $excelTools->howLong($infoWarning);
                InfoWarning::where(['id' => $infoWarning['id']])->update([
                    'how_long' => $howLong,
                    'status'   => $excelTools->getStatus($infoWarning, $howLong),
                    'deadline' => $excelTools->getDeadline($infoWarning, $howLong)
                ]);
            }
            $resCache = cache('timeFlag', '每隔6小时更新数据库', 21600);
        }
    }

    public function login() {
        $request = Request::instance();
        if ($request->isPost()) {
            $account  = $_POST['userName'];
            $password = $_POST['pwd'];
            $info     = User::get(['account' => $account]);
            if ($info) {
                if ($info->password === md5($password)) {
                    session('userName', $info->name);
                    session('account', $info->account);
                    session('user_id', $info->id);
                    session('userScope', $info->scope);
                    throw new SuccessMessage([
                        'msg'       => '成功',
                        'code'      => 201,
                        'errorCode' => 0
                    ]);
                } else {
                    throw new UserException([
                        'msg'       => '密码错误',
                        'code'      => 201,
                        'errorCode' => 2
                    ]);
                }
            } else {
                throw new UserException([
                    'msg'       => '用户名错误',
                    'code'      => 201,
                    'errorCode' => 1
                ]);
            }

        } else {
            return $this->fetch();
        }
    }

    public function logout() {
        session(null);
        $this->redirect('/login');
    }

    public function index() {
        $this->assign([
            'userScope' => $this->userScope,
            'userName'  => $this->userName,
            'account'   => $this->account
        ]);
        return $this->fetch();
    }
}