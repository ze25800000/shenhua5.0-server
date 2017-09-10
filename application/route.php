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
Route::get('document/oilstandard/getlist', 'user/manager/getOilStandardList');
Route::delete('document/oilstandard/delete_equ/:equ_no', 'user/manager/deleteEquipmentByNo');
Route::post('document/oilstandard/edititem/:id', 'user/manager/editOilStandardDetailById');
Route::delete('document/oilstandard/del/:id', 'user/manager/delOilStandardItemById');

//油液分析报告
Route::get('document/oilanalysis/getlist', 'user/manager/getOilAnalysisList');
Route::post('document/oilanalysis/edititem/:id', 'user/manager/editOilAnalysisDetailById');
Route::delete('document/oilanalysis/del/:id', 'user/manager/delOilAnalysisItemById');

//润滑油标准、成本管理
Route::get('document/oildetail/getlist', 'user/manager/getOilDetailList');
Route::post('document/oildetail/edititem/:id', 'user/manager/editOilDetailById');
Route::delete('document/oildetail/del/:id', 'user/manager/delOilDetailItemById');

//报警页面获取报警信息
Route::get('oiling/warning/getlist', 'oiling/api.WarningInfo/getWarningMessage');
//获取对应设备编号的设备标准
Route::get('oiling/standard/:equ_no', 'oiling/api.Standard/getStandardByEquNo');
//通过通过设备id获取设备详情数据
Route::get('oiling/equ/detail/:equ_key_no', 'oiling/api.detail/getEquipmentDetailByNo');
//润滑提示与消警提示列表页
Route::get('oiling/infolist/getlist/:page', 'oiling/api.WarningInfo/getInfoList');
//搜索设备
Route::get('oiling/equ/search/:keyword', 'oiling/api.standard/getEquipmentDetailBySearch');


//上传基础数据并保存excel到数据库
Route::post('document/oil/upload', 'user/manager/uploadExcel');
//上传运行时间和润滑提示与润滑记录
Route::post('document/info/upload', 'oiling/manager/uploadExcel');
//下载已经选中id的润滑提示记录
Route::get('document/info/download/:ids', 'oiling/api.WarningInfo/downLoadExcelByIds');



