<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\validate\Count;
use app\validate\IDMustBeNumber;
use app\validate\IDMustBePositiveInt;
use think\facade\Request;
use app\model\Product as ProductsModel;
class Product
{
    public function getProductsInfo(){
        $validate = new IDMustBeNumber();
        $validate->goCheck();

        $data = Request::only(['id']);
        $products = ProductsModel::getByPid($data['id']);
        if(!$products)
        {
            throw new MissException([
                'msg' => '请求商品不存在',
                'errorCode' => 40000,
            ]);
        }
        return $products;
    }

    public function getRecent($count = 15){
        $validate = new Count();
        $validate->goCheck();

        $data = Request::only(['count']);
        $products = ProductsModel::getMostRecent($data['count']);
        if($products->isEmpty())
        {
            throw new MissException([
                'msg' => '商品列表为空',
                'errorCode' => 40001,
            ]);
        }
        return json($products);
    }

}