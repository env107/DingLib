<?php

namespace dinglib\dingphp\api\request\impl;


interface RequestDataProviderImpl
{
    /**
     * 获取请求方法
     * @return string
     */
    public function method();

    /**
     * 获取querystring参数
     * @return array
     */
    public function query();

    /**
     * 获取post请求参数
     * @return array
     */
    public function post();

    /**
     * 获取header参数
     * @return array
     */
    public function headers();


}