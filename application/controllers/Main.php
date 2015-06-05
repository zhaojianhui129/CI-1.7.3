<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class main extends MY_Controller{
    function main(){
        parent::MY_Controller();
    }
    function index(){
        //echo $this->input->server('HTTP_REFERER');
        $this->load->view("Main/index");
    }
    function ajax(){
        $this->success("错误");
    }
}