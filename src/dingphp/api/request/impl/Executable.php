<?php

namespace dinglib\dingphp\api\request\impl;


interface Executable
{
    /**
     * 校验器运行方法
     * @param RequestCheckerQueueImpl $checkerQueueImpl
     * @return bool
     */
    public function run(RequestCheckerQueueImpl $checkerQueueImpl);
}