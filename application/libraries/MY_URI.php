<?php
/**
 * 支持中文
 * @author Administrator
 *
 */
class MY_URI extends CI_URI {
    function _filter_uri($str)
    {
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '')
        {
            $str = urlencode($str);  // 注意这里
            if ( !preg_match("|^[".$this->config->item('permitted_uri_chars')."]+$|i", $str))
            {
                show_error('The URI you submitted has disallowed characters.');
            }
            $str = urldecode($str);  // 注意这里
        }
        return $str;
    }  
}