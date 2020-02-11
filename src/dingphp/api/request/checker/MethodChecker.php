<?php

namespace dinglib\dingphp\api\request\checker;


use dinglib\dingphp\api\request\impl\RequestDataProviderImpl;
use dinglib\dingphp\exceptions\api\RequestCheckerException;

use dinglib\dingphp\api\request\impl\RequestCheckerImpl;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\result\Result;

class MethodChecker implements RequestCheckerImpl
{

    private $_methods = ['get' , 'post' , 'put' , 'delete' , 'options'];

    public function check(RequestDataProviderImpl $requestDataProviderImpl)
    {
        $method = strtolower($requestDataProviderImpl->method());
        if(empty($method)) {
            return Result::reject(new RequestCheckerException(Lang::get('METHOD_NOT_FOUND')));
        }
        if(!in_array($method,$this->_methods)){
            return Result::reject(new RequestCheckerException(Lang::get('METHOD_NOT_SUPPORT')));
        }
        $requestDataProviderImpl->checkMethod = "__METHOD_ID__";
        return Result::resolve(true);
    }

    public function checkerId()
    {
        return '';
    }




}