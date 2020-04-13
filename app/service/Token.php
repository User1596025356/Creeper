<?php

namespace app\service;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class Token
{
    public static function generateToken()
    {
        $key = "qwer~!@#";  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当于加密中常用的盐salt
        $token = [
            "iss"=>"",  //签发者 可以为空
            "aud"=>"", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time()+100, //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time()+7200, //token 过期时间
        ];
        $jwt = JWT::encode($token,$key,"HS256"); //根据参数生成了 token
        return $jwt;
    }
    public static function checkToken($token)
    {
        $key = "huang";
        return JWT::decode($token,$key,["HS256"]);
    }
}