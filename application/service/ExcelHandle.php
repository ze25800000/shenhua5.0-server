<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 15:20
 */

namespace app\service;

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
        return $excel_array;
    }

    public static function arrayConvert($arr) {
        $name   = [];
        $equ_no = [];
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($name, $v['equ_no']);
            array_push($equ_no, $v['oil_name']);
        }
        $temp1 = array_unique($name);
        $temp2 = array_unique($equ_no);
        foreach ($temp1 as $k => $v) {
            array_push($result, ['name' => $temp1[$k], 'equ_no' => $temp2[$k]]);
        }
        return $result;
    }

    public static function oilStandard($excel_array) {
//        $equipment_equ_no = Db::name('equipment')->where('equ_no', '=', $equ_no)->find();
//        if (!$equipment_equ_no) {
//            throw new UploadException([
//                'msg' => '该设备编号不存在，请添加新设备后，再上传Excel'
//            ]);
//        }
        $arr = [];
        foreach ($excel_array as $k => $v) {
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
        $arrToEquipment = self::arrayConvert($arr);
        $result         = Db::name('oil_standard')->insertAll($arr);
        $result1        = Db::name('equipment')->insertAll($arrToEquipment);
        if (!$result) {
            throw new UploadException([
                'msg' => '录入数据库失败'
            ]);
        }
        return true;
    }

    public static function oilAnalysis($excel_array) {
        return true;
    }
}