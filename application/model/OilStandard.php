<?php

namespace app\model;


class OilStandard extends BaseModel {
    protected $hidden = ['create_time', 'update_time', 'equ_name', 'equ_no', 'equ_oil_no', ''];

    public function infoWarningDetail() {
        return $this->hasMany('InfoWarning', 'equ_key_no', 'equ_key_no');
    }

    public function oilAnalysisList() {
        return $this->hasMany('OilAnalysis', 'equ_key_no', 'equ_key_no');
    }

    public function timeList() {
        return $this->hasMany('WorkHour', 'equ_key_no', 'equ_key_no');
    }
}