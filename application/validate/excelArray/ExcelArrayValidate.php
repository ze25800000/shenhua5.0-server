<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 8:32
 */

namespace app\validate\excelArray;


use app\lib\exception\ParameterException;
use app\validate\BaseValidate;

class ExcelArrayValidate extends BaseValidate {
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
}