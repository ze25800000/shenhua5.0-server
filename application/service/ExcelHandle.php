<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 15:20
 */

namespace app\service;

use app\lib\exception\DocumentException;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
use app\model\OilStandard;
use app\model\WorkHour;
use think\Db;
use app\lib\exception\UploadException;
use think\Request;

class ExcelHandle {
    public static function excelToArray() {
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

    public static function listMoveToArray($arr, $str) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        return $result;
    }

    public static function oilStandard($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = self::listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilStandardIdList  = OilStandard::field('id')->select();
        $idArr              = self::listMoveToArray($oilStandardIdList, 'id');
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                if (!empty($idArr) && !empty($idArr[$k])) {
                    $arr[$k]['id'] = $idArr[$k];
                }
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_oil_no']   = $v[1];
                $arr[$k]['oil_name']     = $v[2];
                $arr[$k]['oil_no']       = $v[3];
                $arr[$k]['quantity']     = $v[4];
                $arr[$k]['unit']         = $v[5];
                $arr[$k]['first_period'] = $v[6];
                $arr[$k]['period']       = $v[7];
                $arr[$k]['interval']     = $v[8];
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

    public static function oilAnalysis($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = self::listMoveToArray($equipmentEquNoList, 'equ_no');
        $oilAnalysisModel   = new OilAnalysis();
        $oilAnalysisIdList  = $oilAnalysisModel::field('id')->select();
        $idArr              = self::listMoveToArray($oilAnalysisIdList, 'id');
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                if (!empty($idArr) && !empty($idArr[$k])) {
                    $arr[$k]['id'] = $idArr[$k];
                }
                $arr[$k]['equ_no']        = $v[0];
                $arr[$k]['equ_oil_no']    = $v[1];
                $arr[$k]['oil_no']        = $v[2];
                $arr[$k]['oil_name']      = $v[3];
                $arr[$k]['sampling_time'] = $v[4];
                $arr[$k]['working']       = $v[5];
                $arr[$k]['part']          = $v[6];
                $arr[$k]['oil_used']      = $v[7];
                $arr[$k]['Fe']            = $v[8];
                $arr[$k]['Cu']            = $v[9];
                $arr[$k]['Pb']            = $v[10];
                $arr[$k]['Al']            = $v[11];
                $arr[$k]['Cr']            = $v[12];
                $arr[$k]['Si']            = $v[13];
                $arr[$k]['Na']            = $v[14];
                $arr[$k]['Mo']            = $v[15];
                $arr[$k]['viscosity']     = $v[16];
                $arr[$k]['fuel_dilution'] = $v[17];
                $arr[$k]['ph']            = $v[18];
                $arr[$k]['h2o']           = $v[19];
                $arr[$k]['pq']            = $v[20];
                $arr[$k]['contaminate']   = $v[21];
                $arr[$k]['status']        = $v[22];
                $arr[$k]['advise']        = $v[23];
                $arr[$k]['result']        = $v[24];
            }
        }
        $result = $oilAnalysisModel->saveAll($arr);
        if (!$result) {
            throw new UploadException([
                'msg' => '上传文件失败，未存入数据库'
            ]);
        }
        return true;
    }

    public static function oilDetail($excel_array) {
        $oilDetailModel  = new OilDetail();
        $oilDetailIdList = $oilDetailModel::field('id')->select();
        $idArr           = self::listMoveToArray($oilDetailIdList, 'id');
        $arr             = [];
        foreach ($excel_array as $k => $v) {
            if (!empty($idArr) && !empty($idArr[$k])) {
                $arr[$k]['id'] = $idArr[$k];
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


    public static function workHour($excel_array) {
        $equipmentModel = Equipment::field('equ_no')->select();
        $equNoArr       = self::listMoveToArray($equipmentModel, 'equ_no');
        $arr            = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_oil_no']   = $v[1];
                $arr[$k]['equ_oil_name'] = $v[2];
                $arr[$k]['working_hour'] = $v[3];
                $arr[$k]['start_time']   = strtotime($v[4]);
            }
        }
        $workHour = new WorkHour();
        $result   = $workHour->saveAll($arr);
        if (!$result) {
            throw new DocumentException([
                'msg' => '上传运行时间文件失败，请检查excel文档'
            ]);
        }
        return true;
    }


    public static function infoWarning($excel_array) {
        $equipmentEquNoList = Equipment::field('equ_no')->select();
        $equNoArr           = self::listMoveToArray($equipmentEquNoList, 'equ_no');
        $workHourList       = WorkHour::all();
        $oilStandardList    = OilStandard::field('equ_no,equ_oil_no,first_period,period')->select();
        $arr                = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']           = $v[0];
                $arr[$k]['equ_oil_no']       = $v[1];
                $arr[$k]['equ_name']         = $v[2];
                $arr[$k]['equ_oil_name']     = $v[3];
                $arr[$k]['del_warning_time'] = strtotime($v[4]);
                $arr[$k]['is_first_period']  = preg_match('/是/', $v[5]) ? 1 : 0;
                $arr[$k]['warning_type']     = preg_match('/润滑/', $v[6]) ? 1 : 0;
                $arr[$k]['postpone']         = empty($v[7]) ? null : $v[7];
                $arr[$k]['how_long']         = self::howLong($workHourList, $arr[$k]);
                $arr[$k]['status']           = self::status($oilStandardList, $arr[$k]);
                $arr[$k]['postpone_reason']  = empty($v[8]) ? null : $v[8];
                $arr[$k]['member']           = empty($v[9]) ? null : $v[9];
                $arr[$k]['oil_no']           = empty($v[10]) ? null : $v[10];
                $arr[$k]['quantity']         = empty($v[11]) ? null : $v[11];
            }
        }
        $infoWarningModel = new InfoWarning();
        $result           = $infoWarningModel->saveAll($arr);
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
    public static function howLong($workHourList, $arr) {
        $howLong = 0;
        foreach ($workHourList as $k => $v) {
            if ($arr['equ_no'] == $v['equ_no'] && $arr['equ_oil_no'] == $v['equ_oil_no']) {
                if ($v['start_time'] > $arr['del_warning_time']) {
                    $howLong += $v['working_hour'];
                }
            }
        }
        return $howLong;
    }

    //$equNo, $equOilNo, $howLong, $isFirstPeriod,$warningType,$postpone
    public static function status($oilStandardList, $arr) {
        $status = 0;
        foreach ($oilStandardList as $k => $v) {
            if ($v['equ_no'] == $arr['equ_no'] && $v['equ_oil_no'] == $arr['equ_oil_no']) {
                //是否处于首保周期equ_oil_no
                if ($arr['is_first_period']) {
                    //如果消警类型为延期，让保养周期和延期时长相加
                    $duration = $arr['warning_type'] ? $v['first_period'] : $v['first_period'] + $arr['postpone'];
                    if ($arr['how_long'] < $duration) {
                        if ($duration - $arr['how_long'] > 300) {
                            //正常
                            $status = 1;
                        } else {
                            //临近
                            $status = 2;
                        }
                    } else {
                        //超期
                        $status = 3;
                    }
                } else {
                    $duration = $arr['warning_type'] ? $v['period'] : $v['period'] + $arr['postpone'];
                    if ($arr['how_long'] < $duration) {
                        if ($duration - $arr['how_long'] > 300) {
                            //正常
                            $status = 1;
                        } else {
                            //临近
                            $status = 2;
                        }
                    } else {
                        //超期
                        $status = 3;
                    }
                }
            }
        }
        return $status;
    }
}