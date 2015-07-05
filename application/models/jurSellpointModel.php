<?php
/**
 * 权限数据模型
 * @author Administrator
 *
 */
class jurSellpointModel extends MY_Model{
    function jurSellpointModel(){
        parent::MY_Model();
        $this->table = 'jurisdiction_sellpoint';
    }
    /**
     * 覆盖父类方法
     * @see MY_Model::getData()
     */
    function getData($where = '', $colum =''){
        //更改数据库链接配置
        $this->db = $this->load->database('auth', true);
        $findData = parent::getData($where, $colum);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        return $findData;
    }
    /**
     * 覆盖父类方法(non-PHPdoc)
     * @see MY_Model::getList()
     */
    function getList($where = '', $limit = NULL, $offset = NULL, $colum = '', $orderby = ''){
        //更改数据库链接配置
        $this->db = $this->load->database('auth', true);
        $findList = parent::getList($where, $limit, $offset, $colum, $orderby);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        return $findList;
    }
}