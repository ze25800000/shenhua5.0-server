<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14 0014
 * Time: 9:38
 */

namespace app\oiling\controller\api;


use app\lib\exception\DocumentException;
use app\lib\tools\Tools;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
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
                        'Fe'            => $v['Fe'] == 0 ? '0.00' : $v['Fe'],
                        'Cu'            => $v['Cu'] == 0 ? '0.00' : $v['Cu'],
                        'Al'            => $v['Al'] == 0 ? '0.00' : $v['Al'],
                        'Si'            => $v['Si'] == 0 ? '0.00' : $v['Si'],
                        'Na'            => $v['Na'] == 0 ? '0.00' : $v['Na'],
                        'pq'            => $v['pq'] == 0 ? '0.00' : $v['pq'],
                        'viscosity'     => $v['viscosity'] == 0 ? '0.00' : $v['viscosity'],
                        'oil_status'    => str_replace('<br>', '，', $v['oil_status']),
                        'advise'        => $v['advise'] ? '正常使用' : '建议更换',
                    ];
                    array_push($tableHeader, $v);
                }
        }
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($tableHeader, $excelTypeCh);
    }

    public function downloadCostListByDate($before, $after) {
        $beforeDate = date('Y年m月', $before);
        $afterDate  = date('Y年m月', $after);
        switch (input('get.type')) {
            case 'oil':
                $fileName    = $beforeDate . '至' . $afterDate . '保养成本统计结果';
                $costDetails = OilDetail::getCostList($before, $after);
                $total       = Tools::listMoveToArray($costDetails, 'total');
                $cost        = 0;
                foreach ($total as $value) {
                    $cost += $value;
                }
                $content = [[$fileName, '', '', '', '', '', ''], ['物料编号', '油品名称', '物料描述', '单位', '单价(元)', '用量', '总计(元)']];
                foreach ($costDetails as $k => $v) {
                    array_push($content, [$v->oil_no, $v->oil_name, $v->detail, $v->unit, $v->price, $v['how_much'], $v['total']]);
                }
                array_push($content, ['', '', '', '', '', '', $cost]);
                break;
            case 'equ':
                $equNo    = input('get.equ_no');
                $x        = $equNo == 'all' ? '全部设备' : ($equNo . '号设备');
                $fileName = $beforeDate . '至' . $afterDate . $x . '的保养成本统计结果';
                $infoWarn = OilDetail::getEquCostList($before, $after, $equNo);
                $total    = Tools::listMoveToArray($infoWarn, 'total');
                $cost     = 0;
                foreach ($total as $value) {
                    $cost += $value;
                }
                $content = [[$fileName, '', '', '', '', '', '', '', '', ''], ['设备编号', '润滑点编号', '润滑点名称', '物料编号', '物料名称', '物料描述', '单位', '单价(元)', '用量', '总计(元)']];
                foreach ($infoWarn as $k => $v) {
                    array_push($content, [$v['equ_no'], $v['equ_oil_no'], $v['equ_oil_name'], $v['oil_no'], $v['oil_name'], $v['detail'], $v['unit'], $v['price'], $v['how_much'], $v['total']]);
                }
                array_push($content, ['', '', '', '', '', '', '', '', '', $cost]);
                break;
            default:
                break;
        }
        $excelHandle = new ExcelHandle();
        $excelHandle->downloadExcel($content, $fileName);
    }
}