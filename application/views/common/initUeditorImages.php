<script type="text/javascript">
    $("body").append('<div id="<?=$container?>Box" style="display:none;"></div>');
    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
    var <?=$container?>_editor = UE.getEditor('<?=$container?>Box',{
        serverUrl:'<?=DIRNAME?><?=printUrl('Upload','ueditor')?>',
        isShow:false,
        toolbars:[['insertimage']],
    });
    <?=$container?>_editor.ready(function () {
        //设置编辑器不可用
        //_editor.setDisabled();
        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
        //_editor.hide();
        //侦听图片上传
        <?=$container?>_editor.addListener('beforeInsertImage', function (t, arg) {
            console.log(arg[0]);
            //将地址赋值给相应的input
            $("#<?=$container?>picture").attr("value", arg[0].src);
            //图片预览
            $("#<?=$container?>preview").attr("src", arg[0].src);
        })
    });
    //弹出文件上传的对话框
    $("#<?=$container?>").click(function(){
        var myImage = <?=$container?>_editor.getDialog("insertimage");
        myImage.open();
    });
</script>