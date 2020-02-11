<?php


namespace dinglib\dingphp\api\request\impl;


interface RequestCheckerQueueImpl
{
    /**
     * 弹出校验器
     * @return RequestCheckerImpl
     */
    public function pop();

    /**
     * 校验器对象个数
     * @return int
     */
    public function length();

    /**
     * 添加校验器
     * @param $object
     * @return int
     */
    public function push($object);

    /**
     * 判断队列中是否还有元素
     * @return bool
     */
    public function has();

}