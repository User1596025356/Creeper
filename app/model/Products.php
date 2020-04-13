<?php


namespace app\model;


class Products extends BaseModel
{
    protected $pk = 'id';

    public static function getByPid($id)
    {
        return Products::where('id','=',$id)->find();
    }
}