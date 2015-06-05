<script type="text/javascript">
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			uploadJson : '<?php echo $uploadUrl;?>',
			fileManagerJson : '<?php echo $managerUrl;?>',
		});
		<?php foreach($buttonIds as $v){ ?>
		K('#<?php echo $v;?>').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					<?php
					if($secType == 'local'){//本地上传
						echo 'showRemote : false,';
					}elseif($secType == 'remote'){//远程上传
						echo 'showLocal : false,';
					}else{
						
					}
					?>
					imageUrl : K('#<?php echo $v;?>Value').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#<?php echo $v;?>Value').val(url);
						//K('#<?php echo $v;?>Thumb').src(url);
						editor.hideDialog();
					}
				});
			});
		});
		<?php
		}
		?>
	});
</script>