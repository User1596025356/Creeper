<?php


namespace app\validate;


class Views extends BaseValidate
{
    protected $rule =[
        'days' => 'isPositiveInteger',
    ];
}