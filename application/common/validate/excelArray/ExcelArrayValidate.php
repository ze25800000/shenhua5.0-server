<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 8:32
 */

namespace app\common\validate\excelArray;


use app\common\exception\ParameterException;
use app\common\model\Equipment;
use app\common\model\OilDetail;
use app\common\model\OilStandard;
use app\common\validate\BaseValidate;

class ExcelArrayValidate extends BaseValidate {
    protected $equKeyNos;
    protected $oilNos;
    protected $equs;

    public function __construct(array $rules = [], array $message = [], array $field = []) {
        parent::__construct($rules, $message, $field);
        $equipment   = Equipment::field('equ_no')->group('equ_no')->select();
        $OilDetail   = OilDetail::field('oil_no')->group('oil_no')->select();
        $OilStandard = OilStandard::field('equ_key_no')->group('equ_key_no')->select();
        if ($equipment) {
            $this->equs = listMoveToArray($equipment, 'equ_no');
        } else {
            $this->equs = [];
        }
        if ($OilDetail) {
            $this->oilNos = listMoveToArray($OilDetail, 'oil_no');
        } else {
            $this->oilNos = [];
        }
        if ($OilStandard) {
            $this->equKeyNos = listMoveToArray($OilStandard, 'equ_key_no');
        } else {
            $this->equKeyNos = [];
        }
    }

    public function checkExcel($value, $line) {
        $result = $this->check($value);
        if (!$result) {
            $msg = 'excel第' . ($line + 2) . '行：' . $this->error;
            throw new ParameterException([
                'msg' => $msg
            ]);
        }
        return true;
    }

    protected function isDataExceedNow($value) {
        $result = time() - $value;
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isInEquipment($value) {
        if (in_array($value, $this->equs)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isInOilStandardList($value) {
        if (in_array($value, $this->equKeyNos)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isInOilDetailList($value) {
        if (!isset($value)) {
            return true;
        }
        if (in_array($value, $this->oilNos)) {
            return true;
        } else {
            return false;
        }
    }
}