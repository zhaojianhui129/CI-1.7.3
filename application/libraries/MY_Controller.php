<?php
/**
 * 自动提示基类控制器，新建控制器继承此控制器
 * @author Administrator
 *
 */
class MY_Controller extends Controller
{
    /**
     * @var CI_Loader
     */
    var $load ;
    /**
     * @var CI_DB_active_record
     */
    var $db ;
    /**
     * @var CI_Calendar
     */
    var $calendar ;
    /**
     * @var Email
     */
    var $email ;
    /**
     * @var CI_Encrypt
     */
    var $encrypt ;
    /**
     * @var CI_Ftp
     */
    var $ftp ;
    /**
     * @var CI_Hooks
     */
    var $hooks ;
    /**
     * @var CI_Image_lib
     */
    var $image_lib ;
    /**
     * @var CI_Language
     */
    var $language ;
    /**
     * @var CI_Log
     */
    var $log ;
    /**
     * @var CI_Output
     */
    var $output ;
    /**
     * @var CI_Input
     */
    var $input ;
    /**
     * @var CI_Pagination
     */
    var $pagination ;
    /**
     * @var CI_Parser
     */
    var $parser ;
    /**
     * @var CI_Session
     */
    var $session ;
    /**
     * @var CI_Sha1
     */
    var $sha1 ;
    /**
     * @var CI_Table
     */
    var $table ;
    /**
     * @var CI_Trackback
     */
    var $trackback ;
    /**
     * @var CI_Unit_test
     */
    var $unit ;
    /**
     * @var CI_Upload
     */
    var $upload ;
    /**
     * @var CI_URI
     */
    var $uri ;
    /**
     * @var CI_User_agent
     */
    var $agent ;
    /**
     * @var CI_Validation
     */
    var $validation ;
    /**
     * @var CI_Xmlrpc
     */
    var $xmlrpc ;
    /**
     * @var CI_Zip
     */
    var $zip ;
    /**
     * @var CI_Form
     */
    var $form_validation ;
    
    //菜单列表
    var $navbarList = null;
    //当前选中菜单
    var $navbarFocus = '';
    //用户信息
    var $user = NULL;
    //传给视图的数据
    var $viewData = array();

    function MY_Controller()
    {
        parent::Controller();
        /* $this->load->library('User', null, 'userLib');
        $this->user = $this->userLib->getUserInfo();
        if (! $this->user){
            showError($this->userLib->error, '/');
        }
        //加载菜单，全局使用
        $this->load->library('Navbar', $this->user);
        $this->navbarList = $this->navbar->getNavbarList();
        //当前选中菜单默认为当前控制器
        $this->navbarFocus = $this->input->get('c');
        //加载认证类，全局可以调用
        $this->load->library('Auth', $this->user); */
        //面包屑导航
        $this->viewData['breadcrumb'][] = array('url'=>printUrl('Main', 'index'),'title'=>'首页');
    }
}