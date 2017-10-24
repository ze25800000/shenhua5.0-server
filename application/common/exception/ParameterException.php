<?php

namespace app\common\exception;


class ParameterException extends BaseException {
    public $code = 401;
    public $msg = '参数错误';
    public $errorCode = 2;
}