<?php


namespace app\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id', 'update_time'];

    public function imgUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}