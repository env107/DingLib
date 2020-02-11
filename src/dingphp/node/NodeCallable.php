<?php


namespace dinglib\dingphp\node;


use dinglib\dingphp\exceptions\node\NodeErrorException;
use dinglib\dingphp\object\Object;
use dinglib\dingphp\object\traits\ObjectTrait;

class NodeCallable extends Object
{
    use ObjectTrait;
    private $_data = null;

    public function initialize(array $params = null)
    {
        if(isset($params[0])){
            $this->_data = $params[0];
        }
    }

    /**
     * 创建实例
     * @param mixed $initData <p>
     * 初始化数据
     * </p>
     * @return NodeCallable
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public static function build($initData = null){
        self::revokeInstance();
        return self::getInstance($initData);
    }

    /**
     * 下一节点调用函数
     * @param  Callable | array $function
     * @param  string | array  $excepted <p>
     * 指定该参数，$function返回的结果将会按照$excepted的指定标准返回
     * 支持多种类型的判断，例如 <br />
     * \foo\bar\test1 <br />
     * string <br />
     * array <br />
     * number <br />
     * function <br />
     * boolean <br />
     * null <br />
     * 你可以通过 NodeResultType类的常量来指定类型 例如 NodeResultType::NODE_RESULT_TYPE_STRING
     * </p>
     * @return NodeCallable
     * @throws NodeErrorException
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public function next($function,$excepted = []){
        try {
            $result = call_user_func($function,$this->_data);
            NodeResultType::build($excepted)->measure($result);
        }catch (\Exception $exception){
            throw new NodeErrorException($exception);
        }
        return NodeCallable::build($result);
    }

    /**
     * 获取最后处理结果
     * @return mixed
     */
    public function eject(){
        return $this->_data;
    }

}