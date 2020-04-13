<?php


namespace app\model;


class Image extends BaseModel
{
    protected $pk = 'id';
    protected $hidden = ['id','delete_time','create_time','update_time'];
}