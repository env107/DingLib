<?php
namespace dinglib\example;
use dinglib\dingphp\api\json\ApiJson;
use dinglib\dingphp\api\request\checker\SignatureChecker;
use dinglib\dingphp\api\request\DefaultRequestDataProvider;
use dinglib\dingphp\api\request\RequestChecker;
use dinglib\dingphp\api\request\RequestCheckerQueue;
use dinglib\dingphp\api\request\checker\HeaderInfoChecker;
use dinglib\dingphp\api\request\checker\MethodChecker;

class SignatureCheckerTest {

    public static function index(){
        header("content-type:application/json;charset=utf-8");
        $checkers = [
            MethodChecker::class,
            HeaderInfoChecker::class,
            SignatureChecker::class
        ];
        $provider = DefaultRequestDataProvider::getInstance();
        $queue = RequestCheckerQueue::getInstance();
        $queue->push($checkers);
        $result = RequestChecker::getInstance($provider)->run($queue);
        if($result === TRUE) {
            echo ApiJson::build()->setMessage("签名认证成功")->createJson();
        } else {
            echo ApiJson::build()->setErrCode(-1)->setMessage("签名认证失败")->setDebug()->createJson();
        }

    }

}