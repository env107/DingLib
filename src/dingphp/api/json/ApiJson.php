<?php

namespace dinglib\dingphp\api\json;


use dinglib\dingphp\api\json\impl\ApiJsonImpl;
use dinglib\dingphp\object\Object;

class ApiJson extends Object implements ApiJsonImpl
{

    private $_data = [];

    /**
     * @return ApiJson
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public static function build(){
        return self::newInstance();
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message){
        $this->_data['message'] = $message;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setErrCode($code = 0){
        $this->_data['errcode'] = $code;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data){
        $this->_data['data'] = $data;
        return $this;
    }

    /**
     * @param mixed $debug
     * @return $this
     */
    public function setDebug($debug = null){
        if(empty($debug)) {
            $this->_data['debug'] = debug_backtrace();
        } else {
            $this->_data['debug'] = $debug;
        }
        return $this;
    }

    /**
     * 创建数组
     * @return array
     */
    public function create()
    {
        return $this->_data;
    }

    /**
     * 创建json字符串
     * @return string
     */
    public function createJson()
    {
        return json_encode($this->_data);
    }
}