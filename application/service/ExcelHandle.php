<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 15:20
 */

namespace app\service;

use app\model\Equipment;
use app\model\OilStandard;
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

    public static function arrayConvert($arr, $str) {
        $result = [];
        foreach ($arr as $k => $v) {
            array_push($result, $v[$str]);
        }
        return $result;
    }

    public static function oilStandard($excel_array) {
        $temp        = Equipment::field('equ_no')->select();
        $oilTemp     = OilStandard::field('id')->select();
        $equ_no_list = self::arrayConvert($temp, 'equ_no');
        $id_list     = self::arrayConvert($oilTemp, 'id');
        $arr         = [];
        foreach ($excel_array as $k => $v) {
            if (in_array($v[0], $equ_no_list)) {
                if (!empty($id_list)) {
                    $arr[$k]['id'] = $id_list[$k];
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
        return true;
    }
}