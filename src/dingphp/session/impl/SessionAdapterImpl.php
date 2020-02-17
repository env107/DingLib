<?php

namespace dinglib\dingphp\session\impl;


interface SessionAdapterImpl
{
    /**
     * 保存会话信息
     * @param $sessionId
     * @param $data
     * @return bool
     */
    public function save($sessionId,$data);

    /**
     * 读取会话信息
     * @param $sessionId
     * @return string
     */
    public function read($sessionId);

    /**
     * 删除会话信息
     * @param $sessionId
     * @return bool
     */
    public function remove($sessionId);

    /**
     * 会话过期
     * @param $sessionId
     * @return bool
     */
    public function expires($sessionId);

    /**
     * 判断会话是否存在
     * @param $sessionId
     * @return bool
     */
    public function exist($sessionId);
}