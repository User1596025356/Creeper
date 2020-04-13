<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\validate\IDMustBeNumber;
use think\facade\Request;
use app\model\Products as ProductsModel;
class Products
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

}