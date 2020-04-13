<?php


namespace app\validate;



class IDMustBeNumber extends BaseValidate
{
    protected $rule = [
        'id'=>'require|number'
    ];
}