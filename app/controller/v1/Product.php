<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\exception\ProductException;
use app\validate\AddProduct;
use app\validate\Count;
use app\validate\IDMustBeNumber;
use app\validate\IDMustBePositiveInt;
use app\validate\Page;
use Cassandra\Exception\ProtocolException;
use think\facade\Filesystem;
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

    public function getRecent(){
        if(Request::has('count'))
        {
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
        else{
            $validate = new Page();
            $validate->goCheck();

            $data = Request::only(['paginate','page','listrows']);
            $products = ProductsModel::getRecentProduct($data['paginate'],$data['page'],$data['listrows']);

            if(!$products)
            {
                throw new MissException([
                    'msg' => '商品列表为空',
                    'errorCode' => 40001,
                ]);
            }
            return json($products);
        }
    }

    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductsModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return json($product);
    }

    public function addOne($name,$price,$summary)
    {
        (new AddProduct())->goCheck();
        $images = request()->file();
        $savename = [];
        foreach ($images as $image){
            $savename[] = Filesystem::putFile('images', $image, 'md5');
        }
    }
}