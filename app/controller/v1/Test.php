<?php
namespace app\controller\v1;

use app\BaseController;
use app\exception\UserException;
use app\service\Token as TokenService;
use app\validate\TestToken;
use think\facade\Request;
use app\model\User as UserModel;

class Test extends BaseController
{
    public function testToken()
    {
        (new TestToken())->gocheck();
        $uid = TokenService::getCurrentUid();
        $user = UserModel::where('id',$uid)->find();
        if(!$user){
            throw new UserException();
        }
        return json($user);
    }
}
