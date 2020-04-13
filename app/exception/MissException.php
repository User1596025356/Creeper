<?php


namespace app\exception;


class MissException extends BaseException
{
    public $code = 404;
    public $errorCode = 10001;
    public $msg = "your required resource are not found";
}
