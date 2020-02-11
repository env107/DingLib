<?php


namespace dinglib\dingphp\api\request\impl;
use dinglib\dingphp\result\Result;

interface RequestCheckerImpl
{
    /**
     * 校验器方法
     * @param RequestDataProviderImpl $requestDataProviderImpl
     * @return Result
     */
    public function check(RequestDataProviderImpl $requestDataProviderImpl);

    /**
     * 返回校验器ID
     * 可以是全局唯一的随机字符串
     * @return String
     */
    public function checkerId();


}