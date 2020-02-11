<?php

use dinglib\example\SessionTest;
use dinglib\example\SignatureCheckerTest;

ini_set("display_errors","on");
require_once 'autoload.php';

try {
//    SignatureCheckerTest::index();
      SessionTest::index();
} catch (Exception $exception) {
    echo $exception->getMessage()." At ".$exception->getFile()." On ".$exception->getLine()."(".get_class($exception).")";
    echo "<pre>";
    var_export($exception->getTrace());
}
