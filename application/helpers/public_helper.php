<?php
/**
 * 判断是否为ajax请求
 * @return boolean
 */
function isAjax(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
 * 获取请求类型
 * @return boolean
 */
function ajaxType(){
    switch ($_SERVER['HTTP_ACCEPT']){
        case 'application/json, text/javascript, */*':
            //  JSON 格式
            return 'json';
            break;
        case 'text/javascript, application/javascript, */*':
            // javascript 或 JSONP 格式
            return 'jsonp';
            break;
        case 'text/html, */*':
            //  HTML 格式
            return 'html';
            break;
        case 'application/xml, text/xml, */*':
            //  XML 格式
            return 'xml';
            break;
    }
}
/**
 * 规范json返回格式
 * @param number $statusCode 状态码(1:成功,2:错误,3:消息提醒)
 * @param string $message 提示信息
 * @param array $data 返回数据
 * @return array
 */
function ajaxFormat($statusCode = 1,$message = '',$data = array()){
    $data = array('statusCode'=>$statusCode, 'message' => $message, 'data'=>$data);
    return $data;
}
/**
 * 兼容的json_encode方法
 * @param array $value
 */
function jsonEncode($value){
    if (function_exists('json_encode')){
        return json_encode($value);
    }else{
        require_once APPPATH.'libraries/JSON.php';
        $json = new Services_JSON();
        return $json->encode($value);
    }
}
/**
 * 兼容的json_decode方法
 * @param string $jsonStr
 */
function jsonDecode($jsonStr, $toArray = true){
    /* if (function_exists('json_decode')){
        return json_decode($jsonStr, $toArray);
    }else{ */
        require_once APPPATH.'libraries/JSON.php';
        $json = new Services_JSON();
        $value = $json->decode($jsonStr);
        if ($toArray){
            $value = toArray($value);
        }
        return $value;
    //}
}
/**
 * 递归转换为数组
 */
function toArray($obj){
    $value = (array)$obj;
    foreach($value as $k => $v){
        if (is_object($v)){
            $value[$k] = toArray($v);
        }
    }
    return $value;
}
/**
 * 页面跳转方法，基本方法，涵盖异步请求的判断
 * @param number $status
 * @param string $message
 * @param number $waitSecond
 * @param string $jumpUrl
 */
function dispatchJump($status = 1, $message = '', $jumpUrl = '', $waitSecond = 1, $paramData = array()){
    $CI =& get_instance();
    $waitSecond || $waitSecond = 1;//默认跳转等待时间为1秒
    $msgTitle = '';
    if ($status == 1){
        $msgTitle = '操作成功';
        $jumpUrl || $jumpUrl =  $_SERVER['HTTP_REFERER'];
    }elseif ($status == 2){
        $msgTitle = '操作失败';
        $jumpUrl || $jumpUrl = $_SERVER['HTTP_REFERER'];
    }elseif ($status == 3){
        $msgTitle = '信息提示';
        $jumpUrl || $jumpUrl =  $_SERVER['HTTP_REFERER'];
    }
    $paramData['jumpUrl'] = $jumpUrl;
    $message || $message = $msgTitle;
    
    if (isAjax()){//判断是否为异步请求
        $originData = array('waitSecond'=>$waitSecond,'jumpUrl'=>$jumpUrl);
        echo jsonEncode(ajaxFormat($status, $message, array_merge($originData, $paramData)));
        exit();
    }else{
        $data = array(
            'status' => $status,
            'msgTitle' => $msgTitle,
            'message' => $message,
            'waitSecond' => $waitSecond,
            'jumpUrl' => $jumpUrl
        );
        echo $CI->load->view('common/dispatchJump', $data, true);
        exit();
    }
}
/**
 * 成功跳转或ajax异步返回
 * @param string $message
 * @param string $jumpUrl
 * @param number $waitSecond
 */
function showSuccess($message = '', $jumpUrl = '', $waitSecond = 0, $paramData = array()){
    dispatchJump(1, $message, $jumpUrl, $waitSecond, $paramData);
}
/**
 * 错误跳转或ajax异步返回
 * @param string $message
 * @param string $jumpUrl
 * @param number $waitSecond
 */
function showError($message = '', $jumpUrl = '', $waitSecond = 0, $paramData = array()){
    dispatchJump(2, $message, $jumpUrl, $waitSecond, $paramData);
}
/**
 * 提示跳转或ajax异步返回
 * @param string $message
 * @param string $jumpUrl
 * @param number $waitSecond
 */
function showNotice($message = '', $jumpUrl = '', $waitSecond = 0, $paramData = array()){
    dispatchJump(3, $message, $jumpUrl, $waitSecond, $paramData);
}
/**
 * gbk编码转换为UTF8编码
 * @param  string $str
 * @return string
 */
function gbk2utf8($str) {
    if ( empty($str) ) return $str;
    return iconv('gbk//ignore', 'utf-8', $str);
    if(function_exists('iconv')){ return iconv('gbk//ignore','utf-8',$str); }
    if (function_exists('mb_convert_encoding')) { return mb_convert_encoding($str,'gbk','utf-8'); }
}
/**
 * UTF8编码转换为GBK编码
 * @param  string $utfstr
 * @return string
 */
function utf82gbk($utfstr) {
    if(function_exists('iconv')){ return iconv('utf-8','gbk//ignore',$utfstr); }
    if (function_exists('mb_convert_encoding')) { return mb_convert_encoding($utfstr,'utf-8','gbk'); }
}
/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice : $slice;
}
/**
 * 302跳转
 * @param string $url
 */
