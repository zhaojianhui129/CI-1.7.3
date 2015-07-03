<?php
/**
 * 权限数据模型
 * @author Administrator
 *
 */
class jurSellpointModel extends MY_Model{
    function jurSellpointModel(){
        parent::MY_Model();
        $this->db = $this->load->database('NTSDF', true);
        $this->table = 'js_jurisdiction_sellpoint';
    }
    /**
     * 获取用户角色ID
     * @param int $userId 用户ID
     * @param int $systemId 系统ID
     * @return boolean|int
     */
    function getUserRole($userId,$systemId){
        $userRole = false;
        $findData = $this->getData(array('SellPointID'=>$userId, 'application_system_id'=>$systemId));
        return $userRole;
    }
}