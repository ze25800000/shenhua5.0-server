<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1 0001
 * Time: 10:17
 */

namespace app\model;


class User extends BaseModel {
    protected $hidden = ['password','id','create_time','update_time','scope','phone'];
}