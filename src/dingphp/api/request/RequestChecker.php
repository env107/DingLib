<?php


namespace dinglib\dingphp\api\request;

use dinglib\dingphp\api\request\impl\RequestCheckerQueueImpl;
use dinglib\dingphp\api\request\impl\Executable;
use dinglib\dingphp\api\request\impl\RequestDataProviderImpl;
use dinglib\dingphp\api\request\impl\RequestCheckerImpl;
use dinglib\dingphp\exceptions\api\RequestCheckerException;
use dinglib\dingphp\exceptions\ResultException;
use dinglib\dingphp\exceptions\TypeException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\object\Object;

class RequestChecker extends Object implements Executable
{

    /**
     * 请求数据提供实例
     * @var RequestDataProviderImpl
     */
    private $_provider = null;

    /**
     * 初始化方法
     * @param null $params
     * @return mixed|void
     * @throws TypeException
     */
    public function initialize(array $params = null)
    {
        $provider = isset($params[0]) ? $params[0] : null;
        if(!$provider instanceof RequestDataProviderImpl){
            throw new TypeException(Lang::get("OBJECT_TYPE_ERROR"));
        }
        $this->_provider = $provider;
    }

    /**
     * 检验请求
     * @param RequestCheckerQueueImpl $checkerQueueImpl
     * @return bool
     * @throws RequestCheckerException
     */
    public function run(RequestCheckerQueueImpl $checkerQueueImpl)
    {
        while(($handle = $checkerQueueImpl->pop()) !== null){
            $this->_handleChecker($handle);
        }
        return true;
    }

    /**
     * 处理校验器结果
     * @param RequestCheckerImpl $handle
     * @throws RequestCheckerException
     */
    private function _handleChecker(RequestCheckerImpl $handle){
        try {
            $result = $handle->check($this->_provider);
            $result->result();
        } catch (ResultException $promiseException) {
            throw new RequestCheckerException($promiseException->getMessage());
        }
    }


}