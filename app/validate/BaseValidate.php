<?php


namespace app\validate;


use app\exception\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
        $params['token'] = $request->header('token');

        if(!$this->check($params)){
            throw new ParameterException([
                  'msg' => is_array($this->error) ? implode(
                      ';', $this->error) : $this->error,
            ]);
        }
        return true;
    }

    public function getDataByRule($arrays)
    {
        if(array_key_exists('user_id', $arrays)|array_key_exists('uid', $arrays))
        //不允许包含user_id或者uid,防止恶意覆盖uid外键
        {
            throw new ParameterException([
                'msg' => '参数中包含非法参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }


}