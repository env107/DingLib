<?php

namespace dinglib\loader;

class Loader
{

    const PSR_0 = 'psr0';
    const PSR_4 = 'psr4';

    /**
     * 注册参数
     * @var array
     */
    private static $_options = [
        Loader::PSR_0 => [
            'path' => __DIR__,
            'ext' => '.php'
        ],
        Loader::PSR_4 => [
            'map' => [],
            'ext' => '.php'
        ]
    ];


    public static function register($psr = Loader::PSR_0 , $options = []){
        self::config($psr,$options);
        spl_autoload_register("self::_".$psr);
    }

    /**
     * 合并配置
     * @param $psr
     * @param $options
     */
    private static function config($psr,$options){
        self::$_options[$psr] = array_merge(self::$_options[$psr],$options);
    }

    /**
     * psr-0自动加载
     * @param $name
     */
    private static function _psr0($name){
        $classinfo = self::classInfo($name);
        $classname = str_replace("_",DIRECTORY_SEPARATOR,$classinfo['classname']);
        $class = self::filterPath(self::$_options[Loader::PSR_0]['path'].DIRECTORY_SEPARATOR.$classinfo['namespace'].DIRECTORY_SEPARATOR.$classname);
        require_once $class.self::$_options[Loader::PSR_0]['ext'];
    }

    /**
     * psr-4自动加载
     * @param $name
     */
    private static function _psr4($name){
        $classInfo = self::classInfo($name);
        $replacePath = $classInfo['namespace'];
        foreach (self::$_options[Loader::PSR_4]['map'] as $key => $value){
            if(stripos($classInfo['namespace'],$key) > -1){
                $replacePath = str_replace($key,$value,$classInfo['namespace']);
            }
        }
        $classInfo['namespace'] = $replacePath;
        $class = self::filterPath(
            $classInfo['namespace'].DIRECTORY_SEPARATOR.$classInfo['classname']
        );
        require_once $class.self::$_options[Loader::PSR_4]['ext'];
    }

    /**
     * 获取类信息
     * @param $class
     * @return array|null
     */
    private static function classInfo($class){
        $info = explode("\\",$class);
        if(empty($info)){
            return null;
        }
        $classname = array_pop($info);
        $namespace = implode("\\",$info);
        return [
            'classname' => $classname,
            'namespace' => $namespace
        ];
    }

    /**
     * 过滤路径分隔符
     * @param $path
     * @return string
     */
    private static function filterPath($path){
        $data = explode(DIRECTORY_SEPARATOR,preg_replace("/\/|\\\/",DIRECTORY_SEPARATOR,$path));
        $data = array_filter($data,function($value,$index){
            if($value === ""){
                return $index === 0 ? true : false;
            }
            return true;
        },ARRAY_FILTER_USE_BOTH);
        return implode(DIRECTORY_SEPARATOR,$data);
    }


}