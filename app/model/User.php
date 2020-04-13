<?php


namespace app\model;


class User extends BaseModel
{
    protected $pk = 'uid';

    public static function getByUid($uid)
    {
        return User::where('uid','=',$uid)->find();
    }
}