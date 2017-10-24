<?php

namespace app\common\exception;


class DocumentException extends BaseException {
    public $code = 401;
    public $msg = '文档配置错误';
    public $errorCode = 1;
}