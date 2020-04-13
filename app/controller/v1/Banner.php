<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\validate\IDMustBePositiveInt;
use app\model\Banner as BannerModel;
use think\facade\Request;

class Banner
{
    public function getBanner($id)
    {
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();

        $data = Request::only(['id']);

        $banner = BannerModel::getBannerById($data['id']);
//        $banner = BannerModel::with('image')->select($data['id']);
        if(!$banner)
        {
            throw new MissException([
                'msg' => '请求Banner不存在',
                'errorCode' => '40000'
            ]);
        }
        return json($banner);
    }

}