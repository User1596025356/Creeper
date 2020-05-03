<?php


namespace app\model;


class Image extends BaseModel
{
    protected $pk = 'id';
    protected $hidden = ['id','from','delete_time','update_time'];


    public static function addImage($savename)
    {
        $Img = self::create([
            'url' => $savename
        ]);
        return $Img->id;
    }
}