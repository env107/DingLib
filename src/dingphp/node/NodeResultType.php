<?php

namespace dinglib\dingphp\node;


use dinglib\dingphp\exceptions\node\NodeResultTypeErrorException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\object\DingObject;

class NodeResultType extends DingObject
{

    const NODE_RESULT_TYPE_STRING = 'string';
    const NODE_RESULT_TYPE_NUMBER = 'number';
    const NODE_RESULT_TYPE_FUNCTION = 'function';
    const NODE_RESULT_TYPE_BOOLEAN = 'boolean';
    const NODE_RESULT_TYPE_ARRAY = 'array';
    const NODE_RESULT_TYPE_NULL = 'null';

    private $_excepted = [];

    public function initialize(array $params = null)
    {
        $this->_excepted = isset($params[0]) ? $params[0] : [];
    }

    /**
     * 创建结果对象
     * @param string | array $excepted
     * @return NodeResultType
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public static function build($excepted = []){
        if(!is_array($excepted)) {
            $excepted = [$excepted];
        }
        self::revokeInstance();
        return self::getInstance($excepted);
    }

    /**
     * 测量类型
     * @param $value
     * @return bool
     * @throws NodeResultTypeErrorException
     */
    public function measure($value){
        if(count($this->_excepted) < 1){
            return true;
        }
        $type = $this->typeof($value);
        $r = in_array($type,$this->_excepted);
        if($r === FALSE) {
            throw new NodeResultTypeErrorException(Lang::get("NODE_RESULT_TYPE_NOT_MATCH").":".$type);
        }
        return true;
    }

    /**
     * 获取类型
     * @param $value
     * @return string
     * @throws NodeResultTypeErrorException
     */
    public function typeof($value){
        if(is_string($value)){
            return self::NODE_RESULT_TYPE_STRING;
        } elseif(is_numeric($value)) {
            return self::NODE_RESULT_TYPE_NUMBER;
        } elseif(is_bool($value)) {
            return self::NODE_RESULT_TYPE_BOOLEAN;
        } elseif(is_array($value)) {
            return self::NODE_RESULT_TYPE_ARRAY;
        } elseif(is_callable($value)) {
            return self::NODE_RESULT_TYPE_FUNCTION;
        } elseif(is_null($value)) {
            return self::NODE_RESULT_TYPE_NULL;
        } elseif(is_object($value)) {
            return get_class($value);
        }
        throw new NodeResultTypeErrorException(Lang::get("NODE_RESULT_TYPE_NOT_SUPPORT"));
    }
}