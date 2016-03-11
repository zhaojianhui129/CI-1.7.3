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
    
}