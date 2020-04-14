<?php


namespace app\model;


class Product extends BaseModel
{
    protected $pk = 'id';
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    public static function getByPid($id)
    {
        return Product::where('id','=',$id)->find();
    }

    public static function getProducts($paginate = true, $page = 1, $size = 30)
    {
        $query = self::where('id');
        if(!$paginate)
        {
            return $query->select();
        }
        else{
            return $query->paginate($size, true, ['page' => $page]);
        }
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }
}