<?php


namespace app\model;


class Image extends BaseModel
{
    protected $pk = 'id';
    protected $hidden = ['id','from','delete_time'];
}