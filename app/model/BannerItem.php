<?php


namespace app\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['banner_id','image_id','delete_time','create_time','update_time'];
    public function img()
    {
        return $this->belongsTo('Image','image_id','id');
    }
}