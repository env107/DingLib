<?php

namespace dinglib\dingphp\session\adapter;


use dinglib\dingphp\exceptions\session\SessionException;
use dinglib\dingphp\lang\Lang;
use dinglib\dingphp\session\impl\SessionAdapterImpl;

class FilesSessionAdapter implements SessionAdapterImpl
{

    private $_ext = '';

    private $_path = '';

    public function __construct($path,$ext = null)
    {
        $this->_path = $path;
        $this->_ext = $ext;

        if(empty($this->_path)) {
            throw new SessionException(Lang::get("SESSION_FILE_NULL"));
        }

        if(!file_exists($this->_path)){
            throw new SessionException(Lang::get("SESSION_FILE_PATH_NOT_FOUND"));
        }

        if(empty($this->_ext)) {
            $this->_ext = '.ses';
        }
    }

    /**
     * 保存会话信息
     * @param $sessionId
     * @param $data
     * @return bool
     */
    public function save($sessionId,$data)
    {
        return $this->_writeSessionFile($sessionId,$data);
    }

    /**
     * 读取会话信息
     * @param $sessionId
     * @return string
     */
    public function read($sessionId)
    {
        return $this->_loadSessionFile($sessionId);
    }

    /**
     * 删除会话信息
     * @param $sessionId
     * @return bool
     */
    public function remove($sessionId)
    {
        return $this->_removeSessionFile($sessionId);
    }

    /**
     * 会话过期
     * @param $sessionId
     * @return bool
     */
    public function expires($sessionId)
    {
        return true;
    }

    private function _getSessionFile($sessionId){
        return $this->_path.DIRECTORY_SEPARATOR.$sessionId.$this->_ext;
    }

    private function _writeSessionFile($sessionId,$content){
        return file_put_contents($this->_getSessionFile($sessionId),$content) !== FALSE ? TRUE : FALSE;
    }

    private function _loadSessionFile($sessionId){
        $file = $this->_getSessionFile($sessionId);
        if(!file_exists($file)) {
            touch($file);
        }
        return file_get_contents($file);
    }

    private function _removeSessionFile($sessionId){
        return unlink($this->_getSessionFile($sessionId));
    }

    /**
     * 判断会话是否存在
     * @param $sessionId
     * @return bool
     */
    public function exist($sessionId)
    {
        return file_exists($this->_getSessionFile($sessionId));
    }
}