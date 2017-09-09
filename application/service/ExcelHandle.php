<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 15:20
 */

namespace app\service;

use app\lib\exception\DocumentException;
use app\lib\exception\UploadException;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
use app\model\OilStandard;
use app\model\WorkHour;
use think\Request;

class ExcelHandle {
    public function excelToArray() {
        vendor('PHPExcel');
        $file = Request::instance()->file('excel');
        $info = $file->validate(['ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'upload' . DS . 'oilStandard');
        //数据为空返回错误
        if (empty($info)) {
            throw new UploadException();
        }
        //获取文件名
        $exclePath = $info->getSaveName();
        //上传文件的地址
        $filename = ROOT_PATH . 'public' . DS . 'upload' . DS . 'oilStandard' . DS . $exclePath;

        //判断截取文件
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        //区分上传文件格式
        if ($extension == 'xlsx') {
            $objReader   = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
        } else if ($extension == 'xls') {
            $objReader   = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
        }

        $excel_array = $objPHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);
        return $excel_array;
    }


    public function oilStandard($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilStandardIdList  = OilStandard::field('id')->select();
        $ids                = $this->listMoveToArray($oilStandardIdList, 'id');
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                if (!empty($ids) && !empty($ids[$k])) {
                    $arr[$k]['id'] = $ids[$k];
                }
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_oil_no']   = $v[1];
                $arr[$k]['equ_key_no']   = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']     = $v[2];
                $arr[$k]['equ_oil_name'] = $v[3];
                $arr[$k]['oil_no']       = $v[4];
                $arr[$k]['quantity']     = $v[5];
                $arr[$k]['unit']         = $v[6];
                $arr[$k]['first_period'] = $v[7];
                $arr[$k]['period']       = $v[8];
                $arr[$k]['interval']     = $v[9];
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

    public function oilAnalysis($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilAnalysisModel   = new OilAnalysis();
        $oilAnalysisIdList  = $oilAnalysisModel::field('id')->select();
        $ids                = $this->listMoveToArray($oilAnalysisIdList, 'id');
        $simpleTimes        = $this->listMoveToArray($oilAnalysisIdList, 'sampling_time');
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                if (!empty($ids) && !empty($ids[$k]) && in_array($this->getTimestamp($v[5]), $simpleTimes)) {
                    $arr[$k]['id'] = $ids[$k];
                }
                $arr[$k]['equ_no']        = $v[0];
                $arr[$k]['equ_oil_no']    = $v[1];
                $arr[$k]['equ_key_no']    = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']      = $v[2];
                $arr[$k]['equ_oil_name']  = $v[3];
                $arr[$k]['part']          = $v[4];
                $arr[$k]['sampling_time'] = $this->getTimestamp($v[5]);
                $arr[$k]['oil_name']      = $v[6];
                $arr[$k]['oil_no']        = $v[7];
                $arr[$k]['working']       = $v[8];
                $arr[$k]['Fe']            = $v[9];
                $arr[$k]['Cu']            = $v[10];
                $arr[$k]['Pb']            = $v[11];
                $arr[$k]['Al']            = $v[12];
                $arr[$k]['Cr']            = $v[13];
                $arr[$k]['Si']            = $v[14];
                $arr[$k]['Na']            = $v[15];
                $arr[$k]['Mo']            = $v[16];
                $arr[$k]['viscosity']     = $v[17];
                $arr[$k]['fuel_dilution'] = $v[18];
                $arr[$k]['ph']            = $v[19];
                $arr[$k]['h2o']           = $v[20];
                $arr[$k]['pq']            = $v[21];
                $arr[$k]['contaminate']   = $v[22];
                $arr[$k]['status']        = $v[23];
                $arr[$k]['advise']        = $v[24];
                $arr[$k]['result']        = $v[25];
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
        $oilDetailModel  = new OilDetail();
        $oilDetailIdList = $oilDetailModel::field('id')->select();
        $ids             = $this->listMoveToArray($oilDetailIdList, 'id');
        $arr             = [];
        foreach ($excel_array as $k => $v) {
            if (!empty($ids) && !empty($ids[$k])) {
                $arr[$k]['id'] = $ids[$k];
            }
            $arr[$k]['oil_no']   = $v[0];
            $arr[$k]['oil_name'] = $v[1];
            $arr[$k]['detail']   = $v[2];
            $arr[$k]['unit']     = $v[3];
            $arr[$k]['price']    = $v[4];
        }
        $result = $oilDetailModel->saveAll($arr);
        if (!$result) {
            throw new DocumentException([
                'msg' => '润滑保养成本管理 ，录入数据库失败'
            ]);
        }
        return true;
    }


    public function workHour($excel_array) {
        $equipmentModel    = Equipment::field('equ_no')->select();
        $equNoArr          = $this->listMoveToArray($equipmentModel, 'equ_no');
        $workHourModel     = new WorkHour();
        $workHourModelList = $workHourModel::field('id,equ_key_no,start_time')->select();
        $arr               = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_oil_no']   = $v[1];
                $arr[$k]['equ_key_no']   = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_oil_name'] = $v[2];
                $arr[$k]['working_hour'] = $v[3];
                $arr[$k]['start_time']   = $this->getTimestamp($v[4]);
                $item                    = $workHourModel->field('id')->where("equ_key_no={$arr[$k]['equ_key_no']} and start_time={$arr[$k]['start_time']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
                }
            }
        }
        $result           = $workHourModel->saveAll($arr);
        $equKeyNo         = $this->listMoveToArray($arr, 'equ_key_no');
        $infoWarningModel = new InfoWarning();
        for ($i = 0; $i < count($equKeyNo); $i++) {
            $oilStandardItem = OilStandard::field('equ_key_no,first_period,period')->where("equ_key_no='{$equKeyNo[$i]}'")->find();
            $infoWarnItem    = $infoWarningModel->where("equ_key_no='{$equKeyNo[$i]}'")->order("del_warning_time DESC")->limit(1)->find();
            $infoWarningModel->save([
                'how_long' => $this->howLong($equKeyNo[$i]),
                'status'   => $this->getStatus($oilStandardItem, $infoWarnItem)
            ], ['equ_key_no' => $infoWarnItem['equ_key_no']]);
        }


        if (!$result) {
            throw new DocumentException([
                'msg' => '上传运行时间文件失败，请检查excel文档'
            ]);
        }
        return true;
    }


