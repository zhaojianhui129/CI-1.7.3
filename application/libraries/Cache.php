<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 缓存类
 * @author jianhui
 *
 */
class Cache{
    var $expire = 3600;
    var $cachePath = '';
    function Cache(){
        //初始化缓存目录
        $this->cachePath = FCPATH . APPPATH .'cache/';
        //判断缓存目录是否存在，不存在则创建
        if (!is_dir($this->cachePath)){
            mkdir($this->cachePath, 0777);
        }
    }
    /**
     * 设置子目录
     * @param string $path
     */
    function setChildPath($path){
        $this->cachePath .= $path.'/';
        //判断缓存目录是否存在，不存在则创建
        if (!is_dir($this->cachePath)){
            mkdir($this->cachePath, 0777);
        }
    }
    /**
     * 设置缓存
     * @param string $name
     * @param mix $value
     */
    function set($name, $value){
        //缓存文件路径
        $filePath = $this->cachePath . $name . '.php';
        //创建并以写入方式打开
        if (file_exists($filePath)){
            $handle = fopen($filePath, 'w');
        }else{
            $handle = fopen($filePath, 'x');
        }
        //文件内容
        $content = "<?php \r\nreturn ". var_export($value, true) . ';';
        //写入文件
        fwrite($handle, $content);
        //关闭文件
        fclose($handle);
    }
    /**
     * 获取缓存内容
     * @param string $name
     * @return mix
     */
    function get($name){
        //缓存文件路径
        $filePath = $this->cachePath . $name . '.php';
        //文件存在并且在过期秒数内
        if (file_exists($filePath) && time() - filemtime($filePath) < $this->expire){
            return require($filePath);
        }else{
            return false;
        }
    }
    /**
     * 删除缓存
     * @param string $name
     */
    function del($name){
        //缓存文件路径
        $filePath = $this->cachePath . $name . '.php';
        unlink($filePath);
    }
}