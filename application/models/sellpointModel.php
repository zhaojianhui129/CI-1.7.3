<?php
/**
 * 用户模型
 * @author Administrator
 *
 */
class sellpointModel extends MY_Model{
    var $colum = '';
    /**
     * 构造函数
     */
    function sellpointModel(){
        parent::MY_Model();
        $this->table='pvSellPoint';
        $this->colum = 'Area_2015 area,Region_2015 region,SpSArea_2015 spsarea,Province province,County city,SellPointID userId,SellPointName storeName,Coding coding,Email email,Account userName,Password password';
    }
    /**
     * 查找指定专营店信息
     * @param int $id
     * @return array
     */
    function getNewData($where){
        //更改数据库链接配置
        $this->db = $this->load->database('dflpvmkt', true);
        $findData   = parent::getData($where, $this->colum);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        return $this->gbkToUtf8($findData);
    }
    /**
     * 获取专营店列表
     * @param array $where
     * @return array
     */
    function getNewList($where){
        //更改数据库链接配置
        $this->db = $this->load->database('dflpvmkt', true);
        $findList = parent::getList($where, NULL, NULL, $this->colum);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        $list = array();
        foreach ($findList as $v){
            $list[(int)$v['userId']] = $this->gbkToUtf8($v);
        }
        return $list;
    }
    /**
     * 转换编码
     * @param array $storeData
     * @return multitype:string
     */
    function gbkToUtf8($storeData){
        $data = array();
        foreach ($storeData as $k => $v){
            $data[$k] = gbk2utf8($v);
        }
        return $data;
    }
    /**
     * 根据专营店ID获取专营店数据
     * @param int $storeId
     * @return array
     */
    function getStoreIdData($storeId){
        return $this->getNewData(array('SellPointID'=>$storeId, 'SpState_sys'=>1));
    }
}