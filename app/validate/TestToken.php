<?php


namespace app\validate;



class TestToken extends BaseValidate
{
    protected $rule = [
        'token' => 'require|isNotEmpty'
    ];
}