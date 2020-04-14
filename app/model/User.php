<?php


namespace app\model;


class User extends BaseModel
{
    protected $pk = 'id';

    protected $hidden = ['id','openid','create_time','update_time','delete_time'];

    public static function getByUid($uid)
    {
        return User::where('uid','=',$uid)->find();
    }
}