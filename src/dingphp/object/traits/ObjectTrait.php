<?php


namespace dinglib\dingphp\object\traits;


trait ObjectTrait
{
    private static function catchInvisibleParam($params = []){
        array_shift($params);
        return $params;
    }

}