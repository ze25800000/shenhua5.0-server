<?php

namespace app\oiling\service;

use app\common\exception\DocumentException;
use app\common\exception\ParameterException;
use app\common\exception\UploadException;
use app\common\model\Equipment;
use app\common\model\InfoWarning;
use app\common\model\OilAnalysis;
use app\common\model\OilDetail;
use app\common\model\OilStandard;
use app\common\model\WorkHour;
use app\common\validate\excelArray\InfoWarningValidate;
use app\common\validate\excelArray\OilAnalysisValidate;
use app\common\validate\excelArray\OilDetailValidate;
use app\common\validate\excelArray\OilStandardValidate;
use app\common\validate\excelArray\WorkHourValidate;

class ExcelHandle extends DataHandle {
    public function oilStandard($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilStandardModel    = new OilStandard();
        $arr                 = [];
        $OilStandardValidate = new OilStandardValidate();
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_oil_no']   = $v[1];
                $arr[$k]['equ_key_no']   = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']     = $v[2];
                $arr[$k]['equ_oil_name'] = $v[3];
                $arr[$k]['oil_no']       = $this->saveOilNo($arr[$k]['equ_no'], $arr[$k]['equ_key_no'], $v[4], $OilStandardValidate);
                $arr[$k]['quantity']     = $v[5];
                $arr[$k]['first_period'] = $v[6];
                $arr[$k]['period']       = $v[7];
                $arr[$k]['interval']     = $v[8];
                $OilStandardValidate->checkExcel($arr[$k], $k);
                $item = $oilStandardModel->field('id')->where("equ_key_no={$arr[$k]['equ_key_no']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
                }
            }
        }
        $OilStandard = new OilStandard();
        $result      = $OilStandard->saveAll($arr);
        if (!$result) {
            throw new UploadException([
                'msg' => '上传文件失败，未存入数据库'
            ]);
        }
        return true;
    }

    public function workHour($excel_array) {
        $equipmentModel   = Equipment::field('equ_no')->select();
        $equNoArr         = listMoveToArray($equipmentModel, 'equ_no');
        $workHourModel    = new WorkHour();
        $WorkHourValidate = new WorkHourValidate();
        $arr              = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_name']     = $v[1];
                $arr[$k]['working_hour'] = $v[2];
                $arr[$k]['start_time']   = getTimestamp($v[3]);
                $WorkHourValidate->checkExcel($arr[$k], $k);
                $item = $workHourModel->field('id')->where("equ_no={$arr[$k]['equ_no']} and start_time={$arr[$k]['start_time']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
                }
            }
        }
        $result = $workHourModel->saveAll($arr);
        if (!$result) {
            throw new DocumentException([
                'msg' => '保存运行时间失败'
            ]);
        }
        $equNos = listMoveToArray($arr, 'equ_no', false);
        foreach ($equNos as $equNo) {
            $this->changeInfoWarning($equNo);
        }
        return true;
    }

    public function infoWarning($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = listMoveToArray($equipmentEquNoList, 'equ_no');
        $infoWarningModel    = new InfoWarning();
        $arr                 = [];
        $InfoWarningValidate = new InfoWarningValidate();
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']           = $v[0];
                $arr[$k]['equ_oil_no']       = $v[1];
                $arr[$k]['equ_key_no']       = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']         = $v[2];
                $arr[$k]['equ_oil_name']     = $v[3];
                $arr[$k]['del_warning_time'] = getTimestamp($v[4]);
                $arr[$k]['is_first_period']  = preg_match('/^是$/', $v[5]) ? 1 : (preg_match('/^否$/', $v[5]) ? 0 : null);
                $arr[$k]['warning_type']     = preg_match('/^润滑$/', $v[6]) ? 1 : (preg_match('/^延期$/', $v[6]) ? 0 : null);
                if ($arr[$k]['warning_type'] == 1) {
                    if (empty($v[7]) || empty($v[8])) {
                        $msg = 'excel第' . ($k + 2) . '行没有填写物料编号或用量';
                        throw new ParameterException([
                            'msg' => $msg
                        ]);
                    }
                    $arr[$k]['oil_no']   = $v[7];
                    $arr[$k]['quantity'] = $v[8];
                }
                if ($arr[$k]['warning_type'] == 0) {
                    if (empty($v[9])) {
                        $msg = 'excel第' . ($k + 2) . '行没有填写延期时长';
                        throw new ParameterException([
                            'msg' => $msg
                        ]);
                    }
                    $arr[$k]['postpone']        = $v[9];
                    $arr[$k]['postpone_reason'] = empty($v[10]) ? null : $v[10];
                }
                $InfoWarningValidate->checkExcel($arr[$k], $k);
                $arr[$k]['how_long'] = $this->howLong($arr[$k]);
                $arr[$k]['status']   = $this->getStatus($arr[$k], $arr[$k]['how_long']);
                $arr[$k]['deadline'] = $this->getDeadline($arr[$k], $arr[$k]['how_long']);
                $arr[$k]['user_id']  = session('user_id');
                $item                = $infoWarningModel->field('id')->where("equ_key_no={$arr[$k]['equ_key_no']} and del_warning_time={$arr[$k]['del_warning_time']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
                } else {
                    if (!empty($arr[$k]['oil_no'])) {
                        $this->saveToOilUsed($arr[$k]);
                    }
                }
            }
        }
        $result = $infoWarningModel->saveAll($arr);
        if (!$result) {
            throw new DocumentException([
                'msg' => '文档上传失败，请检查excel数据'
            ]);
        }
        return true;
    }

    public function oilAnalysis($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilAnalysisModel    = new OilAnalysis();
        $arr                 = [];
        $OilAnalysisValidate = new OilAnalysisValidate();
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']        = $v[0];
                $arr[$k]['equ_oil_no']    = $v[1];
                $arr[$k]['equ_key_no']    = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']      = $v[2];
                $arr[$k]['equ_oil_name']  = $v[3];
                $arr[$k]['sampling_time'] = getTimestamp($v[4]);
                $arr[$k]['Fe']            = $v[5];
                $arr[$k]['Cu']            = $v[6];
                $arr[$k]['Al']            = $v[7];
                $arr[$k]['Si']            = $v[8];
                $arr[$k]['Na']            = $v[9];
                $arr[$k]['PQ']            = $v[10];
                $arr[$k]['viscosity']     = $v[11];
                $OilAnalysisValidate->checkExcel($arr[$k], $k);
                $arr[$k]['oil_no']     = $this->getOilNoFromInfo($arr[$k]['equ_key_no']);
                $arr[$k]['work_hour']  = $this->howLong($arr[$k]);
                $arr[$k]['oil_status'] = implode('<br>', $this->getOilStatus($arr[$k]));
                $arr[$k]['advise']     = empty($arr[$k]['oil_status']) ? 1 : 0;
                $item                  = $oilAnalysisModel->field('id')->where("equ_key_no={$arr[$k]['equ_key_no']} and sampling_time={$arr[$k]['sampling_time']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
                }
            }
        }
        $result = $oilAnalysisModel->saveAll($arr);
        if (!$result) {
            throw new UploadException([
                'msg' => '上传油脂分析报告文件失败，未存入数据库'
            ]);
        }
        return true;
    }

    public function oilDetail($excel_array) {
        $oilDetailModel    = new OilDetail();
        $arr               = [];
        $OilDetailValidate = new OilDetailValidate();
        foreach ($excel_array as $k => $v) {
            $arr[$k]['oil_no']   = $v[0];
            $arr[$k]['oil_name'] = $v[1];
            $arr[$k]['detail']   = $v[2];
            $arr[$k]['unit']     = trim($v[3]);
            $arr[$k]['price']    = $v[4];
            if ($arr[$k]['unit'] == 'L') {
                $arr[$k]['Fe']            = $v[5];
                $arr[$k]['Cu']            = $v[6];
                $arr[$k]['Al']            = $v[7];
                $arr[$k]['Si']            = $v[8];
                $arr[$k]['Na']            = $v[9];
                $arr[$k]['PQ']            = $v[10];
                $arr[$k]['viscosity_max'] = $v[11];
                $arr[$k]['viscosity_min'] = $v[12];
            }
            $OilDetailValidate->checkExcel($arr[$k], $k);
            $item = $oilDetailModel->field('id')->where("oil_no={$arr[$k]['oil_no']}")->find();
            if ($item) {
                $arr[$k]['id'] = $item->id;
            }
        }
        $result = $oilDetailModel->saveAll($arr);
        if (!$result) {
            throw new DocumentException([
                'msg' => '润滑保养成本管理 ，录入数据库失败'
            ]);
        }
        return true;
    }
}