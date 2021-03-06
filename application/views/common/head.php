<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>新系统<?php echo $this->viewData['title'] ? '-'.$this->viewData['title'] : '';?></title>

    <!-- Bootstrap -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/userDefined.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/public/js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/public/js/bootstrap.min.js"></script>
    <!--jquery表单插件-->
    <script src="/public/js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
    <!--jqBootstrapValidation-->
    <script src="/public/js/jqBootstrapValidation-1.3.7.js"></script>
    <!--弹层控件，还有其他很多功能-->
    <script src="/public/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        layer.config({
            skin:'layer-ext-moon',
            extend:'skin/moon/style.css'
        });
    </script>
    <!--日期控件-->
    <script src="/public/My97DatePicker/WdatePicker.js" type="text/javascript" charset="utf-8"></script>
    <!--kindeditor编辑器，里面包含一些有用的组件-->
    <link rel="stylesheet" type="text/css" href="/public/kindeditor/themes/default/default.css"/>
    <script src="/public/kindeditor/kindeditor-all-min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/kindeditor/lang/zh_CN.js" type="text/javascript" charset="utf-8"></script>
    <!-- 先配置UEditor -->
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <!--公用js方法-->
    <script src="/public/js/common.js" type="text/javascript" charset="utf-8"></script>
    <!--自定义公用js方法-->
    <script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
    .navbar .nav > li .dropdown-menu {
        margin: 0;
    }
    .navbar .nav > li:hover .dropdown-menu {
        display: block;
    }
    </style>
  </head>
  <body>
  <div class="container">