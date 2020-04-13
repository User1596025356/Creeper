<?php
namespace app\controller\v1;

use app\BaseController;
use app\service\Token;
use think\facade\Request;

class Test extends BaseController
{
    public function hh($name = 'shishikan')
    {
        return 'hh,'.$name;
        
    }

    public function getToken()
    {
        $app = new Token();
        $token = $app->generateToken();
        return json([
            'token' => $token
        ]);
    }

    public function check()
    {
//        $isget = \think\Request::param('token');
        $token = Request::param('token');
        $app = Token::checkToken($token);
        return json([

        ]);
    }
}
