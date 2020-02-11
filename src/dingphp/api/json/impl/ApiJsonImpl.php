<?php

namespace dinglib\dingphp\api\json\impl;


interface ApiJsonImpl
{
    /**
     * 创建数组
     * @return array
     */
    public function create();

    /**
     * 创建json字符串
     * @return string
     */
    public function createJson();
}