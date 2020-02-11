<?php

namespace dinglib\dingphp\object\impl;


interface Instance
{
    /**
     * 提供获取实例
     * @param object | string | array $params
     * @return Instance
     */
    public static function getInstance($params = null);

    /**
     * 初始化方法
     * @param array $params
     * @return mixed
     */
    public function initialize(array $params = null);

    /**
     * 设定属性
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setProperty($key,$value);

    /**
     * 获取属性
     * @param string $key
     * @return mixed
     */
    public function getProperty($key);

    /**
     * 获取所有属性
     * @return array
     */
    public function getProperties();

}