<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 11:51
 */

namespace app\common\exception;


class ForbiddenException extends BaseException {
    public $code = 401;
    public $msg = '没有权限禁止访问';
    public $errorCode = '10000';
}