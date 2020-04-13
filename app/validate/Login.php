<?php


namespace app\validate;


class Login extends BaseValidate
{
    protected $rule = [
        'username' => 'require|min:3|max:255',
        'password' => 'require|min:8|max:255',
    ];
}