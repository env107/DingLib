<?php


namespace dinglib\dingphp\session;


use dinglib\dingphp\object\Object;
use dinglib\dingphp\session\impl\SessionAdapterImpl;
use dinglib\dingphp\session\impl\SessionImpl;

class Session extends Object implements SessionImpl,\SessionHandlerInterface
{

    /**
     * @var SessionAdapterImpl
     */
    private $_adapter = null;

    /**
     * 读取会话
     * @param $sessionId
     */
    public function load($sessionId){
        if($this->isActive()){
            session_write_close();
            session_unset();
            header_remove("Set-Cookie");
        }
        session_id($sessionId);
        session_start();
    }

    /**
     * 创建实例
     * @param SessionAdapterImpl $adapter
     * @return Session
     * @throws \ReflectionException
     * @throws \dinglib\dingphp\exceptions\TypeException
     */
    public static function build(SessionAdapterImpl $adapter){
        $object =  self::getInstance($adapter);
        self::bindSessionSaveHandler($object);
        return $object;
    }

    /**
     * 绑定Session保存具柄
     * @param \SessionHandlerInterface $handler
     */
    public static function bindSessionSaveHandler(\SessionHandlerInterface $handler){
        session_set_save_handler($handler,true);
    }


    public function initialize(array $params = null)
    {
        $this->_adapter = isset($params[0]) && ($params[0] instanceof SessionAdapterImpl)? $params[0] : null;
    }

    /**
     * SessionSaveInterface Close
     * @return bool
     */
    public function close()
    {
       return true;
    }

    /**
     * SessionSaveInterface Destory
     * @param string $sessionId
     * @return bool
     */
    public function destroy($sessionId)
    {
        if($this->isActive()) {
            return $this->_adapter->remove($sessionId);
        }
        return true;
    }

    /**
     * SessionSaveInterface Gc
     * @param int $maxLifeTime
     * @return bool
     */
    public function gc($maxLifeTime)
    {
        return true;
    }

    /**
     * SessionSaveInterface Open
     * @param string $savePath
     * @param string $name
     * @return bool
     */
    public function open($savePath, $name)
    {
        return true;
    }

    /**
     * SessionSaveInterface Read
     * @param string $sessionId
     * @return string
     */
    public function read($sessionId)
    {
        return $this->_adapter->read($sessionId);
    }

    /**
     * SessionSaveInterface Write
     * @param string $sessionId
     * @param string $data
     * @return bool
     */
    public function write($sessionId, $data)
    {
        return $this->_adapter->save($sessionId,$data);
    }

    /**
     * 判断会话状态
     * @return bool
     */
    public function isActive(){
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * 生成会话ID
     * @return string
     */
    public static function createId(){
        $char_id = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = "";
        $uuid = substr($char_id, 0, 8).$hyphen
            .substr($char_id, 8, 4).$hyphen
            .substr($char_id,12, 4).$hyphen
            .substr($char_id,16, 4).$hyphen;
        return $uuid;
    }


}