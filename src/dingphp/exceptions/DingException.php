<?php


namespace dinglib\dingphp\exceptions;


use Throwable;

class DingException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}