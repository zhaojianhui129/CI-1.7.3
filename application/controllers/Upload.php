<?php
/**
 * 文件上传
 * @author Administrator
 *
 */
class Upload extends MY_Controller{
    function Upload(){
        parent::MY_Controller();
        
    }
    /**
     * 文件上传保存
     */
    function uploadSave(){
        //验证用户登录状态
        $this->load->library('User', null, 'userLib');
        $this->user = $this->userLib->getUserInfo();
        if (! $this->user){
            $error = $this->userLib->error;
            exit(json_encode(array('error'=>1, 'message'=> $error)));
        }
        $extPath = date('Ymd');//子目录
        //file_name此参数不设置后缀才怪，中文文档又坑爹了
        //$config['file_name'] = (float)microtime(true)*10000 . '.jpg';
        $config['allowed_types'] = 'gif|jpg|png';
        $extArr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
            'settleFile' => array('zip', 'rar', 'gz', 'bz2'),//结算凭证文件类型
        );
        //上传类别
        $dir = $this->input->get('dir');
        if ($dir){
            if (isset($extArr[$dir])){
                $config['allowed_types'] = implode('|', $extArr[$dir]);
            }
        }else{
            $allowTypeArr = array_merge($extArr['image'], $extArr['file']);
            $config['allowed_types'] = implode('|', $allowTypeArr);
            $dir = 'file';
        }
        //上传目录
        $config['upload_path'] = '../upload/' . $extPath.'/';
        //网站目录
        $webPath = substr($config['upload_path'], 2);
        //判断上传目录是否存在，不存在则创建
        if (!is_dir($config['upload_path'])){
            mkdir($config['upload_path'],0777);
        }
        //图片上传限制长宽
        if ($dir == 'image'){
            $config['max_size'] = 5500000;
            /* $config['max_width']  = '1024';
            $config['max_height']  = '768'; */
        }
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('imgFile'))
        {
            $error = $this->upload->display_errors('','');
            exit(json_encode(array('error'=>1, 'message'=> $error)));
        } else {
            $data = $this->upload->data();
            $this->load->model('fileModel');
            $fileData = array(
                'fileName' => $data['file_name'],
                'fileType' => $data['file_type'],
                'fileSize' => $data['file_size'],
                'origName' => $data['orig_name'],
                'viewPath' => $webPath.$data['file_name'],
                'fullPath' => $data['full_path'],
                'userId' => $this->user['userId'],
                'createTime' => time(),
            );
            $fileId = $this->fileModel->add($fileData);
            exit(json_encode(array('error'=>0, 'fileId'=>$fileId, 'fileType'=>$dir, 'url'=> $webPath.$data['file_name'])));
        }
    }
    /**
     * 上传附件下载
     */
    function download(){
        $fileId = (int)$this->input->get('fileId');
        $fileId || showError('请选择要下载的附件ID');
        $this->load->model('fileModel');
        $fileData = $this->fileModel->getData($fileId);
        $fileData || showError('文件数据不存在');
        if (!file_exists($fileData['fullPath'])){
            showError('文件找不到');
        }
        // 输入文件标签
        Header("Content-type: ".$fileData['fileType']);
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: ". filesize($fileData['fullPath']));
        Header("Content-Disposition: attachment; filename=" . $fileData['fileName']);
        // 输出文件内容
        $file = fopen($fileData['fullPath'],"r"); // 打开文件
        echo fread($file, filesize($fileData['fullPath']));
        fclose($file);
        exit();
    }
    /**
     * 百度上传控制
     */
    function ueditor(){
        //验证用户登录状态
        $this->load->library('User', null, 'userLib');
        $this->user = $this->userLib->getUserInfo();
        /* if (! $this->user){
            $result = jsonEncode(array(
                'state'=> $this->userLib->error
            ));
        }else{ */
            $CONFIG = jsonDecode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(FCPATH . "/../public/ueditor/php/config.json")), true);
            $action = $_GET['action'];
            
            switch ($action) {
                case 'config':
                    $result =  jsonEncode($CONFIG);
                    break;
            
                /* 上传图片 */
                case 'uploadimage':
                /* 上传涂鸦 */
                case 'uploadscrawl':
                /* 上传视频 */
                case 'uploadvideo':
                /* 上传文件 */
                case 'uploadfile':
                    $uploadInfo = include(FCPATH . "/../public/ueditor/php/action_upload.php");
                    $resultArr = jsonDecode($uploadInfo);
                    $this->load->model('fileModel');
                    $fileData = array(
                        'dir'      => str_replace('upload', '', $action),
                        'fileName' => $resultArr['title'],
                        'fileType' => $resultArr['type'],
                        'fileSize' => $resultArr['size'],
                        'origName' => $resultArr['original'],
                        'viewPath' => $resultArr['url'],
                        'fullPath' => $resultArr['filePath'],
                        'userId' => (int)$this->user['userId'],
                        'createTime' => time(),
                    );
                    $fileId = $this->fileModel->add($fileData);
                    $resultArr['fileId'] = $fileId;
                    $result = jsonEncode($resultArr);
                    break;
            
                /* 列出图片 */
                case 'listimage':
                    //$result = include(FCPATH . "/../public/ueditor/php/action_list.php");
                    $this->load->model('fileModel');
                    $fileList = $this->fileModel->getList(array('userId'=>$this->user['userId'],'dir'=>'image'));
                    $result = array(
                        'state' => 'SUCCESS',
                        'start' => 0,
                        'total' => count($fileList),
                        'list' => array(),
                    );
                    foreach ($fileList as $v){
                        $result['list'][] = array(
                            'fileId' => (int)$v['id'],
                            'url' => $v['viewPath'],
                            'mtime' => (int)$v['createTime'],
                        );
                    }
                    $result = jsonEncode($result);
                    break;
                /* 列出文件 */
                case 'listfile':
                    //$result = include(FCPATH . "/../public/ueditor/php/action_list.php");
                    $this->load->model('fileModel');
                    $fileList = $this->fileModel->getList(array('userId'=>$this->user['userId'],'dir'=>'file'));
                    $result = array(
                        'state' => 'SUCCESS',
                        'start' => 0,
                        'total' => count($fileList),
                        'list' => array(),
                    );
                    foreach ($fileList as $v){
                        $result['list'][] = array(
                            'fileId' => (int)$v['id'],
                            'url' => $v['viewPath'],
                            'mtime' => (int)$v['createTime'],
                        );
                    }
                    $result = jsonEncode($result);
                    break;
            
                /* 抓取远程文件 */
                case 'catchimage':
                    $uploadInfo = include(FCPATH . "/../public/ueditor/php/action_crawler.php");
                    $resultArr = jsonDecode($uploadInfo);
                    $this->load->model('fileModel');
                    $fileData = array(
                        'dir'      => str_replace('upload', '', $action),
                        'fileName' => $resultArr['title'],
                        'fileType' => $resultArr['type'],
                        'fileSize' => $resultArr['size'],
                        'origName' => $resultArr['original'],
                        'viewPath' => $resultArr['url'],
                        'fullPath' => $resultArr['filePath'],
                        'userId' => (int)$this->user['userId'],
                        'createTime' => time(),
                    );
                    $fileId = $this->fileModel->add($fileData);
                    $resultArr['fileId'] = $fileId;
                    $result = jsonEncode($resultArr);
                    break;
            
                default:
                    $result = json_encode(array(
                        'state'=> '请求地址出错'
                    ));
                    break;
            }
        /* } */
        
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo jsonEncode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }
}