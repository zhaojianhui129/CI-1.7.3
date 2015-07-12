<?php if($buttonIds){ ?>
<script type="text/javascript">
	KindEditor.ready(function(K) {
		<?php foreach($buttonIds as $v){ ?>
		var uploadbutton_<?php echo $v?> = K.uploadbutton({
			button : K('#<?php echo $v?>')[0],
			fieldName : '<?php echo $fieldName;?>',
			url : '<?php echo $uploadUrl?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					if ($("#<?=$v?>ImgBox").length > 0) {
						var url = K.formatUrl(data.url, 'absolute');
						var html = '<a target="_blank" href="'+url+'" class="thumbnail"><img class="carousel-inner img-responsive img-rounded" src="'+url+'"></a>';
						$("#<?=$v?>ImgBox").html(html);
					};
					K('#<?=$v?>FileId').val(data.fileId);
					layer.msg('文件上传成功', {icon: 1,time: 500});
				} else {
					layer.msg(data.message, {icon:4,shift: 6,time: 1000});
				}
			},
			afterError : function(str) {
				layer.msg('自定义错误信息: ' + str, {shift: 6,time: 1000});
			}
		});
		uploadbutton_<?php echo $v;?>.fileBox.change(function(e) {
			uploadbutton_<?php echo $v;?>.submit();
		});
		<?php
		}
		?>
	});
</script>
<?php } ?>