<?php

namespace dinglib\dingphp\exceptions\node;




class NodeErrorException extends NodeException
{
        public function __construct(\Exception $exception)
        {
            parent::__construct($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
}