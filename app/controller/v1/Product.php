<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\exception\ProductException;
use app\model\ProductImage;
use app\validate\AddProduct;
use app\validate\Count;
use app\validate\IDMustBeNumber;
use app\validate\IDMustBePositiveInt;
use app\validate\Page;
use app\validate\TestToken;
use Cassandra\Exception\ProtocolException;
use think\exception\ValidateException;
use think\facade\Filesystem;
use think\facade\Request;
use app\model\Product as ProductsModel;
use app\model\ProductImage as ProductImageModel;
use app\model\Image as ImageModel;
use app\service\Token as TokenService;

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
            $num = ProductsModel::getProductsNum();

            if(!$products)
            {
                throw new MissException([
                    'msg' => '商品列表为空',
                    'errorCode' => 40001,
                ]);
            }
            $products['sum'] = $num;
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
        (new TestToken())->goCheck();
        $uid = TokenService::getCurrentUid();
        (new AddProduct())->goCheck();
        return ProductsModel::addProduct($uid, $name, $price, $summary);
    }

    public function upload($pid)
    {
        (new TestToken())->goCheck();
        $image = request()->file('image');
        try {
            validate(['image'=>[
                'fileSize' => 410241024,
                'fileExt' => 'jpg,jpeg,png,bmp,gif',
                'fileMime' => 'image/jpeg,image/png,image/gif',
            ]])->check(['image'=>$image]);
            $savename = Filesystem::putFile('images', $image, 'md5');
            $iid = ImageModel::addImage($savename);
            ProductImageModel::addProductImage($pid, $iid);
            return json([
                'ImgUrl' => $savename
            ]);
        }catch(ValidateException $e){
            return json($e->getMessage());
        }

    }
}