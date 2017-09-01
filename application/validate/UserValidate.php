<?php

namespace app\validate;


class UserValidate extends BaseValidate {
    protected $rule = [
        'account'  => 'require|alphaDash',
        'scope'    => 'require|in:9,18,36',
        'name'     => 'require|chs',
        'phone'    => 'isMobile'
    ];
    protected $message = [
        'phone'    => '请输入正确的手机号码',
        'name'     => '姓名必须为中文'
    ];
}