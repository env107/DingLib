<?php

namespace dinglib\dingphp\api\request;


use dinglib\dingphp\api\request\impl\RequestCheckerQueueImpl;
use dinglib\dingphp\api\request\impl\RequestCheckerImpl;
use dinglib\dingphp\exceptions\api\RequestCheckerException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\object\DingObject;

class RequestCheckerQueue extends DingObject implements RequestCheckerQueueImpl
{
    /**
     * 储存校验器队列
     * @var array
     */
    private $_queue = [];

    /**
     * 批量添加校验器对象
     * @param array $objects
     * @return int
     * @throws RequestCheckerException
     */
    public function pushByObjects(array $objects){
        foreach ($objects as $object) {
            if(is_string($object)) {
                //尝试创建并判断该实例是否为校验器
                $object = new $object();
            } elseif (is_array($object)){
                throw new RequestCheckerException(Lang::get('OBJECT_TYPE_ERROR').": Array");
            }
            if(!$object instanceof RequestCheckerImpl){
                throw new RequestCheckerException(Lang::get('OBJECT_TYPE_ERROR').":".get_class($object));
            }
            array_unshift($this->_queue,$object);
        }
        return count($this->_queue);
    }


    /**
     * 弹出校验器
     * @return RequestCheckerImpl
     */
    public function pop()
    {
        return array_pop($this->_queue);
    }

    /**
     * 校验器对象个数
     * @return int
     */
    public function length()
    {
       return count($this->_queue);
    }

    /**
     * 添加校验器
     * @param $object
     * @throws RequestCheckerException
     * @return int
     */
    public function push($object)
    {
        if(!is_array($object)) {
            $object = [$object];
        }
        return $this->pushByObjects($object);
    }

    /**
     * 判断队列中是否还有元素
     * @return bool
     */
    public function has()
    {
        return $this->length() > 0;
    }
}