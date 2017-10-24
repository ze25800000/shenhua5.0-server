<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19 0019
 * Time: 14:46
 */

namespace app\oiling\controller\api;


use app\common\exception\DocumentException;
use app\common\model\User;
use app\common\controller\BaseController;
use app\common\validate\PwdModifyValidate;
use app\common\validate\UserModifyValidate;

class Center extends BaseController {
    public function editUserDetailById($id) {
        (new UserModifyValidate())->goCheck();
        $detail = new User();
        $result = $detail->save(input('post.'), ['id' => $id]);
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改信息失败'
            ]);
        }
        return $this->ajaxReturn('修改信息成功');
    }

    public function modifyPasswordById() {
        (new PwdModifyValidate())->goCheck();
        $userDetail = User::get(input('post.id'));

        if ($userDetail->password != md5(input('post.oldpwd'))) {
            throw new DocumentException([
                'msg' => '原始密码错误'
            ]);
        }
        $userDetail->password = md5(input('post.newpwd'));

        $result = $userDetail->save();
        if (!$result) {
            throw new DocumentException([
                'msg' => '修改密码失败'
            ]);
        }
        return $this->ajaxReturn('修改密码成功');
    }
}