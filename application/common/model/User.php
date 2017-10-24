<?php

namespace app\common\model;


class User extends BaseModel {
    protected $hidden = ['password', 'id', 'create_time', 'update_time', 'scope', 'phone'];
}