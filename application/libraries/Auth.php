<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 认证类，加入一些权限认证等方法
 * @author Administrator
 *
 */
class Auth{
    var $user = null;
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
    /**
     * 构造函数
     * @param array $user
     */
    function Auth($user){
        $this->user = $user;
    }

}