<script type="text/javascript">
    var _<?=$container?> = UE.getEditor('<?=$container?>',{
        serverUrl:'<?=DIRNAME?><?=printUrl('Upload','ueditor')?>',
        'initialContent':'<?=htmlspecialchars($content)?>',
    });
</script>