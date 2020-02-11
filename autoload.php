<?php
use dinglib\loader\Loader;
require_once __DIR__ . '/src/loader/Loader.php';
Loader::register(Loader::PSR_4,[
    'map' => [
        'dinglib' => __DIR__.'/src',
    ]
]);