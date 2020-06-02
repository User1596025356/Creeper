<?php


namespace app\controller\v1;


use app\BaseController;
use app\exception\MissException;
use app\model\Views as ViewsModel;
use app\validate\IDMustBePositiveInt;
use think\facade\Request;

class Views extends BaseController
{
    public function getRecentViews()
    {
        $validate = new \app\validate\Views();
        $validate->goCheck();

        $data = Request::only(['days'=>7]);
        $views = ViewsModel::getByDays($data['days']);
        $sum = ViewsModel::getAllDays();
        if(!$views)
        {
            throw new MissException([
                'code' => 500,
                'msg' => '服务器内部错误',
                'errorCode' => 50000,
            ]);
        }
        $views['sum'] = $sum;
        return json($views);
    }
}