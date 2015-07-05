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
    /**
     * 是否有添加预算申请权限
     * @param array $procData
     * @return boolean
     */
    function isSingleBudgetAdd($procData){
        if ($procData['id']){
            return false;
        }
        //时间验证
        if (!isset($procData['timeUnit']) || !$procData['timeUnit']){
            return false;
        }
        $nowTime = time();//当前时间戳
        if ($nowTime < getTimeUnitStartTime($procData['timeUnit'],$procData['year'])-86400*10 || $nowTime > getTimeUnitEndTime($procData['timeUnit'], $procData['year'])){
            return false;
        }
        //用户身份验证
        if ($this->user['userRole'] != $this->roleSellpoint || !in_array('apply', $this->user['userLimit'])){
            return false;
        }
        return true;
    }
    /**
     * 是否有修改预算申请权限
     * @param array $procData
     * @return boolean
     */
    function isSingleBudgetEdit($procData){
        //时间验证
        if (!isset($procData['timeUnit']) || !$procData['timeUnit']){
            return false;
        }
        $nowTime = time();//当前时间戳
        if ($nowTime < getTimeUnitStartTime($procData['timeUnit'],$procData['year'])-86400*10 || $nowTime > getTimeUnitEndTime($procData['timeUnit'], $procData['year'])){
            return false;
        }
        //用户身份验证
        if ($this->user['userRole'] != $this->roleSellpoint || !in_array('apply', $this->user['userLimit'])){
            return false;
        }
        if($procData['storeId'] != $this->user['userId']){
            return false;
        }
        //数据有效性验证
        if (!isset($procData['id']) || !$procData['id']){
            return false;
        }
        return true;
    }
    /**
     * 是否有查看单点预算权限;
     * @param array $procData
     * @return boolean
     */
    function isSingleBudgetCheck($procData){
        if (!isset($procData['id']) || !$procData['id']){
            return false;
        }
        return true;
    }
    /**
     * 判断是否有导入管理权限
     * @return boolean
     */
    function isImport(){
        if ($this->user['userRole'] != $this->roleHead){
            return false;
        }
        return true;
    }
}