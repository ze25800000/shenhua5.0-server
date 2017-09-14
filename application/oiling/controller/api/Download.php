<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 9:38
 */

namespace app\oiling\controller\api;


use app\model\InfoWarning;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\IDCollection;

class Download extends BaseController {
    public function downLoadExcelByIds($ids) {
        (new IDCollection())->goCheck();
        $result    = InfoWarning::getInfoListByIds($ids);
        $excelType = input('get.exceltype');
        switch ($excelType) {
            case 'infowarning':
                $excelTypeCh = '润滑提示与记录';
                $tableHeader = [['设备编号', '润滑点编号', '润滑点名称', '上次消警时间', '消警类型', '运行时长', '延期时长', '当前状态', '是否首保']];
                foreach ($result as $k => &$v) {
                    $v['del_warning_time'] = date('Y年m月d日', $v['del_warning_time']);
                    $v['warning_type']     = $v['warning_type'] ? '润滑' : '延期';
                    $v['status']           = ($v['status'] == 1) ? '正常' : (($v['status'] == 2) ? '临近' : '超期');
                    $v['is_first_period']  = $v['is_first_period'] ? '是' : '否';
                    $v['postpone']         = empty($v['postpone']) ? '' : $v['postpone'];
                    array_push($tableHeader, $result[$k]);
                }
                break;
        }
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($tableHeader, $excelTypeCh);
    }

    public function downloadTemplate() {
        $excelType = input('get.exceltype');
        switch ($excelType) {
            case 'workhour':
                $excelTypeCh = '运行时间';
                $data        = [
                    ['设备编号', '润滑点编号', '润滑点(全称)', '运行时间', '录入时间'],
                    ['100', '1', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2017年1月8日'],
                    ['100', '2', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2017年1月8日'],
                    ['100', '3', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2017年1月8日']
                ];
                break;
            case 'warninginfo':
                $excelTypeCh = '消警记录';
                $data        = [
                    ['设备编号', '润滑点编号', '设备名称', '润滑点(全称)', '消警日期', '是否在首保周期(是|否)', '消警类型(润滑|延期)', '延期时长(选填)', '延期原因(选填)', '物料编号(选填)', '用量(选填)'],
                    ['100', '1', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2017年4月1日', '否','润滑','','','1071231','100'],
                    ['100', '2', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2017年4月1日', '否','润滑','','','1071231','100'],
                    ['100', '3', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2017年4月1日', '是','延期','300','设备维修','',''],
                    ['100', '4', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2017年4月1日', '否','延期','300','设备维修','',''],
                ];
                break;
        }
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($data, $excelTypeCh);

    }
}