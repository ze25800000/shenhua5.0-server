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
Route::get('manager/document', 'user/manager/oilDocumentManager');
Route::get('manager/member', 'user/manager/member');


//用户信息管理
//通过id获取用户信息，进行编辑
Route::get('user/edit/:id', 'user/manager/getUserById');
Route::post('user/update', 'user/manager/updateUserById');
Route::post('user/add', 'user/manager/addUser');
Route::delete('user/delete', 'user/manager/deleteUserById');

//对设备进行操作
Route::get('document/equipment/getlist', 'user/manager/getEquipmentList');
Route::post('document/equipment/add', 'user/manager/addEquipment');
//Route::post('document/equipment/edit/:id', 'user/manager/editEquipmentByNo');
Route::delete('document/equipment/del/:equ_no', 'user/manager/deleteEquipmentByNo');

//操作润滑标准
Route::get('document/oilstandard/getlist/', 'user/manager/getOilStandardListByNo');
Route::delete('document/oilstandard/delete_equ/:equ_no', 'user/manager/deleteEquipmentByNo');
Route::post('document/oilstandard/edititem/:id', 'user/manager/editOilStandardDetailById');
Route::delete('document/oilstandard/del/:id', 'user/manager/delOilStandardItemById');

//上传保存excel到数据库
Route::post('document/oil/upload', 'user/manager/uploadExcel');


