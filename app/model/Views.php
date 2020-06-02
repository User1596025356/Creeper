<?php


namespace app\model;


use think\Model;

class Views extends Model
{
    protected $pk = 'date';
    protected $autoWriteTimestamp = false;

    public static function getByDays($days = 7)
    {
        return Views::order('date desc')->limit($days)->select();
    }

    public static function getAllDays()
    {
        return Views::sum('count');
    }
}