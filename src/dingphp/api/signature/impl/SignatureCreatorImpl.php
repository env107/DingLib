<?php

namespace dinglib\dingphp\api\signature\impl;


interface SignatureCreatorImpl
{
    /**
     * 签名生成
     * @param array $properties
     * @return string
     */
    public function package(array $properties);

    /**
     * 签名解密
     * @param string $signature
     * @return array
     */
    public function unpackage($signature);
}