<?php


namespace dinglib\dingphp\api\request\checker;


use dinglib\dingphp\api\request\impl\RequestDataProviderImpl;
use dinglib\dingphp\api\request\impl\RequestCheckerImpl;
use dinglib\dingphp\exceptions\api\RequestCheckerException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\result\Result;

class HeaderInfoChecker implements RequestCheckerImpl
{

    /**
     * 校验器方法
     * @param RequestDataProviderImpl $requestDataProviderImpl
     * @return Result
     */
    public function check(RequestDataProviderImpl $requestDataProviderImpl)
    {
        $header = $requestDataProviderImpl->headers();
        $signature = isset($header['signature']) ? $header['signature'] : null;
        $query = $requestDataProviderImpl->query();
        if(!isset($header['host'])) {
            return Result::reject(new RequestCheckerException(Lang::get("HOST_NOT_FOUND")));
        }
        if(empty($signature)) {
            if(!isset($query['signature'])) {
                return Result::reject(new RequestCheckerException(Lang::get("SIGNATURE_NOT_FOUND")));
            }
            $signature = $query['signature'];
        }
        $requestDataProviderImpl->setProperty("signature",$signature);
        return Result::resolve();
    }

    /**
     * 返回校验器ID
     * 可以是全局唯一的随机字符串
     * @return String
     */
    public function checkerId()
    {
        return '';
    }
}