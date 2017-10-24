<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 11:29
 */

namespace app\common\exception;


class UploadException extends BaseException {
    public $code = 401;
    public $msg = '文件上传失败';
    public $errorCode = 1;
}