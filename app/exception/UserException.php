<?php


namespace app\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $errorCode = 60000;
    public $msg = "用户不存在";
}