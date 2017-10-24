<?php

namespace app\common\validate;


class UserModifyValidate extends BaseValidate {
    protected $rule = [
        'id'      => 'require|isPositiveInt',
        'account' => 'alphaDash',
        'scope'   => 'in:9,18,36',
        'name'    => 'chs',
        'phone'   => 'isMobile'
    ];
    protected $message = [
        'phone' => '请输入正确的手机号码',
        'name'  => '姓名必须为中文',
        'account'=>'账号由字母和数字，下划线_及破折号-组成'
    ];
}