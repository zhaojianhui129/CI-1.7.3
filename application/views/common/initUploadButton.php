<script type="text/javascript">
	KindEditor.ready(function(K) {
		<?php foreach($buttonIds as $v){ ?>
		var uploadbutton_<?php echo $v?> = K.uploadbutton({
			button : K('#<?php echo $v?>')[0],
			fieldName : '<?php echo $fieldName;?>',
			url : '<?php echo $uploadUrl?>',
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = K.formatUrl(data.url, 'absolute');
					K('#<?php echo $v;?>Url').val(url);
				} else {
					layer.msg(data.message, {shift: 6,time: 1000});
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