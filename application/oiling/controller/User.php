<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15 0015
 * Time: 10:52
 */

namespace app\oiling\controller;


use app\service\BaseController;

class User extends BaseController {
    public function user() {
        return $this->fetch();
    }

    public function system() {
        return $this->fetch();
    }
}