<?php


namespace app\validate;


class CommentValidate extends BaseValidate
{
    protected $rule = [
        'comment' => 'require|isNotEmpty|max:255',
        'id' => 'require|isPositiveInteger'
    ];
}