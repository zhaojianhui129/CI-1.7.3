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
        $this->db = $this->load->database('dflpvmkt', true);
        $this->table='pvSellPoint';
        $this->colum = 'Area_2015 area,Region_2015 region,SpSArea_2015 spsarea,Province province,County city,SellPointID userId,SellPointName storeName,Coding code,Email email,Account userName';
    }
    /**
     * 查找指定专营店信息
     * @param int $id
     * @return array
     */
    function getData($where){
        $findData   = parent::getData($where, $this->colum);
        return $this->gbkToUtf8($findData);
    }
    /**
     * 获取专营店列表
     * @param array $where
     * @return array
     */
    function getList($where){
        $findList = parent::getList($where, NULL, NULL, $this->colum);
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
}