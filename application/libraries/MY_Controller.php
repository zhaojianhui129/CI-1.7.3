<?php
/**
 * 自动提示基类控制器，新建控制器继承此控制器
 * @author Administrator
 *
 */
class MY_Controller extends Controller
{
    /**
     * @var CI_Loader
     */
    var $load ;
    /**
     * @var CI_DB_active_record
     */
    var $db ;
    /**
     * @var CI_Calendar
     */
    var $calendar ;
    /**
     * @var Email
     */
    var $email ;
    /**
     * @var CI_Encrypt
     */
    var $encrypt ;
    /**
     * @var CI_Ftp
     */
    var $ftp ;
    /**
     * @var CI_Hooks
     */
    var $hooks ;
    /**
     * @var CI_Image_lib
     */
    var $image_lib ;
    /**
     * @var CI_Language
     */
    var $language ;
    /**
     * @var CI_Log
     */
    var $log ;
    /**
     * @var CI_Output
     */
    var $output ;
    /**
     * @var CI_Input
     */
    var $input ;
    /**
     * @var CI_Pagination
     */
    var $pagination ;
    /**
     * @var CI_Parser
     */
    var $parser ;
    /**
     * @var CI_Session
     */
    var $session ;
    /**
     * @var CI_Sha1
     */
    var $sha1 ;
    /**
     * @var CI_Table
     */
    var $table ;
    /**
     * @var CI_Trackback
     */
    var $trackback ;
    /**
     * @var CI_Unit_test
     */
    var $unit ;
    /**
     * @var CI_Upload
     */
    var $upload ;
    /**
     * @var CI_URI
     */
    var $uri ;
    /**
     * @var CI_User_agent
     */
    var $agent ;
    /**
     * @var CI_Validation
     */
    var $validation ;
    /**
     * @var CI_Xmlrpc
     */
    var $xmlrpc ;
    /**
     * @var CI_Zip
     */
    var $zip ;
    /**
     * @var CI_Form
     */
    var $form_validation ;
    
    //用户信息
    var $userInfo = NULL;
    //传给视图的数据
    var $viewData = array();

    function MY_Controller()
    {
        parent::Controller();
        $this->load->library('User');
        $this->userInfo = $this->user->getUserInfo();
        if (! $this->userInfo){
            $this->error('您无权限登陆此系统');
        }
        //加载认证类，全局可以调用
        $this->load->library('auth', $this->userInfo);
    }
    /**
     * 页面跳转方法，基本方法，涵盖异步请求的判断
     * @param number $status
     * @param string $message
     * @param number $waitSecond
     * @param string $jumpUrl
     */
    function dispatchJump($status = 1, $message = '', $jumpUrl = '', $waitSecond=1){
        $jumpUrl || $jumpUrl =  $this->input->server('HTTP_REFERER');
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
            echo json_encode(ajaxFormat($status,$message,array('waitSecond'=>$waitSecond,'jumpUrl'=>$jumpUrl)));
            exit();
        }else{
            $data = array(
                'status' => $status,
                'msgTitle' => $msgTitle,
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl
            );
            echo $this->load->view('common/dispatchJump', $data, true);
            exit();
        }
    }
    /**
     * 成功跳转或ajax异步返回
     * @param string $message
     * @param string $jumpUrl
     * @param number $waitSecond
     */
    function success($message = '', $jumpUrl = '', $waitSecond=1){
        $this->dispatchJump(1, $message, $jumpUrl, $waitSecond);
    }
    /**
     * 错误跳转或ajax异步返回
     * @param string $message
     * @param string $jumpUrl
     * @param number $waitSecond
     */
    function error($message = '', $jumpUrl = '', $waitSecond=1){
        $this->dispatchJump(2, $message, $jumpUrl, $waitSecond);
    }
    /**
     * 提示跳转或ajax异步返回
     * @param string $message
     * @param string $jumpUrl
     * @param number $waitSecond
     */
    function notice($message = '', $jumpUrl = '', $waitSecond=1){
        $this->dispatchJump(3, $message, $jumpUrl, $waitSecond);
    }
}