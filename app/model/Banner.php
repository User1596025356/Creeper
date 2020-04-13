<?php


namespace app\model;


class Banner extends BaseModel
{
    protected $pk = 'id';
//    public function image()
//    {
//        return $this->belongsTo('Image','image_id','id');
//    }
    public function items()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }
    public static function getBannerById($id)
    {
        return self::with('items.img')->find($id);
    }


}