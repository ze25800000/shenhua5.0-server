<?php

namespace app\oiling\controller;


use app\service\BaseController;

class Manager extends BaseController {
    public function warning() {
        return $this->fetch();
    }

    public function facilityList() {
        return $this->fetch();
    }
}