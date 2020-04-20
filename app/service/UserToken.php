<?php


namespace app\service;


use app\exception\TokenException;
use app\exception\WeChatException;
use app\model\User;
use think\Exception;
use think\facade\Config;

class UserToken extends Token
{
    protected $code;
    protected $wxLoginUrl;
    protected $wxAppId;
    protected $wxAppSecert;

     function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = Config::get('wx.app_id');
        $this->wxAppSecert = Config::get('wx.app_secert');
        $this->wxLoginUrl = sprintf(
            Config::get('wx.login_url'),$this->wxAppId,$this->wxAppSecert,$this->code
        );
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);

        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }
        else{
            if(array_key_exists('errcode',$wxResult)){
                $this->processLoginError($wxResult);
            }
            else{
                return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException(
            [
                'msg' => $wxResult['errmsg'],
                'errorCode' => $wxResult['errcode']
            ]);
    }

    private function grantToken($wxResult)
    {
        $openid = $wxResult['openid'];
        $user = User::getByOpenid($openid);
        if(!$user)
        //微信openid作为用户标识，相关查询还是采用uid
        {
            $uid = $this->newUser($openid);
        }
        else{
            $uid = $user->id;
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        return $this->saveToCache($cachedValue);
    }

    private function saveToCache($cachedValue)
    {
        $key = self::generateToken($cachedValue['uid']);
        $value = json_encode($cachedValue);
        $expire_in = config('token.exp');
        $result = cache($key, $value, $expire_in);

        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    //创建新用户
    private function newUser($openid)
    {
        $user = User::create(
            [
                'openid' => $openid
            ]
        );
        return $user->id;
    }


}