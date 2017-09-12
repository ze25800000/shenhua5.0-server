<?php

namespace app\model;


class Equipment extends BaseModel {
    protected $autoWriteTimestamp = true;
    protected $hidden = ['update_time'];

    public function oilStandardList() {
        return $this->hasMany('OilStandard', 'equ_no', 'equ_no');
    }

    public function oilAnalysisList() {
        return $this->hasMany('OilAnalysis', 'equ_no', 'equ_no');
    }

    public function statusInfo() {
        return $this->hasMany('InfoWarning', '');
    }

    public static function getStandardByEquNo($equ_no) {
        $result = self::with([
            'oilStandardList' => function ($query) {
                $query->order('equ_oil_no asc');
            }
        ])->where('equ_no', '=', $equ_no)->find();
        return $result;
    }
}