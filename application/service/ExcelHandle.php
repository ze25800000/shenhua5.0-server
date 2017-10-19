<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 15:20
 */

namespace app\service;

use app\lib\exception\DocumentException;
use app\lib\exception\ParameterException;
use app\lib\exception\UploadException;
use app\lib\tools\Tools;
use app\model\OilConfig;
use app\model\Equipment;
use app\model\InfoWarning;
use app\model\OilAnalysis;
use app\model\OilDetail;
use app\model\OilStandard;
use app\model\OilUsed;
use app\model\WorkHour;
use app\validate\excelArray\ExcelArrayValidate;
use app\validate\excelArray\InfoWarningValidate;
use app\validate\excelArray\OilAnalysisValidate;
use app\validate\excelArray\OilDetailValidate;
use app\validate\excelArray\OilStandardValidate;
use app\validate\excelArray\WorkHourValidate;
use think\Db;
use think\Request;

class ExcelHandle {
    protected $postpone;

    public function __construct() {
        $config         = OilConfig::get(1);
        $this->postpone = $config->postpone;
    }

    public function excelToArray() {
        vendor('PHPExcel');
        $file = Request::instance()->file('excel');
        $info = $file->validate(['ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'upload' . DS . 'excel');
        //数据为空返回错误
        if (empty($info)) {
            throw new UploadException();
        }
        //获取文件名
        $excelPath = $info->getSaveName();
        //上传文件的地址
        $filename = ROOT_PATH . 'public' . DS . 'upload' . DS . 'excel' . DS . $excelPath;

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

    public function downloadExcel($data, $type = 'test.xls') {
        ini_set('max_execution_time', '0');
        vendor('PHPExcel');
        $filename = str_replace('.xls', '', $type) . '.xlsx';
        $phpexcel = new \PHPExcel();
        $phpexcel->getProperties();
//            ->setCreator(session('userName'))
//            ->setLastModifiedBy(session('userName'))
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");
        $phpexcel->getActiveSheet()->fromArray($data);
        $phpexcel->getActiveSheet()->setTitle('Sheet1');
        $phpexcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0 PHPExcel_IOFactory
        $objwriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
        $objwriter->save('php://output');
        exit;
    }

    public function oilStandard($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
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
                $arr[$k]['oil_no']       = $this->saveOilNo($arr[$k]['equ_no'], $arr[$k]['equ_key_no'], $v[4]);
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

    private function saveOilNo($equNo, $equKeyNo, $oilNoStr) {
        db('oil_no_list')->where(['equ_key_no' => $equKeyNo])->delete();
        $oilNos = preg_split('/\\n/', $oilNoStr);
        foreach ($oilNos as $oilNo) {
            db('oil_no_list')->insert(['equ_no' => $equNo, 'equ_key_no' => $equKeyNo, 'oil_no' => $oilNo]);
        }
        return $oilNos[0];
    }

    public function workHour($excel_array) {
        $equipmentModel   = Equipment::field('equ_no')->select();
        $equNoArr         = $this->listMoveToArray($equipmentModel, 'equ_no');
        $workHourModel    = new WorkHour();
        $WorkHourValidate = new WorkHourValidate();
        $arr              = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equNoArr)) {
                $arr[$k]['equ_no']       = $v[0];
                $arr[$k]['equ_name']     = $v[1];
                $arr[$k]['working_hour'] = $v[2];
                $arr[$k]['start_time']   = $this->getTimestamp($v[3]);
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
        $equNos = Tools::listMoveToArray($arr, 'equ_no', false);
        foreach ($equNos as $equNo) {
            $this->changeInfoWarning($equNo);
        }
        return true;
    }


    public function infoWarning($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
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
                $arr[$k]['del_warning_time'] = $this->getTimestamp($v[4]);
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
                if (!empty($arr[$k]['oil_no'])) {
                    $this->saveToOilUsed($arr[$k]);
                }
                $item = $infoWarningModel->field('id')->where("equ_key_no={$arr[$k]['equ_key_no']} and del_warning_time={$arr[$k]['del_warning_time']}")->find();
                if ($item) {
                    $arr[$k]['id'] = $item->id;
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

    public function saveToOilUsed($infoWarning) {
        $OilDetail = OilDetail::where(['oil_no' => $infoWarning['oil_no']])->find();
        $arr       = [
            'equ_key_no'       => $infoWarning['equ_key_no'],
            'del_warning_time' => $infoWarning['del_warning_time'],
            'oil_no'           => $infoWarning['oil_no'],
            'oil_name'         => $OilDetail->oil_name,
            'detail'           => $OilDetail->detail,
            'unit'             => $OilDetail->unit,
            'quantity'         => $infoWarning['quantity'],
            'price'            => $OilDetail->price,
            'cost'             => $OilDetail->price * $infoWarning['quantity'],
        ];
        $OilUsed   = new OilUsed();
        $OilUsed->save($arr);
    }

    public function oilAnalysis($excel_array) {
        $equipmentEquNoList  = Equipment::field('equ_no')->select();
        $equNoArr            = $this->listMoveToArray($equipmentEquNoList, 'equ_no');
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
                $arr[$k]['sampling_time'] = $this->getTimestamp($v[4]);
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

    public function getOilNoFromInfo($equKeyNo) {
        $info = InfoWarning::where('warning_type=1')
            ->where('equ_key_no', '=', $equKeyNo)
            ->field('oil_no')
            ->order('del_warning_time desc')
            ->limit(1)
            ->find();
        return $info['oil_no'];
    }

    public function getOilStatus($OilAnalysisItem) {
        $oilDetail = OilDetail::where(['oil_no' => $OilAnalysisItem['oil_no']])->find();
        if (!$oilDetail) {
            throw new DocumentException([
                'msg' => $OilAnalysisItem['equ_oil_name'] . '该设备没有进行润滑，找不到对应物料编号'
            ]);
        }
        if ($oilDetail->unit == 'L') {
            $oilStatus = [];
            if (!empty($OilAnalysisItem['Fe']) && $OilAnalysisItem['Fe'] > $oilDetail->Fe) array_push($oilStatus, 'Fe元素超标');
            if (!empty($OilAnalysisItem['Cu']) && $OilAnalysisItem['Cu'] > $oilDetail->Cu) array_push($oilStatus, 'Cu元素超标');
            if (!empty($OilAnalysisItem['Al']) && $OilAnalysisItem['Al'] > $oilDetail->Al) array_push($oilStatus, 'Al元素超标');
            if (!empty($OilAnalysisItem['Si']) && $OilAnalysisItem['Si'] > $oilDetail->Si) array_push($oilStatus, 'Si元素超标');
            if (!empty($OilAnalysisItem['Na']) && $OilAnalysisItem['Na'] > $oilDetail->Na) array_push($oilStatus, 'Na元素超标');
            if (!empty($OilAnalysisItem['PQ']) && $OilAnalysisItem['PQ'] > $oilDetail->PQ) array_push($oilStatus, 'PQ值超标');
            if (!empty($OilAnalysisItem['viscosity']) && $OilAnalysisItem['viscosity'] < $oilDetail->viscosity_min) {
                array_push($oilStatus, '粘度偏低');
            } elseif ($OilAnalysisItem['viscosity'] > $oilDetail->viscosity_max) {
                array_push($oilStatus, '粘度偏高');
            }
            return $oilStatus;
        } else {
            return [];
        }
    }


    /**计算距离上次消警的总时长
     *
     */
    public function howLong($infoWarn) {
        $infoWarning = InfoWarning::where("equ_key_no={$infoWarn['equ_key_no']}")->order('del_warning_time desc')->limit(1)->find();
        if (empty($infoWarning->oil_no) && empty($infoWarn['oil_no'])) {
            return 0;
        }
        $oilNo       = empty($infoWarn['oil_no']) ? $infoWarning->oil_no : $infoWarn['oil_no'];
        $OilDetail   = OilDetail::field('unit')->where(['oil_no' => $oilNo])->find();
        $warningType = isset($infoWarn['warning_type']) ? $infoWarn['warning_type'] : $infoWarning->warning_type;
        if (!$OilDetail && $warningType == 1) {
            throw new DocumentException([
                'msg' => '物料编号不存在'
            ]);
        }
        $maxDelTime = InfoWarning::where("equ_key_no={$infoWarn['equ_key_no']} and warning_type=1")->max('del_warning_time');
        $time       = empty($infoWarn['del_warning_time']) ? $infoWarn['sampling_time'] : $infoWarn['del_warning_time'];
        if ($time > $maxDelTime || empty($maxDelTime)) {
            $maxDelTime = $time;
        }
        if ($warningType == 1) {
            if ($OilDetail->unit == 'L') {
                $howLong = WorkHour::where("equ_no={$infoWarn['equ_no']} and start_time>={$maxDelTime}")->sum('working_hour');
                return $howLong ? $howLong : 0;
            } else {
                $howLong = (time() - $maxDelTime) / 60 / 60;
                return $howLong > 0 ? $howLong : 0;
            }
        } else {
            if (!$infoWarning) {
                return 0;
            }
            $OilDetail = OilDetail::field('unit')->where(['oil_no' => $infoWarning->oil_no])->find();
            if (!$OilDetail) {
                return 0;
            }
            if ($OilDetail->unit == 'L') {
                $howLong = WorkHour::where("equ_no={$infoWarn['equ_no']} and start_time>={$maxDelTime}")->sum('working_hour');
                return $howLong ? $howLong : 0;
            } else {
                $howLong = (time() - $maxDelTime) / 60 / 60;
                return $howLong > 0 ? $howLong : 0;
            }
        }
    }

//$equNo, $equOilNo, $howLong, $isFirstPeriod,$warningType,$postpone
    public function getStatus($infoWarn, $howLong) {
        $oilStandardItem = OilStandard::field('first_period,period')->where("equ_key_no='{$infoWarn['equ_key_no']}'")->find();
        //是否处于首保周期
        if ($infoWarn['is_first_period']) {
            //如果消警类型为延期，让保养周期和延期时长相加
            $duration = $infoWarn['warning_type'] ? $oilStandardItem['first_period'] : ($oilStandardItem['first_period'] + $infoWarn['postpone']);
            if ($howLong < $duration) {
                if (($duration - $howLong) > $this->postpone) {
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
            $duration = $infoWarn['warning_type'] ? $oilStandardItem['period'] : $oilStandardItem['period'] + $infoWarn['postpone'];
            if ($howLong < $duration) {
                if (($duration - $howLong) > $this->postpone) {
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

    public function listMoveToArray($arr, $str) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        return array_unique($result);
    }

    private function getTimestamp($time) {
        return strtotime(rtrim(preg_replace('/\"年\"|\"月\"|\"日\"/', '/', $time), '/'));

    }

    public function getDeadline($infoWarn, $howLong) {
        $oilStandardItem = OilStandard::field('period,first_period')
            ->where("equ_key_no={$infoWarn['equ_key_no']}")->find();
        if ($infoWarn['is_first_period']) {
            $long = ($oilStandardItem['first_period'] + (empty($infoWarn['postpone']) ? 0 : $infoWarn['postpone'])) - $howLong;
        } else {
            $long = ($oilStandardItem['period'] + (empty($infoWarn['postpone']) ? 0 : $infoWarn['postpone'])) - $howLong;

        }
        return $long;
    }

    public function changeInfoWarning($equNo) {
        $excelHandle     = new ExcelHandle();
        $sql             = "SELECT *
                             FROM info_warning AS i1
                             WHERE equ_no = $equNo AND del_warning_time = (SELECT max(i2.del_warning_time)
                                     FROM info_warning AS i2
                                     WHERE i1.equ_key_no = i2.equ_key_no)";
        $infoWarningList = Db::query($sql);
        foreach ($infoWarningList as $item) {
            $howLong = $excelHandle->howLong($item);
            InfoWarning::where(['id' => $item['id']])->update([
                'how_long' => $howLong,
                'status'   => $excelHandle->getStatus($item, $howLong),
                'deadline' => $excelHandle->getDeadline($item, $howLong)
            ]);
        }
    }
}