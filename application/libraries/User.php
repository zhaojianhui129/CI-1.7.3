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
    var $limitStore100CityApply = '100CityApply';
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
    var $error = '';
    //用户模型
    var $sellpointModel = null;
    //用户基本
    var $userData = null;
    /**
     * 构造函数
     */
    function User(){
        session_start();
        //自定义类使用CI资源使用此方法
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->model('sellpointModel');
        $this->sellpointModel = $CI->sellpointModel;
        //判断是否退出
        if (!isset($_SESSION['DLRID']) || $_SESSION['DLRNAME'] == "")
        {
            $this->error = '您还未登录';
            $this->user = array();
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
            $storeData = $this->sellpointModel->getNewData(array('Account'=>$username));
            if (!$storeData || $storeData['password'] != $password){
                $this->error = '用户信息错误';
                $this->user = array();
                return false;
            }
            //查询权限设置信息表
            $CI->load->model('jurSellpointModel', 'authModel');
            $authList = $CI->authModel->getList(array('SellPointID'=>$storeData['userId'], 'application_system_id'=>array('in', array(59,60))));
            if (!$authList){
                $this->error = '您无权限进入此模块';
                $this->user = array();
                return false;
            }
            $this->user['userLimit'] = array();
            foreach ($authList as $v){
                //权限字符串
                $authStr = $v['application_system_id'] . '_' . $v['jurisdiction_id'];
                switch ($authStr){
                    case '61_115'://专营店申请权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStoreApply;
                        break;
                    case '61_116'://100城协办专营店查看权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStore100CityCheck;
                        break;
                    case '61_117'://100城主担专营店申请权限，查看权限
                        $this->user['userRole']     = $this->roleSellpoint;
                        $this->user['userLimit'][]  = $this->limitStore100CityApply;
                        break;
                    case '62_118'://小区督导端
                        $this->user['userRole']     = $this->roleSpsarea;
                        $this->user['userLimit'][]  = $this->limitSpsarea;
                        break;
                    case '62_119'://大区总监
                        $this->user['userRole']     = $this->roleRegion;
                        $this->user['userLimit'][]  = $this->limitRegion;
                        break;
                    case '62_122'://区域总监
                        $this->user['userRole']     = $this->roleeArea;
                        $this->user['userLimit'][]  = $this->limitArea;
                        break;
                    case '62_120'://总部
                        $this->user['userRole']     = $this->roleHead;
                        $this->user['userLimit'][]  = $this->limitHead;
                        break;
                    case '62_122'://查看角色
                        $this->user['userRole']     = $this->roleCheck;
                        $this->user['userLimit'][]  = $this->limitCheck;
                        break;
                }
            }
            //专营店判断是否为营销网专营店，过滤启程专营店
            if ($this->user['userRole'] == $this->roleSellpoint && $storeData['SpState_sys']){
                $this->error = '您非nissan专营店，不能进入此模块';
                $this->user = array();
                return false;
            }
            if ($this->user['userRole']){
                $this->user['userId']   = $storeData['userId'];
                $this->user['userName'] = $storeData['userName'];
            }
            //保存到session中
            $CI->session->set_userdata($this->user);
        }
        //将用户信息初始化到userData属性中
        $userData = $this->sellpointModel->getNewData(array('SellPointID'=>$this->user['userId']));//用户信息
        $this->userData = $userData;
    }
    /**
     * 获取用户信息
     */
    function getUserInfo(){
        if ($this->user['userId'] && $this->user['userRole']){
            return $this->user;
        }else{
            return false;
        }
    }
    /**
     * 获取用户可以查看的专营店ID列表
     */
    function getViewStoreIds(){
        $storeIds = array();
        //载入专营店模型
        $CI =& get_instance();
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                if (in_array($this->limitStoreApply, $this->user['userLimit'])){//普通专营店
                    $storeIds[] = $this->user['userId'];
                }elseif (in_array($this->limitStore100CityCheck, $this->user['userLimit'])){//协办店
                    $CI->load->model('importMoneyModel');
                    //获取主担店数据
                    $storeIds[] = $CI->importMoneyModel->getMainStoreId($this->userData['city'], date('Y'));
                }elseif (in_array($this->limitStore100CityApply, $this->user['userLimit'])){//主担店
                    $storeIds[] = $this->user['userId'];
                }
                break;
            case $this->roleSpsarea://小区督导
                //小区对应专营店列表
                $spsareaToStoreList = $this->sellpointModel->getCacheData('spsareaToStoreList');
                if (isset($spsareaToStoreList[$this->userData['spsarea']])){
                    foreach ($spsareaToStoreList[$this->userData['spsarea']] as $k => $v){
                        $storeIds[] = $k;
                    }
                }
                break;
            case $this->roleRegion://大区总监
                //大区对应专营店列表
                $regionToStoreList = $this->sellpointModel->getCacheData('regionToStoreList');
                if (isset($regionToStoreList[$this->userData['region']])){
                    foreach ($regionToStoreList[$this->userData['region']] as $k => $v){
                        $storeIds[] = $k;
                    }
                }
                break;
            case $this->roleArea://区域总监
                //地区对应专营店列表
                $areaToStoreList = $this->sellpointModel->getCacheData('areaToStoreList');
                if (isset($areaToStoreList[$this->userData['area']])){
                    foreach ($areaToStoreList[$this->userData['area']] as $k => $v){
                        $storeIds[] = $k;
                    }
                }
                break;
            case $this->roleHead://总部
                $storeIds = '*';
                break;
            case $this->roleCheck://查看端
                $storeIds = '*';
                break;
        }
        return $storeIds;
    }
    /**
     * 获取用户树结构地区列表
     * @return Ambigous <multitype:unknown , unknown>
     */
    function getPlaceTree(){
        //树形地区列表
        $treeAreaList = array();
        //所有地区树形结构
        $placeTree = $this->sellpointModel->getCacheData('placeTree');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $treeAreaList[$this->userData['area']][$this->userData['region']][$this->userData['spsarea']] = $this->userData['userId'];
                break;
            case $this->roleSpsarea://小区督导
                $treeAreaList[$this->userData['area']][$this->userData['region']][$this->userData['spsarea']] = $placeTree[$this->userData['area']][$this->userData['region']][$this->userData['spsarea']];
                break;
            case $this->roleRegion://大区总监
                $treeAreaList[$this->userData['area']][$this->userData['region']] = $placeTree[$this->userData['area']][$this->userData['region']];
                break;
            case $this->roleArea://区域总监
                $treeAreaList[$this->userData['area']] = $placeTree[$this->userData['area']];
                break;
            case $this->roleHead://总部
                $treeAreaList = $placeTree;
                break;
            case $this->roleCheck://查看端
                $treeAreaList = $placeTree;
                break;
        }
        return $treeAreaList;
    }
    /**
     * 获取用户地区列表
     * @return multitype:
     */
    function getAreaList(){
        $list = array();
        $areaList = $this->sellpointModel->getCacheData('areaList');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $list = array($this->userData['area']);
                break;
            case $this->roleSpsarea://小区督导
                $list = array($this->userData['area']);
                break;
            case $this->roleRegion://大区总监
                $list = array($this->userData['area']);
                break;
            case $this->roleArea://区域总监
                $list = array($this->userData['area']);
                break;
            case $this->roleHead://总部
                $list = $areaList;
                break;
            case $this->roleCheck://查看端
                $list = $areaList;
                break;
        }
        $data = array();
        foreach ($list as $v){
            $data[] = array('key'=>$v, 'value'=>$v);
        }
        return $data;
    }
    /**
     * 获取用户大区列表
     * @param string $area 地区
     * @return multitype:
     */
    function getRegionList($area){
        $list = array();
        $areaToRegionList = $this->sellpointModel->getCacheData('areaToRegionList');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $list = array($this->userData['region']);
                break;
            case $this->roleSpsarea://小区督导
                $list = array($this->userData['region']);
                break;
            case $this->roleRegion://大区总监
                $list = array($this->userData['region']);
                break;
            case $this->roleArea://区域总监
                $list = isset($areaToRegionList[$area]) ? $areaToRegionList[$area] : array();
                break;
            case $this->roleHead://总部
                $list = isset($areaToRegionList[$area]) ? $areaToRegionList[$area] : array();
                break;
            case $this->roleCheck://查看端
                $list = isset($areaToRegionList[$area]) ? $areaToRegionList[$area] : array();
                break;
        }
        $data = array();
        foreach ($list as $v){
            $data[] = array('key'=>$v, 'value'=>$v);
        }
        return $data;
    }
    /**
     * 获取省份列表
     * @param string $region
     * @return multitype:
     */
    function getProvinceList($region){
        $list = array();
        $regionToProvinceList = $this->sellpointModel->getCacheData('regionToProvinceList');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $list = array($this->userData['province']);
                break;
            case $this->roleSpsarea://小区督导
                $list = isset($regionToProvinceList[$region]) ? $regionToProvinceList[$region] : array();
                break;
            case $this->roleRegion://大区总监
                $list = isset($regionToProvinceList[$region]) ? $regionToProvinceList[$region] : array();
                break;
            case $this->roleArea://区域总监
                $list = isset($regionToProvinceList[$region]) ? $regionToProvinceList[$region] : array();
                break;
            case $this->roleHead://总部
                $list = isset($regionToProvinceList[$region]) ? $regionToProvinceList[$region] : array();
                break;
            case $this->roleCheck://查看端
                $list = isset($regionToProvinceList[$region]) ? $regionToProvinceList[$region] : array();
                break;
        }
        $data = array();
        foreach ($list as $v){
            $data[] = array('key'=>$v, 'value'=>$v);
        }
        return $data;
    }
    /**
     * 获取省份对应城市列表
     * @param unknown $province
     * @return multitype:
     */
    function getCityList($province){
        $list = array();
        $provinceToCityList = $this->sellpointModel->getCacheData('provinceToCityList');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $list = array($this->userData['city']);
                break;
            case $this->roleSpsarea://小区督导
                $list = isset($provinceToCityList[$province]) ? $provinceToCityList[$province] : array();
                break;
            case $this->roleRegion://大区总监
                $list = isset($provinceToCityList[$province]) ? $provinceToCityList[$province] : array();
                break;
            case $this->roleArea://区域总监
                $list = isset($provinceToCityList[$province]) ? $provinceToCityList[$province] : array();
                break;
            case $this->roleHead://总部
                $list = isset($provinceToCityList[$province]) ? $provinceToCityList[$province] : array();
                break;
            case $this->roleCheck://查看端
                $list = isset($provinceToCityList[$province]) ? $provinceToCityList[$province] : array();
                break;
        }
        $data = array();
        foreach ($list as $v){
            $data[] = array('key'=>$v, 'value'=>$v);
        }
        return $data;
    }
    /**
     * 获取城市对应专营店列表
     * @param unknown $city
     * @return multitype:
     */
    function getStoreList($city){
        $list = array();
        $cityToStoreList = $this->sellpointModel->getCacheData('cityToStoreList');
        switch ($this->user['userRole']){
            case $this->roleSellpoint://专营店角色
                $list = array($this->userData['city']);
                break;
            case $this->roleSpsarea://小区督导
                $list = isset($cityToStoreList[$city]) ? $cityToStoreList[$city] : array();
                break;
            case $this->roleRegion://大区总监
                $list = isset($cityToStoreList[$city]) ? $cityToStoreList[$city] : array();
                break;
            case $this->roleArea://区域总监
                $list = isset($cityToStoreList[$city]) ? $cityToStoreList[$city] : array();
                break;
            case $this->roleHead://总部
                $list = isset($cityToStoreList[$city]) ? $cityToStoreList[$city] : array();
                break;
            case $this->roleCheck://查看端
                $list = isset($provinceToCityList[$city]) ? $cityToStoreList[$city] : array();
                break;
        }
        $data = array();
        foreach ($list as $v){
            $data[] = array('key'=>$v['userId'], 'value'=>$v['storeName']);
        }
        return $data;
    }
}