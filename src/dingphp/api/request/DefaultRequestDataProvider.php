<?php

namespace dinglib\dingphp\api\request;


use dinglib\dingphp\api\request\impl\RequestDataProviderImpl;
use dinglib\dingphp\object\Object;

class DefaultRequestDataProvider extends Object implements RequestDataProviderImpl
{

    private $_headers = [];

    private $_method = '';

    private $_query = [];

    private $_data = [];

    public function initialize(array $params = null)
    {
        $this->_method = $_SERVER['REQUEST_METHOD'];
        foreach ($_SERVER as $key => $value){
            if(substr($key,0,5) === "HTTP_"){
                $this->_headers[strtolower(substr($key,5))] = $value;
            }
        }
        //获取本地访问来源
        if(!isset($this->_headers['origin'])) {
            $protocol = explode("/",$_SERVER['SERVER_PROTOCOL']);
            $this->setProperty("host_url" , strtolower($protocol[0])."://".$_SERVER['HTTP_HOST']);
        }
        $this->_query = $_GET;
        $this->_data = $_POST;
    }

    /**
     * 获取请求方法
     * @return string
     */
    public function method()
    {
        return $this->_method;
    }

    /**
     * 获取querystring参数
     * @return array
     */
    public function query()
    {
       return $this->_query;
    }

    /**
     * 获取post请求参数
     * @return array
     */
    public function post()
    {
       return $this->_data;
    }

    /**
     * 获取header参数
     * @return array
     */
    public function headers()
    {
        return $this->_headers;
    }


    public function __get($name)
    {
        return $this->getProperty($name);
    }

    public function __set($name, $value)
    {
        $this->setProperty($name,$value);
    }

}