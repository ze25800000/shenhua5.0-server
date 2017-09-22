<?php

namespace app\validate;


class UserValidate extends BaseValidate {
    protected $rule = [
        'account'  => 'require|alphaDash|length:3,10',
        'scope'    => 'require|in:9,18,36',
        'name'     => 'require|chs',
        'password' => 'require|alphaNum|length:6,10',
        'phone'    => 'isMobile'
    ];
    protected $message = [
        'phone'    => '请输入正确的手机号码',
        'name'     => '姓名必须为中文',
        'account'  => '账号只能由字母、数字、下划线_和破折号-组成',
        'password' => '密码只能由字母、数字组成，并且位数在6-10之间'
    ];
}