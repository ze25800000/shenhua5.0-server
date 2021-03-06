<?php

namespace app\common\controller;


use app\common\exception\DocumentException;
use think\Controller;
use think\Request;

class BaseController extends Controller {
    protected $userName;
    protected $userScope;
    protected $account;
    protected $user_id;

    public function __construct() {
        parent::__construct();
        $this->userName  = session('userName');
        $this->userScope = session('userScope');
        $this->account   = session('account');
        $this->user_id   = session('user_id');
        $url             = Request::instance()->url();
        if (substr($url, 0, 6) != '/login') {
            $this->isLogin();
        } else {
            return true;
        }
    }

    protected function isLogin() {
        if (!session('?userName')) {
            $this->redirect('/login');
        } else {
            return true;
        }
    }

    private function scope() {
        $userScope = session('userScope');
        if (!$userScope) {
            $this->redirect('/login');
        }
        return $userScope;
    }

    protected function checkAdminScope() {
        if ($this->scope() < config('scope.ADMIN')) {
            if (Request::instance()->isAjax()) {
                throw new DocumentException([
                    'msg' => '权限不够'
                ]);
            } else {
                $this->error('权限不够');
            }
        } else {
            return true;
        }
    }

    protected function checkStaffScope() {
        if ($this->scope() < config('scope.STAFF')) {
            if (Request::instance()->isAjax()) {
                throw new DocumentException([
                    'msg' => '权限不够'
                ]);
            } else {
                $this->error('权限不够');
            }
        } else {
            return true;
        }
    }

    protected function checkCommonScope() {
        if ($this->scope() < config('scope.COMMON')) {
            if (Request::instance()->isAjax()) {
                throw new DocumentException([
                    'msg' => '权限不够'
                ]);
            } else {
                $this->error('权限不够');
            }
        } else {
            return true;
        }
    }

    public function ajaxReturn($msg = '', $errcode = 0, $data = [], $else = []) {
        $arr = [
            'msg'     => $msg,
            'errcode' => $errcode,
            'data'    => $data,
            'else'    => $else
        ];
        if (empty($data)) {
            unset($arr['data']);
        }
        return json($arr, 201);

    }
}