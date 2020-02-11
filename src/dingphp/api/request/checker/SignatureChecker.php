<?php

namespace dinglib\dingphp\api\request\checker;


use dinglib\dingphp\api\request\impl\RequestCheckerImpl;
use dinglib\dingphp\api\request\impl\RequestDataProviderImpl;
use dinglib\dingphp\api\signature\Signature;
use dinglib\dingphp\api\signature\SignatureCreator;
use dinglib\dingphp\exceptions\api\SignatureCheckerException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\result\Result;

class SignatureChecker implements RequestCheckerImpl
{

    /**
     * 检验器方法
     * @param RequestDataProviderImpl $provider
     * @return Result
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public function check(RequestDataProviderImpl $provider)
    {
        $signature = $provider->getProperty("signature");
       try {
           $properties = Signature::newInstance($signature)->getProperties();
           if(!isset($properties['method'])) {
               throw new SignatureCheckerException(Lang::get("SIGNATURE_PARAMS_NOT_FOUND").":Signature.method");
           }
           if(!isset($properties['host'])) {
               throw new SignatureCheckerException(Lang::get("SIGNATURE_PARAMS_NOT_FOUND").":Signature.host");
           }
           $this->checkSignature($provider,$signature);
       } catch (SignatureCheckerException $exception){
            return Result::reject(new SignatureCheckerException(
                Lang::get("SIGNATURE_VALIDATE_ERROR").":".$exception->getMessage())
            );
       }
       return Result::resolve(true);
    }

    /**
     * 签名对比
     * @param $provider
     * @param $signature
     * @return bool
     * @throws SignatureCheckerException
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    private function checkSignature($provider,$signature){
        $querystring = http_build_query($provider->query());
        $server_signature = SignatureCreator::getInstance()->package([
            'method' => strtolower($provider->method()),
            'query' => $querystring,
            'host' => $provider->getProperty("host_url")
        ]);
        if($server_signature !== $signature){
            throw new SignatureCheckerException("Signature不一致");
        }
        return true;
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