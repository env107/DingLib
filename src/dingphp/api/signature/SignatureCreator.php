<?php

namespace dinglib\dingphp\api\signature;


use dinglib\dingphp\api\signature\impl\SignatureCreatorImpl;
use dinglib\dingphp\node\NodeResultType;
use dinglib\dingphp\object\Object;
use dinglib\dingphp\node\NodeCallable;

class SignatureCreator extends Object implements SignatureCreatorImpl
{

    /**
     * 签名生成
     * @param array $properties
     * @return string
     */
    public function package(array $properties)
    {
        ksort($properties,SORT_ASC);
        $data = [];
        foreach ($properties as $key => $value){
            array_push($data,
                urlencode($key)."=".urlencode($value)
                );
        }
        return base64_encode(implode(";",$data));
    }

    /**
     * 签名解密
     * @param string $signature
     * @return array
     */
    public function unpackage($signature)
    {
        return NodeCallable::build($signature)->next(function($signature){
            return base64_decode($signature);
        },NodeResultType::NODE_RESULT_TYPE_STRING)->next(function($signature){
            $data = explode(";",$signature);
            $unpackage = [];
            foreach ($data as $item){
                $t = explode("=",$item);
                $unpackage[urldecode($t[0])] = urldecode($t[1]);
            }
            return $unpackage;
        },NodeResultType::NODE_RESULT_TYPE_ARRAY)->eject();
    }
}