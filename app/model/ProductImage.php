<?php


namespace app\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id', 'update_time'];

    public function imgUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }

    public static function addProductImage($pid, $iid, $order)
    {
        $Img = self::create([
           'product_id' => $pid,
           'img_id' => $iid,
            'order' => $order
        ]);
    }
}