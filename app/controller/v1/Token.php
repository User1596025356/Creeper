<?php


namespace app\controller\v1;


use app\BaseController;
use app\service\UserToken;
use app\validate\TokenGet;
use app\service\Token as TokenService;
class Token extends BaseController
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     * @param string $code
     * @return \think\response\Json
     * @throws \app\exception\ParameterException
     * @throws \think\Exception
     */
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $wx = new UserToken($code);
        $token = $wx->get();
        return json([
            'token' => $token
        ]);
    }
}