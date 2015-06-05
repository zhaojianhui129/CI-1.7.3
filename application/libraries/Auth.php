<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 认证类，加入一些权限认证等方法
 * @author Administrator
 *
 */
class Auth{
    //专营店常量
    var $roleValueSellpoint = 1;
    //小区督导端常量
    var $roleValueSpsarea = 2;
    //大区总监常量
    var $roleValueRegion = 3;
    //区域总监常量
    var $roleValueArea  = 4;
    //总部常量
    var $roleValueHead = 5;
    //查看角色常量
    var $roleValueCheck = 6;
    
    //用户信息
    var $user   =   array(
        'userId'    => 0,//用户ID
        'userName'  => '',//用户名称
        'userRole'  => 0,//用户角色
    );
    /**
     * 构造函数
     * @param array $user
     */
    function Auth($user){
        $this->user = $user;
    }
    /**
     * 检测是否有登陆此系统权限
     */
    function checkSystem(){
        return true;
        if (in_array($this->user['userRole'], array(0,1,2,3,4,5))){
            return false;
        }
        return true;
    }
    
}