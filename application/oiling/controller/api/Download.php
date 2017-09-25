<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 9:38
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\service\BaseController;
use app\service\ExcelHandle;
use app\validate\IDCollection;

class Download extends BaseController {
    public function downLoadExcelByIds($ids) {
        (new IDCollection())->goCheck();
        $excelType = input('get.exceltype');
        switch ($excelType) {
            case 'infowarning':
                $excelTypeCh = '润滑提示与记录';
                $infoResult  = InfoWarning::getInfoListByIds($ids);
                $tableHeader = [['设备编号', '润滑点编号', '润滑点名称', '上次消警时间', '消警类型', '运行时长', '延期时长', '当前状态', '是否首保']];
                foreach ($infoResult as $k => &$v) {
                    $v['del_warning_time'] = date('Y年m月d日', $v['del_warning_time']);
                    $v['warning_type']     = $v['warning_type'] ? '润滑' : '延期';
                    $v['status']           = ($v['status'] == 1) ? '正常' : (($v['status'] == 2) ? '临近' : '超期');
                    $v['is_first_period']  = $v['is_first_period'] ? '是' : '否';
                    $v['postpone']         = empty($v['postpone']) ? '' : $v['postpone'];
                    array_push($tableHeader, $infoResult[$k]);
                }
                break;
            case 'oilanalysis':
                $excelTypeCh    = '油脂化验指标分析';
                $AnalysisResult = OilAnalysis::getOilAnalysisByIds($ids);
                $tableHeader    = [['设备编号', '润滑点编号', '润滑点名称', '采样日期', '运行时长', '物料编号', '油品名称', 'Fe', 'Cu', 'Al', 'Si', 'Na', 'PQ', '粘度', '油脂状态', '处理意见']];
                foreach ($AnalysisResult as $k => &$v) {
                    $v = [
                        'equ_no'        => $v['equ_no'],
                        'equ_oil_no'    => $v['equ_oil_no'],
                        'equ_oil_name'  => $v['equ_oil_name'],
                        'sampling_time' => $v['sampling_time'],
                        'work_hour'     => $v['work_hour'] ? $v['work_hour'] : '0',
                        'oil_no'        => $v['oil_no'],
                        'oil_name'      => $v['oil_name'],
                        'Fe'            => $v['Fe'],
                        'Cu'            => $v['Cu'],
                        'Al'            => $v['Al'],
                        'Si'            => $v['Si'],
                        'Na'            => $v['Na'],
                        'pq'            => $v['pq'] ? $v['pq'] : '0',
                        'viscosity'     => $v['viscosity'],
                        'oil_status'    => str_replace('<br>', '，', $v['oil_status']),
                        'advise'        => $v['advise'] ? '正常使用' : '建议更换',
                    ];
                    array_push($tableHeader, $v);
                }
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
                    ['设备编号', '润滑点编号', '润滑点(全称)', '运行时长', '起始日期'],
                    ['100', '1', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2001年3月14日'],
                    ['100', '2', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2001年3月14日'],
                    ['100', '3', '一号破碎站板式给料机左侧电动机前端轴承', '360', '2001年3月14日'],
                ];
                break;
            case 'warninginfo':
                $excelTypeCh = '消警记录';
                $data        = [
                    ['设备编号', '润滑点编号', '设备名称', '润滑点(全称)', '消警日期', '是否在首保周期(是|否)', '消警类型(润滑|延期)', '延期时长(选填)', '延期原因(选填)', '物料编号(选填)', '用量(选填)'],
                    ['100', '1', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2001年3月14日', '否', '润滑', '', '', '1071231', '100'],
                    ['100', '2', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2001年3月14日', '否', '润滑', '', '', '1071231', '100'],
                    ['100', '3', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2001年3月14日', '是', '延期', '300', '设备维修', '', ''],
                    ['100', '4', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2001年3月14日', '否', '延期', '300', '设备维修', '', ''],
                ];
                break;
            case 'oilstandard':
                $excelTypeCh = '设备润滑标准';
                $data        = [
                    ['设备编号', '润滑点编号', '设备名称', '润滑点(全称)', '物料编号', '用量', '单位', '首保周期', '最长保养周期', '采样间隔'],
                    ['100', '1', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500'],
                    ['100', '2', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'L', '500', '3500', '500'],
                    ['100', '3', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500'],
                ];
                break;
            case 'oilanalysis':
                $excelTypeCh = '油脂化验指标';
                $data        = [
                    ['设备编号', '润滑点编号', '设备名称', '润滑点(全称)', '采样时间', 'Fe', 'Cu', 'Al', 'Si', 'Na', 'PQ', '粘度'],
                    ['100', '1', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '2001年3月14日', '12.1', '10.1', '2.54', '2.36', '1.22', '10.2', '15']
                ];
                break;
            case 'oildetail':
                $excelTypeCh = '润滑保养成本';
                $data        = [
                    ['物料编号', '名称', '物料描述', '单位', '单价(元)'],
                    ['10209358', '抗磨液压油', 'DTE 25;VG46;1×208L\美孚', 'L ', '20.56'],
                    ['10209348', '抗磨液压油', 'DTE 10 超凡 15;VG15;1×208L\美孚', 'L ', '20.56']
                ];
                break;
            default:
                throw new DocumentException([
                    'msg' => '没有找到对应的模板文件类型'
                ]);
                break;
        }
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($data, $excelTypeCh);

    }
}