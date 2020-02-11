<?php

namespace dinglib\dingphp\result;


use dinglib\dingphp\exceptions\DingException;
use dinglib\dingphp\exceptions\ResultException;


class Result
{

    /**
     * 处理结果
     * @var mixed
     */
    private $_data = null;

    /**
     * 异常错误
     * @var DingException
     */
    private $_error = null;

    private function __construct($data = null,$error = null)
    {
        $this->_data = $data;
        $this->_error = $error;
    }

    /**
     * 处理成功
     * @param null $data
     * @return Result
     */
    public static function resolve($data = null){
        return new self($data,null);
    }

    /**
     * 处理异常
     * @param DingException $dingException
     * @return Result
     */
    public static function reject(DingException $dingException){
        return new self(null,$dingException);
    }

    /**
     * 获取结果
     * @return string | array | object
     * @throws ResultException
     */
    public function result(){
        if($this->hasError()) {
            throw new ResultException($this->_error->getMessage());
        }
        return $this->_data;
    }

    /**
     * 检查是否存在错误
     * @return bool
     */
    public function hasError(){
        if($this->_error !== null && $this->_error instanceof DingException) {
            return true;
        }
        return false;
    }

}