<?php

use dinglib\example\SessionTest;
use dinglib\example\SignatureCheckerTest;

ini_set("display_errors","on");
require_once 'autoload.php';

try {
    //==========================================
    // 请去掉需要测试的模块代码
        SignatureCheckerTest::index();   //认证签名
//        SessionTest::index(); //会话管理
    //===========================================
} catch (Exception $exception) {
    echo $exception->getMessage()." At ".$exception->getFile()." On ".$exception->getLine()."(".get_class($exception).")";
    echo "<pre>";
    var_export($exception->getTrace());
}
