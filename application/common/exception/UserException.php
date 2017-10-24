<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 11:01
 */

namespace app\common\exception;

class UserException extends BaseException {
    public $code = 401;
    public $msg = '用户名或密码错误';
    public $errorCode = 1;
}