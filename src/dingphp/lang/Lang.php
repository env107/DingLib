<?php


namespace dinglib\dingphp\lang;


use dinglib\dingphp\exceptions\lang\LangException;

class Lang
{

    private static $_lang = 'zh_CN';

    private static $_path = [__DIR__];

    /**
     * 设置语言环境
     * @param $lang
     */
    public static function setLang($lang){
        self::$_lang = $lang;
    }

    /**
     * 设置语言文件存放路径
     * @param array $path
     */
    public static function setPath(array $path){
        self::$_path = $path;
    }

    /**
     * 添加语言文件路径
     * @param string $path
     * @return int
     */
    public static function appendPath($path){
        if(is_array($path) && isset($path[0]) && !empty($path)) {
            $path = $path[0];
        }
        return array_push(self::$_path,$path);
    }

    /**
     * 获取对应语言键值
     * @param $key
     * @return mixed|null
     */
    private static function _handle($key){
        $info = explode(".",$key);
        if(count($info) > 1){
            $lang = $info[0];
            $key = $info[1];
        } else {
            $lang = self::$_lang;
        }
        $langData = [];
        foreach (self::$_path as $path){
            $langData = array_merge($langData,self::_langData($lang,$path));
        }
        if(!isset($langData[$key])) {
            throw new \Exception("Language key [".$key."] not found!");
        }
        if(!is_string($langData[$key]) && !is_numeric($langData[$key])){
            throw new LangException("Language value must type of string or number");
        }
        return $langData[$key];
    }

    /**
     * 解析语言文件
     * @param $lang
     * @return array
     */
    private static function _langData($lang,$path) {
        $langfile = $path . DIRECTORY_SEPARATOR . $lang.".php";
        if(!file_exists($langfile)) {
            throw new \Exception("Language file not found ![file=".$langfile."]");
        }
        $lang = require_once $langfile;
        if(!is_array($lang)) {
            //todo 后续引入更多语言文件解析器
            return [];
        }
        ksort($lang,SORT_DESC);
        $lang = array_combine(array_map(function($key){
            return strtolower($key);
        },array_keys($lang)),array_values($lang));
        return $lang;
    }


    /**
     * 获取值
     * @param $name
     * @return mixed|null
     */
    public static function get($name)
    {
        $key = strtolower($name);
        return self::_handle($key);
    }




}