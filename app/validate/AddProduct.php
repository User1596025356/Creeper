<?php


namespace app\validate;


class AddProduct extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty|max:25',
        'price' => 'require|egt:0|lt:10000',//临时的验证方法
        'summary' => 'require|isNotEmpty|max:255'
    ];
}