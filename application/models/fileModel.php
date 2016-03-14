<?php
/**
 * 文件模型
 * @author jianhui
 *
 */
class fileModel extends MY_Model{
    function fileModel(){
        parent::MY_Model();
        $this->table = 'File';
    }
    /**
     * 通过文件路径查询图片数据
     * @param string $url 图片访问路径
     * @return array
     */
    function getFileDataByViewPath($url){
        $fileData = $this->getData(array('viewPath'=>$url));
        return $fileData;
    }
    /**
     * 通过文件路径列表查询文件数据集
     * @param array $urls
     * @return array
     */
    function getFileDataByViewPaths($urls = array()){
        $findList = $this->getData(array('viewPath'=>array('in',$urls)));
        $list = array();
        foreach ((array)$findList as $v){
            $list[$v['viewPath']] = $v;
        }
        return $list;
    }
}