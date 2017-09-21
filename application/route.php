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
Route::get('login', 'oiling/index/login');
//登陆验证处理
Route::post('login', 'oiling/index/login');
//退出登录
Route::get('logout', 'oiling/index/logout');

//首页index
Route::get('', 'oiling/index/index');
//警告页面
Route::get('oiling/warning', 'oiling/Manager/warning');

//设备润滑标准
Route::delete('oiling/equipment/del/:id', 'oiling/api.standard/delEquipmentById');
Route::group('oiling/standard', function () {
    Route::get(':equ_no', 'oiling/api.Standard/getStandardByEquNo', [], ['equ_no' => '\d+']);
    Route::post('edititem/:id', 'oiling/api.Standard/editOilStandardDetailById');
    Route::delete('del/:id', 'oiling/api.standard/deleteOilStandardItemById');
    Route::post('add', 'oiling/api.standard/addEquipment');
    Route::get('', 'oiling/Manager/standard');
});

//润滑提示与记录
Route::group('oiling/info', function () {
    Route::delete('del/:id', 'oiling/api.WarningInfo/deleteInfoItemById');
    Route::get('list/:before/:after', 'oiling/api.WarningInfo/getInfoListByDate');
    Route::get('getlist/:page', 'oiling/api.WarningInfo/getInfoList');
    //润滑功能的实现
    Route::post('lubricate', 'oiling/api.WarningInfo/lubricate');
    //延期功能的实现
    Route::post('postpone', 'oiling/api.WarningInfo/postpone');
    //下载已经选中id的润滑提示记录
    Route::get('download/:ids', 'oiling/api.Download/downLoadExcelByIds');
    Route::get('', 'oiling/manager/info');
});

//运行时间
Route::delete('oiling/workhour/del/:id', 'oiling/api.WarningInfo/deleteWorkHourItemById');

//油脂分析
Route::group('oiling/analysis', function () {
    Route::get('list/:before/:after', 'oiling/api.Analysis/getOilAnalysisListByDate');
    Route::delete('del/:id', 'oiling/api.Analysis/deleteOilAnalysisItemById');
    Route::post('edititem/:id', 'oiling/api.Analysis/editOilAnalysisItemById');
    Route::get('download/:ids', 'oiling/api.Download/downLoadExcelByIds');
    Route::get('', 'oiling/Manager/analysis');
});

//设备成本管理
Route::group('oiling/oildetail', function () {
    Route::get('equname/:oil_no', 'oiling/api.OilDetailCost/getEquOilNameByOilNo');
    Route::get('costlist/:before/:after', 'oiling/api.OilDetailCost/getCostListByDate');
    Route::post('edit/:id', 'oiling/api.OilDetailCost/editOilDetailItemById');
    Route::delete('delete/:id', 'oiling/api.OilDetailCost/deleteOilDetailItemById');
    Route::get('', 'oiling/Manager/oildetail');
});

//润滑点详情页
Route::get('oiling/equdetail/:equ_key_no', 'oiling/Manager/equdetail', [], ['equ_key_no' => '\d+']);


Route::group('user', function () {
    Route::post('center/edit/:id', 'oiling/api.Center/editUserDetailById');
    Route::post('center/modpwd', 'oiling/api.Center/modifyPasswordById');
    Route::post('system/varedit', 'oiling/api.System/editSystemDetail');
    Route::delete('system/deluser/:id', 'oiling/api.System/deleteUserById');
    Route::post('system/modscope/:id', 'oiling/api.System/modifyUserScope');
    Route::post('system/addUser', 'oiling/api.System/addUser');
    Route::get('center', 'oiling/User/center');
    Route::get('system', 'oiling/User/system');
});



//报警页面获取报警信息
Route::get('oiling/warning/getlist', 'oiling/api.WarningInfo/getWarningMessage');
//获取对应设备编号的设备标准
//通过通过设备id获取设备详情数据
Route::get('oiling/equ/detail/:equ_key_no', 'oiling/api.detail/getEquipmentDetailByNo');
//润滑提示与消警提示列表页
Route::get('oiling/infolist/getlist/:page', 'oiling/api.WarningInfo/getInfoList');

/*************************************公共功能**************************************/
//搜索设备
Route::get('search/:keyword', 'oiling/api.search/getEquipmentDetailByKeyWord');

//上传基础数据并保存excel到数据库
Route::post('oiling/upload', 'oiling/api.Upload/uploadExcel');
//下载excel


//必须加query：exceltype=workhour|infowarning
Route::get('download/template', 'oiling/api.Download/downloadTemplate');
//test
Route::get('detail/:equ_key_no', 'oiling/manager/detail');


