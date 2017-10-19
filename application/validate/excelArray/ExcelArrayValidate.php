<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 8:32
 */

namespace app\validate\excelArray;


use app\lib\exception\ParameterException;
use app\lib\tools\Tools;
use app\model\OilDetail;
use app\model\OilStandard;
use app\validate\BaseValidate;

class ExcelArrayValidate extends BaseValidate {
    protected $equKeyNos;
    protected $oilNos;

    public function __construct(array $rules = [], array $message = [], array $field = []) {
        parent::__construct($rules, $message, $field);
        $OilDetail       = OilDetail::field('oil_no')->group('oil_no')->select();
        $OilStandard     = OilStandard::field('equ_key_no')->group('equ_key_no')->select();
        $this->equKeyNos = Tools::listMoveToArray($OilStandard, 'equ_key_no');
        $this->oilNos    = Tools::listMoveToArray($OilDetail, 'oil_no');
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