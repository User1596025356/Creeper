<?php


namespace app\validate;


class Page extends BaseValidate
{
    protected $rule = [
        'paginate' => 'in:0,1|require',
        'page' => 'isPositiveInteger|require',
        'listrows' => 'isPositiveInteger|require'
    ];
}