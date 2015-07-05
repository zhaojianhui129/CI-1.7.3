<?php
/**
 * 导航类，头部导航管理类
 * @author jianhui
 *
 */
class Navbar{
    var $user = null;
    var $menuList = array();
    /**
     * 构造函数
     * @param array $user
     */
    function Navbar($user){
        $this->user = $user;
    }
    /**
     * 获取菜单列表
     */
    function getNavbarList(){
        if ($this->user['userRole'] == 1){
            $this->menuList = array(
                array('Main', 'storeTotal', 'title'=>'百县强击费用使用总控表'),
                array('SingleBudget', 'storeList', 'title'=>'百县强基预算申请'),
                array('SingleSettle', 'storeList', 'title'=>'百县强基结算申请'),
                array('SingleBudgetAgain', 'storeList', 'title'=>'百县强基结算申请', 'child' => array(
                    array('SingleBudgetAgain', 'storeList', 'title'=>'预算申请'),
                    array('SingleSettleAgain', 'storeList', 'title'=>'结算申请'),
                )),
            );
        }else{
            $this->menuList = array(
                array('main', 'adminTotal', 'title'=>'百县强击费用使用总控表'),
                array('SingleBudget', 'adminList', 'title'=>'百县强基预算管理'),
                array('SingleSettle', 'adminList', 'title'=>'百县强基结算管理'),
                array('Report', 'index', 'title'=>'报表管理'),
            );
            //督导和大区总监
            if (in_array($this->user['userRole'], array(2,3)) ){
                //补报
                $this->menuList[] = array('SingleBudgetAgain', 'adminList', 'title'=>'补报管理','child'=>array(
                    array('SingleBudgetAgain', 'adminList', 'title'=>'预算申请审核'),
                    array('SingleSettleAgain', 'adminList', 'title'=>'结算申请审核'),
                ));
            }
            //地区
            if (in_array($this->user['userRole'], array(6))){
                //补报
                $this->menuList[] = array('SingleBudgetAgain', 'adminList', 'title'=>'补报管理','child'=>array(
                    array('SingleBudgetAgain', 'adminList', 'title'=>'补报预算查看'),
                    array('SingleSettleAgain', 'adminList', 'title'=>'补报结算查看'),
                    'line',
                    array('AgainLimit', 'normalList', 'title'=>'补报开通'),
                ));
            }
            //总部
            if ($this->user['userRole'] == 5){
                $this->menuList[] = array('Import', 'index', 'title'=>'城市管理');
                //补报
                $this->menuList[] = array('SingleBudgetAgain', 'adminList', 'title'=>'补报管理','child'=>array(
                    array('SingleBudgetAgain', 'adminList', 'title'=>'补报预算查看'),
                    array('SingleSettleAgain', 'adminList', 'title'=>'补报结算查看'),
                    'line',
                    array('AgainLimit', 'normalList', 'title'=>'补报开通'),
                    array('AgainLimit', 'specialList', 'title'=>'特殊补报开通'),
                    array('AgainLimit', 'areaList', 'title'=>'区域补报列表'),
                    'line',
                    array('AgainLimit', 'auditList', 'title'=>'审核通道开通'),
                ));
            }
        }
        return $this->menuList;
    }
}