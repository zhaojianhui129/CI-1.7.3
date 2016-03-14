<script>
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			uploadJson : '<?php echo $uploadUrl;?>',
			fileManagerJson : '<?php echo $managerUrl;?>',
		});
		<?php foreach($buttonIds as $v){ ?>
		K('#<?php echo $v;?>Button').click(function() {
			editor.loadPlugin('multiimage', function() {
				editor.plugin.multiImageDialog({
					clickFn : function(urlList) {
						var div = K('#<?php echo $v;?>Box');
						//div.html('');
						K.each(urlList, function(i, data) {
							var html = '';
							var url = K.formatUrl(data.url, 'absolute');
							html += '<li>'+"\n";
							html += '<input type="hidden" name="voucher[]" id="voucher'+i+'" value="'+data.fileId+'">'+"\n";
							html += '<a target="_blank" href="'+url+'" class="thumbnail" style="widht:200px; float:left;"><img class="carousel-inner img-responsive img-rounded" src="'+url+'"></a>'+"\n";
							html += '<a class="voucherDelete" style="float:right;" href="javascript:;">删除</a><li>'+"\n";
							div.append(K.formatHtml(html));
						});
						editor.hideDialog();
					}
				});
			});
		});
		<?php }?>
	});
	$("body").on('click',".voucherDelete",function(e){
	  $(this).parent('li').remove();
	});
</script>