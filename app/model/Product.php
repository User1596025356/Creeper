<?php


namespace app\model;


class Product extends BaseModel
{
    protected $pk = 'id';
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time','user_id'
    ];

    public function userinfo()
    {
        return $this->belongsTo('User','user_id','id');
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage','product_id','id');
    }

    public static function getByPid($id)
    {
        return Product::where('id','=',$id)->find();
    }

    public static function getRecentProduct($paginate = true, $page = 1, $size = 5)
    {
        $query = self::order('create_time desc')->with('userinfo');
        if(!$paginate)
        {
            return $query->select();
        }
        else{
            return $query->page($page,$size)->select();
        }
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->with('userinfo')->select();
        return $products;
    }

    public static function getProductDetail($id)
    {
        //返回imgs顺序需要自动调整
        $product = self::with(['imgs.imgUrl','userinfo'])->find($id);
        return $product;
    }

    public static function addProduct($uid, $name, $price, $summary)
    {
        $product = self::create([
            'name' => $name,
            'price' => $price,
            'summary' => $summary,
            'user_id' => $uid
        ]);
        return $product->id;
    }
}