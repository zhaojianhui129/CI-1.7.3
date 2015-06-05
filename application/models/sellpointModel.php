<?php
/**
 * 用户模型
 * @author Administrator
 *
 */
class sellpointModel extends MY_Model{
    /**
     * 构造函数
     */
    function sellpointModel(){
        parent::MY_Model();
        $this->table='dflpvmkt.pvSellPoint';
    }
    /**
     * 查找指定专营店信息
     * @param int $id
     * @return array
     */
    function getData($where){
        $this->db->query("set names latin1");
        $this->db->select('Area_2015 area,Region_2015 region,SpSArea_2015 spsarea,Province province,County city,SellPointID userId,SellPointName storeName,Coding code,Email email,Account userName');
        $query = $this->db->get_where($this->table,$where);
        $findData = $query->row_array();
        $this->db->query("set names utf8");
        return $findData;
    }
    /**
     * 获取专营店列表
     * @param array $where
     * @return array
     */
    function getList($where){
        $this->db->query("set names latin1");
        $this->db->select('Area_2015 area,Region_2015 region,SpSArea_2015 spsarea,Province province,County city,SellPointID userId,SellPointName storeName,Coding code,Email email,Account userName');
        $query = $this->db->get_where($this->table,$where);
        $findList = $query->result_array();
        $this->db->query("set names utf8");
        $list = array();
        foreach ($findList as $v){
            $list[(int)$v['SellPointID']] = $v;
        }
        return $list;
    }
}