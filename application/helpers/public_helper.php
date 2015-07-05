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
 * 页面跳转方法，基本方法，涵盖异步请求的判断
 * @param number $status
 * @param string $message
 * @param number $waitSecond
 * @param string $jumpUrl
 */
function dispatchJump($status = 1, $message = '', $jumpUrl = '', $waitSecond = 1, $paramData = array()){
    $CI =& get_instance();
    $jumpUrl || $jumpUrl =  $CI->input->server('HTTP_REFERER');
    $waitSecond || $waitSecond = 1;//默认跳转等待时间为1秒
    $msgTitle = '';
    if ($status == 1){
        $msgTitle = '操作成功';
    }elseif ($status == 2){
        $msgTitle = '操作失败';
    }elseif ($status == 3){
        $msgTitle = '信息提示';
    }
    $message || $message = $msgTitle;
    
    if (isAjax()){//判断是否为异步请求
        $originData = array('waitSecond'=>$waitSecond,'jumpUrl'=>$jumpUrl);
        echo json_encode(ajaxFormat($status, $message, array_merge($originData, $paramData)));
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
    return 'index.php?'.http_build_query($urlParam);
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