<?php

namespace dinglib\example;


use dinglib\dingphp\api\json\ApiJson;
use dinglib\dingphp\session\adapter\FilesSessionAdapter;
use dinglib\dingphp\session\Session;

class SessionTest
{
    public static function index(){
        header("content-type:application/json;charset=utf-8");
        $adapter = new FilesSessionAdapter(__DIR__."/sessiondata");
        $session = Session::build($adapter);
        $session->load("NEW_SESSION_ID");
        $_SESSION['text'] = "hello";
        $_SESSION['index'] = 0;
        $session->load("OLD_SESSION_ID");
        $_SESSION['text'] = "hello,joke!";
        $_SESSION['index'] = 1;
        echo ApiJson::build()->setData(['session'=>$_SESSION])->createJson();
    }
}