<?php

namespace dinglib\dingphp\exceptions;


use Throwable;

class ResultException extends DingException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}