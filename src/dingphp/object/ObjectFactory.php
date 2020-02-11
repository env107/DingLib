<?php


namespace dinglib\dingphp\object;
use dinglib\dingphp\api\request\DefaultRequestDataProvider;
use dinglib\dingphp\api\request\impl\Executable;
use dinglib\dingphp\api\request\RequestChecker;
use dinglib\dingphp\api\request\RequestCheckerQueue;
use dinglib\dingphp\exceptions\TypeException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\object\traits\ObjectTrait;

class ObjectFactory
{
    use ObjectTrait;
    const REQUEST_PROVIDER = 'request.provider';
    const REQUEST_CHECKER = 'request.checker';
    const REQUEST_CHECKER_QUEUE = 'request.checker.queue';

    /**
     * 指定工厂生产对象的映射
     * @var array
     */
    private static $_classmap = [
        self::REQUEST_CHECKER => RequestChecker::class,
        self::REQUEST_CHECKER_QUEUE => RequestCheckerQueue::class,
        self::REQUEST_PROVIDER => DefaultRequestDataProvider::class,
    ];

    /**
     * 创建对象
     * @param $classmap
     * @return Instance | null
     */
    public static function create($classmap){
        if(!self::$_classmap[$classmap]) {
            return null;
        }
        return self::make(
            self::$_classmap[$classmap],
            self::catchInvisibleParam(func_get_args())
        );
    }

    /**
     * 创建可执行的对象
     * @param $classmap
     * @return Executable|null
     * @throws TypeException
     */
    public static function createExecutable($classmap){
        $args = self::catchInvisibleParam(func_get_args());
        $object = self::create($classmap,...$args);
        if(!$object instanceof Executable){
            throw new TypeException(Lang::get("OBJECT_MUST_EXECUTABLE").":".get_class($object));
        }
        return $object;
    }

    /**
     * 生产对象
     * @param object $class
     * @param array $args
     * @return Instance | null
     */
    private static function make($class,$args){
        return $class::getInstance(...$args);
    }



}