function redirect($url){
    header("Location: ".$url, TRUE, 302);
}
/**
 * 生成URL
 * @param string $c 控制器名
 * @param string $m 方法名
 * @param array $param 其他参数
 * @return string
 */
function printUrl($c, $m, $param = array()){
    $urlParam = array('c'=>$c, 'm'=>$m);
    $urlParam = array_merge($urlParam, $param);
    $arr = array();
    foreach ($urlParam as $k=>$v){
        $arr[] = $k.'='.$v;
    }
    return 'index.php?'.implode('&', $arr);
}
/**
 * 获取当前时间单元
 * @return float
 */
function getNowTimeUnit(){
    $nowMonth = date("m");
    return ceil($nowMonth/2);
}
/**
 * 获取时间单元开始时间戳
 * @param int $timeUnit
 * @param int $year
 * @return int
 */
function getTimeUnitStartTime($timeUnit, $year=''){
    $year || $year = date("Y");
    return strtotime($year.'-'.($timeUnit*2-1).'-01 00:00:00');
}
/**
 * 获取时间单元开始日期
 * @param int $timeUnit
 * @param string $year
 * @return string
 */
function getTimeUnitStartDate($timeUnit, $year=''){
    return date("Y-m-d", getTimeUnitStartTime($timeUnit, $year));
}
/**
 * 获取时间单元结束时间戳
 * @param int $timeUnit
 * @param int $year
 * @return int
 */
function getTimeUnitEndTime($timeUnit, $year=''){
    $year || $year = date("Y");
    //获取次月天数
    $mDays = date('t', strtotime($year.'-'.($timeUnit*2).'-01') );
    return strtotime($year.'-'.($timeUnit*2).'-'.$mDays.' 23:59:59');
}
/**
 * 获取时间单元结束日期
 * @param int $timeUnit
 * @param string $year
 * @return string
 */
function getTimeUnitEndDate($timeUnit, $year=''){
    return date("Y-m-d", getTimeUnitEndTime($timeUnit, $year));
}
/**
 * 获取数组深度的总数，在报表列出的时候有用
 * @param array $arr 数据源数组
 * @param int $deep 深度
 * @param number $inc 增加数
 * @return number 数量
 */
function getArrayDeepCount($arr,$deep,$inc = 0){
    if ($deep == 0){
        return count($arr)+$inc;
    }else if ($deep == 1){
        $count = 0;
        $count += (count($arr)+$inc);
        return $count;
    }else if ($deep == 2){
        $count = 0;
        foreach ((array)$arr as $v1){
            $count += (count($v1) + $inc);
        }
        return $count;
    }
}
/**
 * 统计提供数组的指定深度指定列的总和
 * @param array $arr
 * @param array $column
 * @param int $deep 维度(1:表示二维数组,2:表示三维数组)
 * @return number
 */
function getArrayColumnTotal($arr,$column=array(),$deep=1){
    $data = array();
    foreach ($column as $field){
        $data[$field] = 0;
    }
    if ($deep == 1){
        foreach ((array)$arr as $oneLevel){
            foreach ((array)$column as $field){
                if (isset($oneLevel[$field])){
                    $data[$field] += $oneLevel[$field];
                }
            }
        }
    }elseif ($deep == 2){
        foreach ((array)$arr as $oneLevel){
            foreach ((array)$oneLevel as $twoLevel){
                foreach ((array)$column as $field){
                    if (isset($twoLevel[$field])){
                        $data[$field] += $twoLevel[$field];
                    }
                }
            }
        }
    }
    return $data;
}
/**
 * 设置excel文件下载头
 * @param [type] $fileName [description]
 */
function setExcelDownHeader($fileName){
    $fileName = $fileName.'.xls';
    header("Content-Type:application/vnd.ms-excel");
    header("Pragma: public");
    header("Expires:0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    //中文名乱码问题
    $ua = $_SERVER["HTTP_USER_AGENT"];
    //Trident内核（代表：Internet Explorer），Gecko内核（代表：Mozilla Firefox），WebKit内核（代表：Safari、Chrome），Presto内核（代表：Opera）
    if (preg_match("/Trident|Edge/", $ua)) {//ie
        $encoded_filename = urlencode($fileName);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
    } else if (preg_match("/Firefox/", $ua)) {//火狐
        header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '"');
    } else {  
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
    }
    header("Content-Transfer-Encoding: binary ");
}
/**
 * 设置下载文件头
 * @param [type] $finleName [description]
 */
function setFileDownHeader($fileName, $filePath, $fileType){
    // 输入文件标签
    Header("Content-type: ".$fileType);
    Header("Accept-Ranges: bytes");
    Header("Accept-Length: ". filesize($filePath));
    //中文名乱码问题
    $ua = $_SERVER["HTTP_USER_AGENT"];
    //Trident内核（代表：Internet Explorer），Gecko内核（代表：Mozilla Firefox），WebKit内核（代表：Safari、Chrome），Presto内核（代表：Opera）
    if (preg_match("/Trident|Edge/", $ua)) {//ie
        $encoded_filename = urlencode($fileName);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
    } else if (preg_match("/Firefox/", $ua)) {//火狐
        header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '"');
    } else {  
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
    }
}