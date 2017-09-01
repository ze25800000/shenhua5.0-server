<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//登陆login
Route::get('login', 'user/index/login');
//登陆验证处理
Route::post('login', 'user/index/login');
//退出登录
Route::get('logout', 'user/index/logout');

//首页index
Route::get('', 'user/index/index');
//警告页面
Route::get('oiling/warning', 'oiling/manager/warning');
//设备列表
Route::get('oiling/list', 'oiling/manager/facilityList');

//系统管理
Route::get('manager', 'user/manager/index');