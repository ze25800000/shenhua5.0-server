<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 14:29
 */

namespace app\common\exception;


class SuccessMessage extends BaseException {
    public $code = 201;
    public $msg = '成功';
    public $errorCode = 0;
}