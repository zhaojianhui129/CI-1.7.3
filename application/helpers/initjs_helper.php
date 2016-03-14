<?php
/**
 * 提供按钮的ID列表，初始化上传按钮组件
 * @param array $buttonIds 多个按钮ID列表
 * @param string $uploadUrl 上传地址
 * @param string $fieldName 文件域名称
 */
function initUploadButtons($buttonIds = array(),$uploadUrl='',$fieldName = 'imgFile'){
    $data = array(
        'buttonIds' => $buttonIds,
        'uploadUrl' => $uploadUrl,
        'fieldName' => $fieldName
    );
    $loader = new CI_Loader();
    $content = $loader->view('common/initUploadButton',$data, true);
    echo $content;
}
/**
 * 提供按钮的ID列表，初始化插件组件
 * @param array $buttonIds
 * @param string $uploadUrl
 * @param string $secType 选择图片类型（local:本地上传，remote:远程图片，all:本地远程图片）
 * @param string $managerUrl 远程图片列表地址(远程图片列表json格式，具体格式参考模板文件)
 */
function initUploadImage($buttonIds = array(),$uploadUrl = '',$secType = 'local',$managerUrl = ''){
    $data = array(
        'buttonIds' => $buttonIds,
        'uploadUrl' => $uploadUrl,
        'secType' => $secType,
        'managerUrl' => $managerUrl
    );
    $loader = new CI_Loader();
    $content = $loader->view('common/initUploadImage',$data, true);
    echo $content;
}
/**
 * 初始化百度编辑器
 * @param string $boxId
 */
function initUeditor($container,$content=''){
    $data = array(
        'container' => $container,
        'content' => $content,
    );
    $loader = new CI_Loader();
    $content = $loader->view('common/initUeditor',$data, true);
    echo $content;
}
/**
 * 初始化百度图片上传控件
 * @param string $container
 */
function initUeditorImages($container){
    $data = array(
        'container' => $container,
    );
    $loader = new CI_Loader();
    $content = $loader->view('common/initUeditorImages',$data, true);
    echo $content;
}
/**
 * 初始化百度附件上传控件
 * @param string $container
 */
function initUeditorFiles($container){
    $data = array(
        'container' => $container,
    );
    $loader = new CI_Loader();
    $content = $loader->view('common/initUeditorFiles',$data, true);
    echo $content;
}