    public function infoWarning($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
        $infoWarningModel   = new InfoWarning();
        $infoWarningIdList  = $infoWarningModel::field('id,del_warning_time')->select();
        $workHourList       = WorkHour::all();
        $oilStandardList    = OilStandard::field('equ_key_no,first_period,period')->select();
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']           = $v[0];
                $arr[$k]['equ_oil_no']       = $v[1];
                $arr[$k]['equ_key_no']       = $v[0] . config('salt') . $v[1];
                $arr[$k]['equ_name']         = $v[2];
                $arr[$k]['equ_oil_name']     = $v[3];
                $arr[$k]['del_warning_time'] = $this->getTimestamp($v[4]);
                $arr[$k]['is_first_period']  = preg_match('/是/', $v[5]) ? 1 : 0;
                $arr[$k]['warning_type']     = preg_match('/润滑/', $v[6]) ? 1 : 0;
                $arr[$k]['postpone']         = empty($v[7]) ? null : $v[7];
                $arr[$k]['how_long']         = $this->howLong($workHourList, $arr[$k]);
                $arr[$k]['status']           = $this->getStatus($oilStandardList, $arr[$k]);
                $arr[$k]['postpone_reason']  = empty($v[8]) ? null : $v[8];
                $arr[$k]['user_id']          = session('user_id');
                $arr[$k]['oil_no']           = empty($v[9]) ? null : $v[9];
                $arr[$k]['quantity']         = empty($v[10]) ? null : $v[10];
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
    /**计算距离上次消警的总时长
     *
     */
    //$equNo, $equOilNo, $delWarningTime
    private function howLong($equKeyNo) {
        $sql     = "SELECT SUM(working_hour) AS how_long FROM work_hour WHERE equ_key_no={$equKeyNo} and start_time>(SELECT MAX(del_warning_time) FROM info_warning WHERE equ_key_no={$equKeyNo})";
        $howLong = WorkHour::query($sql);
        return $howLong[0]['how_long'];
    }

    //$equNo, $equOilNo, $howLong, $isFirstPeriod,$warningType,$postpone
    private function getStatus($item, $arr) {
        //是否处于首保周期equ_oil_no
        if ($arr['is_first_period']) {
            //如果消警类型为延期，让保养周期和延期时长相加
            $duration = $arr['warning_type'] ? $item['first_period'] : $item['first_period'] + $arr['postpone'];
            if ($arr['how_long'] < $duration) {
                if ($duration - $arr['how_long'] > 300) {
                    //正常
                    return 1;
                } else {
                    //临近
                    return 2;
                }
            } else {
                //超期
                return 3;
            }
        } else {
            $duration = $arr['warning_type'] ? $item['period'] : $item['period'] + $arr['postpone'];
            if ($arr['how_long'] < $duration) {
                if ($duration - $arr['how_long'] > 300) {
                    //正常
                    return 1;
                } else {
                    //临近
                    return 2;
                }
            } else {
                //超期
                return 3;
            }
        }
    }

    private function listMoveToArray($arr, $str) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        return array_unique($result);
    }

    private function getTimestamp($time) {
        return strtotime(rtrim(preg_replace('/\"年\"|\"月\"|\"日\"/', '/', $time), '/'));

    }


}