<?php

namespace app\oiling\service;

use app\common\exception\DocumentException;
use app\common\model\InfoWarning;
use app\common\model\OilConfig;
use app\common\model\OilDetail;
use app\common\model\OilStandard;
use app\common\model\OilUsed;
use app\common\model\WorkHour;
use think\Db;


class DataHandle {
    public static function howLong($infoWarn) {
        $infoWarning = InfoWarning::where("equ_key_no={$infoWarn['equ_key_no']}")->order('del_warning_time desc')->limit(1)->find();
        if (empty($infoWarning->oil_no) && empty($infoWarn['oil_no'])) {
            return 0;
        }
        $oilNo       = empty($infoWarn['oil_no']) ? $infoWarning->oil_no : $infoWarn['oil_no'];
        $OilDetail   = OilDetail::field('unit')->where(['oil_no' => $oilNo])->find();
        $warningType = isset($infoWarn['warning_type']) ? $infoWarn['warning_type'] : $infoWarning->warning_type;
        if (!$OilDetail && $warningType == 1) {
            throw new DocumentException([
                'msg' => '润滑保养成本里没有物料编号：' . $infoWarn['oil_no']
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

    public static function getStatus($infoWarn, $howLong) {
        $oilStandardItem = OilStandard::field('first_period,period')->where("equ_key_no='{$infoWarn['equ_key_no']}'")->find();
        $config          = OilConfig::get(1);
        $postpone        = $config->postpone;
        //是否处于首保周期
        if ($infoWarn['is_first_period']) {
            //如果消警类型为延期，让保养周期和延期时长相加
            $duration = $infoWarn['warning_type'] ? $oilStandardItem['first_period'] : ($oilStandardItem['first_period'] + $infoWarn['postpone']);
            if ($howLong < $duration) {
                if (($duration - $howLong) > $postpone) {
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
                if (($duration - $howLong) > $postpone) {
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

    public static function getDeadline($infoWarn, $howLong) {
        $oilStandardItem = OilStandard::field('period,first_period')
            ->where("equ_key_no={$infoWarn['equ_key_no']}")->find();
        if ($infoWarn['is_first_period']) {
            $long = ($oilStandardItem['first_period'] + (empty($infoWarn['postpone']) ? 0 : $infoWarn['postpone'])) - $howLong;
        } else {
            $long = ($oilStandardItem['period'] + (empty($infoWarn['postpone']) ? 0 : $infoWarn['postpone'])) - $howLong;

        }
        return $long;
    }

    public static function getOilStatus($OilAnalysisItem) {
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

    public static function getOilNoFromInfo($equKeyNo) {
        $info = InfoWarning::where('warning_type=1')
            ->where('equ_key_no', '=', $equKeyNo)
            ->field('oil_no')
            ->order('del_warning_time desc')
            ->limit(1)
            ->find();
        return $info['oil_no'];
    }

    public static function changeInfoWarning($equNo) {
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

    public static function saveToOilUsed($infoWarning) {
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

    protected function saveOilNo($equNo, $equKeyNo, $oilNoStr, $validate) {
        db('oil_no_list')->where(['equ_key_no' => $equKeyNo])->delete();
        $oilNos = preg_split('/\\n/', $oilNoStr);
        foreach ($oilNos as $oilNo) {
            $validateResult = $validate->scene('oil_no')->check($oilNo);
            db('oil_no_list')->insert(['equ_no' => $equNo, 'equ_key_no' => $equKeyNo, 'oil_no' => $oilNo]);
        }
        return $oilNos[0];
    }


}