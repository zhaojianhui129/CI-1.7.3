<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户类
 * @author Administrator
 *
 */
class User{
    //专营店申请权限常量
    var $limitStoreApply = 'apply';
    //100城协办专营店查看权限常量
    var $limitStore100CityCheck = '100CityCheck';
    //100城主担专营店申请权限，查看权限
    var $limitStore100CityApplyCheck = '100CityApplyCheck';
    //小区督导端常量
    var $limitSpsarea = 'spsarea';
    //大区总监常量
    var $limitRegion = 'region';
    //区域总监常量
    var $limitArea  = 'area';
    //总部常量
    var $limitHead = 'head';
    //查看角色常量
    var $limitCheck = 'check';
    //专营店常量
    var $roleSellpoint = 1;
    //小区督导端常量
    var $roleSpsarea = 2;
    //大区总监常量
    var $roleRegion = 3;
    //区域总监常量
    var $roleeArea  = 4;
    //总部常量
    var $roleHead = 5;
    //查看角色常量
    var $roleCheck = 6;
    //用户信息
    var $user   =   array(
        'userId'    => 0,//用户ID
        'userName'  => '',//用户名称
        'userRole'  => 0,//用户角色
        'userLimit' => array(),//用户权限
    );
    /**
     * 获取权限信息
     */
    function getUserInfo(){
        session_start();
        //自定义类使用CI资源使用此方法
        $CI =& get_instance();
        $CI->load->library('session');
        //判断是否退出
        if (!isset($_SESSION['DLRID']) || $_SESSION['DLRNAME'] == "")
        {
            return false;
        }
        
        $this->user['userId']      = $CI->session->userdata('userId');
        $this->user['userName']    = $CI->session->userdata('userName');
        $this->user['userRole']    = $CI->session->userdata('userRole');
        $this->user['userLimit']   = $CI->session->userdata('userLimit');
        
        if ($this->user['userId'] != $_SESSION['DLRID']){
            //当前登陆用户名密码
            $username = $_COOKIE['lAccount'];
            $password = $_COOKIE['lPassword'];
            $CI->load->model('sellpointModel');
            $storeData = $CI->sellpointModel->getNewData(array('Account'=>$username));
            if (!$storeData || $storeData['password'] != $password){
                return false;
            }
            //查询权限设置信息表
            $CI->load->model('jurSellpointModel', 'authModel');
            $authList = $CI->authModel->getList(array('SellPointID'=>$storeData['userId'], 'application_system_id'=>array('in', array(59,60))));
            if (!$authList){
                return false;
            }
            foreach ($authList as $v){
                //权限字符串
                $authStr = $v['application_system_id'] . '_' . $v['jurisdiction_id'];
                switch ($authStr){
                    case '59_107'://专营店申请权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStoreApply;
                        break;
                    case '59_108'://100城协办专营店查看权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStore100CityCheck;
                        break;
                    case '59_109'://100城主担专营店申请权限，查看权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStore100CityApplyCheck;
                        break;
                    case '60_110'://小区督导端
                        $this->user['userRole']     = $this->roleSpsarea;
                        $this->user['userLimit'][]  = $this->limitSpsarea;
                        break;
                    case '60_111'://大区总监
                        $this->user['userRole']     = $this->roleRegion;
                        $this->user['userLimit'][]  = $this->limitRegion;
                        break;
                    case '60_123'://区域总监
                        $this->user['userRole']     = $this->roleeArea;
                        $this->user['userLimit'][]  = $this->limitArea;
                        break;
                    case '60_112'://总部
                        $this->user['userRole']     = $this->roleHead;
                        $this->user['userLimit'][]  = $this->limitHead;
                        break;
                    case '60_113'://查看角色
                        $this->user['userRole']     = $this->roleCheck;
                        $this->user['userLimit'][]  = $this->limitCheck;
                        break;
                }
            }
            if ($this->user['userRole']){
                $this->user['userId']   = $storeData['userId'];
                $this->user['userName'] = $storeData['userName'];
            }
        }
        if ($this->user['userId'] && $this->user['userRole']){
            //保存到session中
            $CI->session->set_userdata($this->user);
            return $this->user;
        }else{
            return false;
        }
    }
}