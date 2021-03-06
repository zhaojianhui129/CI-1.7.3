<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>文件上传</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <!-- 参考网址：http://www.holdcode.com/web/details/72 -->
    <!-- 先配置UEditor -->
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <!-- 加载jquery库 -->
    <script type="text/javascript" charset="utf-8" src="/public/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
    /*var editor = UE.getEditor('myEditor', {
        isShow:false,
        initialFrameWidth: 800,
        initialFrameHeight: 300,
    });*/
</script>
</head>
<body>
<a href="javascript:void(0);" id="upImages">上传多图</a>
<a href="javascript:void(0);" id="upScrawl">上传涂鸦</a>
<a href="javascript:void(0);" id="upFiles">上传文件</a>
<input name="picture" id="picture" value="">
<input name="file" id="file" value="">
<img id="preview" src="">
    <!-- 放置编辑器 -->
    <script type="text/plain" id="myEditor"></script>
</body>
<script type="text/javascript">
    $("body").append('<div id="upload_ue" style="display:none;"></div>');
    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
    var _editor = UE.getEditor('upload_ue',{
        serverUrl:'<?=DIRNAME?><?=printUrl('Upload','ueditor')?>',
        isShow:false,
        toolbars:[['simpleupload','scrawl','insertimage','attachment']],
    });
    _editor.ready(function () {
        //设置编辑器不可用
        //_editor.setDisabled();
        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
        //_editor.hide();
        //侦听图片上传
        _editor.addListener('beforeInsertImage', function (t, arg) {
            console.log(arg[0]);
            //将地址赋值给相应的input
            $("#picture").attr("value", arg[0].src);
            //图片预览
            $("#preview").attr("src", arg[0].src);
        })
        //侦听文件上传
        _editor.addListener('afterUpfile', function (t, arg) {
            console.log(arg[0]);
            $("#file").attr("value", arg[0].url);
        })
    });
    //弹出文件上传的对话框
    $("#upImages").click(function(){
        var myImage = _editor.getDialog("insertimage");
        myImage.open();
    });
    //涂鸦图片上传
    $("#upScrawl").click(function(){
        var myImage = _editor.getDialog("scrawl");
        myImage.open();
    });
    //弹出文件上传的对话框
    $("#upFiles").click(function(){
        var myFiles = _editor.getDialog("attachment");
        myFiles.open();
    });
</script>
</html>