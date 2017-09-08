<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6 0006
 * Time: 9:36
 */

namespace app\model;


class InfoWarning extends BaseModel {
    protected $visible = ['del_warning_time','status','how_long','warning_type','postpone','postpone_reason','oil_no','quantity','user'];
    public function user() {
        return $this->hasOne('user', 'id', 'user_id');
    }
}