<?php


namespace app\validate;


class CreateUser extends BaseValidate
{
    protected $rule = [
        'username' => 'require|min:3|max:255',
        'password' => 'require|min:8|max:255',
        'sex' => 'require|in:0,1',
        'tel' => 'require|mobile',
        'adr' => ''
    ];
}