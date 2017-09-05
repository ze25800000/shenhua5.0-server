<?php

namespace app\model;


class Equipment extends BaseModel {
    protected $autoWriteTimestamp = true;
    protected $hidden = ['update_time', 'create_time'];

    public function oilStandardList() {
        return $this->hasMany('OilStandard', 'equ_no', 'equ_no');
    }

    public function oilAnalysisList() {
        return $this->hasMany('OilAnalysis', 'equ_no', 'equ_no');
    }
}