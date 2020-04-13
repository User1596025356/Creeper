<?php


namespace app\controller\v1;


use app\exception\ParameterException;
use app\exception\SuccessMessage;
use app\exception\UserException;
use app\exception\UserExistException;
use app\service\Token;
use app\validate\CreateUser;
use app\validate\Login;
use think\facade\Request;
use app\model\User as UserModel;

class User
{
    public function register()
    {
        $validate = new CreateUser();
        $validate->gocheck();

        $data = Request::only(['username','password','sex','adr','tel']);
        $user = UserModel::getByUid($data['username']);
        if(!$user)
        {
            UserModel::create([
                'uid' => $data['username'],
                'upassword' => $data['password'],
                'usex' => (int)$data['sex'],
                'uadr' => $data['adr'],
                'utelephone' => $data['tel']
            ]);
            throw new SuccessMessage();
        }
        else{
            throw new UserException([
                'msg' => '用户名已存在'
            ]);
        }
    }

    public function login()
    {
        $validate = new Login();
        $validate->goCheck();

        $data = Request::only(['username','password']);
        $user = UserModel::getByUid($data['username']);
        if($user)
        {
            if($data['password'] === $user->upassword)
            {
                return json([
                    'Token' =>Token::generateToken()
                ]);
            }
            else{
                throw new UserException([
                    'msg' => '密码错误'
                ]);
            }

        }
        else{
            throw new UserException([
                'msg' => '用户名不存在'
            ]);
        }
    }
}