<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6 0006
 * Time: 9:36
 */

namespace app\model;


class InfoWarning extends BaseModel {
//    protected $visible = ['equ_key_no','del_warning_time','status','how_long','warning_type','postpone','postpone_reason','oil_no','quantity','user'];
    protected $hidden = ['create_time', 'update_time', 'equ_no', 'equ_oil_no'];

    public function user() {
        return $this->hasOne('user', 'id', 'user_id');
    }

    public static function getWarningMessage() {
        $result     = self::where('status', '>=', '2')->select();
        $collection = collection($result)->visible(['equ_name', 'equ_oil_name', 'status', 'how_long', 'del_warning_time', '']);
        return $collection;
    }

    public static function getInfoList($page) {
        $result = self::order('status desc,how_long desc,del_warning_time desc,equ_key_no desc')
            ->limit(10)
            ->page($page)
            ->select();
        return $result;
    }

    public static function getInfoListByIds($ids) {
        $result     = self::select($ids);
        $collection = collection($result)
            ->visible(['equ_no', 'equ_oil_no', 'equ_oil_name', 'del_warning_time', 'warning_type', 'how_long', 'postpone', 'status', 'is_first_period'])
            ->toArray();
        return $collection;
    }
}