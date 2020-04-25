<?php


namespace dinglib\dingphp\object;


use dinglib\dingphp\exceptions\TypeException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\object\impl\Instance;
use dinglib\dingphp\object\traits\ObjectTrait;

class DingObject implements Instance
{
    use ObjectTrait;
    private static $_instancies = [];
    private $_properties = [];

    /**
     * 创建单实例
     * @param array $params
     * @return Object
     * @throws TypeException
     * @throws \ReflectionException
     */
    public static function getInstance($params = null)
    {
        $classmap = get_called_class();
        if(!isset(self::$_instancies[$classmap])){
            self::$_instancies[$classmap] = self::newInstance(...func_get_args());
        }
        return self::$_instancies[$classmap];
    }

    /**
     * 创建对象
     * @param array $params
     * @return Instance
     * @throws TypeException
     * @throws \ReflectionException
     */
    public static function newInstance($params = null){
        return self::_newClassMapObject(get_called_class(),...func_get_args());
    }

    /**
     * 删除对象实例
     * @param $classmap
     * @return bool
     */
    public static function revokeInstance($classmap = null){
        if(empty($classmap)) {
            $classmap = get_called_class();
        }
        if(isset(self::$_instancies[$classmap])){
            self::$_instancies[$classmap] = null;
            unset(self::$_instancies[$classmap]);
        }
        return true;
    }

    /**
     * 获取所有对象实例类名
     * @return array
     */
    public static function getInstanciesClassMap(){
        $class = [];
        foreach (self::$_instancies as $classmap => $instance){
            array_push($class,get_class($instance));
        }
        return $class;
    }

    public function initialize(array $params = null){}

    public function setProperty($key, $value)
    {
       $this->_properties[$key] = $value;
    }

    public function getProperty($key)
    {
        if(!isset($this->_properties[$key])) {
            return null;
        }
        return $this->_properties[$key];
    }

    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * 创建Object
     * @param $classmap
     * @return Instance
     * @throws TypeException
     * @throws \ReflectionException
     */
    private static function _newClassMapObject($classmap){
        $class = new \ReflectionClass($classmap);
        $params = self::catchInvisibleParam(func_get_args());
        $object = $class->newInstanceWithoutConstructor();
        if (!$object instanceof DingObject) {
            throw new TypeException(Lang::get("OBJECT_TYPE_ERROR"));
        }
        $object->initialize($params);
        return $object;
    }

    private function __clone(){}

    private function __construct(){}

}