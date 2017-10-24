<?php

namespace app\common\model;

class OilStandard extends BaseModel {
    protected $hidden = ['create_time', 'update_time'];

    public function oilNos() {
        return $this->hasMany('OilNoList', 'equ_key_no', 'equ_key_no');
    }

    public function oilNoUnit() {
        return $this->belongsTo('OilDetail', 'oil_no', 'oil_no');
    }

    public function infoWarningDetail() {
        return $this->hasMany('InfoWarning', 'equ_key_no', 'equ_key_no');
    }

    public function oilAnalysisList() {
        return $this->hasMany('OilAnalysis', 'equ_key_no', 'equ_key_no');
    }

    public function timeList() {
        return $this->hasMany('WorkHour', 'equ_no', 'equ_no');
    }

    public static function getEquipmentByKeyNo($equ_key_no) {
        return self::with([
            'oilNoUnit',
            'infoWarningDetail' => function ($query) {
                $query->with(['user'])
                    ->order('del_warning_time', 'desc')
                    ->order('create_time desc');
            },
            'oilAnalysisList'   => function ($query) {
                $query->order('sampling_time', 'desc')
                    ->order('create_time desc');
            },
            'timeList'          => function ($query) {
                $query->order('start_time desc');
            }
        ])->where('equ_key_no', '=', $equ_key_no)->find();
    }

    public static function getOilStandardListByKeyword($keyword) {
        $result = self::where('equ_oil_name', 'LIKE', "%$keyword%")
            ->select();
        return $result;
    }
}