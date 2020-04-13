<?php


namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

class BaseModel extends Model
{
    use SoftDelete;

    protected $hidden = ['delete_time','create_time','update_time'];
}