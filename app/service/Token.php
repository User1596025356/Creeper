<?php

namespace app\service;


use app\exception\TokenException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use think\facade\Cache;
use think\Exception;
use think\facade\Request;

class Token
{
    public static function generateToken($uid)
    {
        $key = config('token.key');  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当于加密中常用的盐salt
        $token = [
            "iss" => "",  //签发者 可以为空
            "aud" => $uid, //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time()+config('token.nbf'), //在什么时候jwt开始生效
            "exp" => time()+config('token.exp'), //token 过期时间
        ];
        //根据参数生成了 token
        return JWT::encode($token,$key,"HS256");
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::header('token');
        $vars = Cache::get($token);
        if (!$vars)
        {
            throw new TokenException();
        }
        else {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else{
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

//    public static function checkToken($token)
//    {
//        $key = "huang";
//        return JWT::decode($token,$key,["HS256"]);
//    }
}