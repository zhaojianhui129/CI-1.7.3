/**
 * 公用js文件
 */

/**
 * 异步表单提交
 * @param {String} formId 表单ID
 * @param {String} postUrl 提交地址
 * @param {Object} postData
 */
function ajaxFormSubmit(formId) {
		$("#" + formId).ajaxSubmit(function(data) {
			if (data.statusCode == 1) {
				layer.msg(data.message, {
					icon: 1,
					time: 1000
				}, function() {
					if (data.data.jumpUrl) {
						window.location.href = data.data.jumpUrl;
					}
				});
			} else if (data.statusCode == 2) {
				layer.msg(data.message, {
					shift: 6,
					time: 1000
				});
			} else if (data.statusCode == 3) {
				layer.msg(data.message, {
					time: 2000
				}, function() {
					if (data.data.jumpUrl) {
						window.location.href = data.data.jumpUrl;
					}
				});
			}
		});
	}
	/**
	 * 询问窗口异步请求
	 * @param {String} postUrl 请求地址
	 * @param {Object} postData 提交参数，可以使用$("form").serialize()将表单数据传递过来
	 */

function ajaxConfirmSubmit(title, postUrl, postData) {
	var argPostData = arguments[2] ? arguments[2] : {};
	layer.confirm(title, {
		icon: 3
	}, function(index) {
		$.post(postUrl, argPostData, function(data) {
			if (data.statusCode == 1) {
				layer.msg(data.message, {
					icon: 1,
					time: 1000
				}, function() {
					if (data.data.jumpUrl) {
						window.location.href = data.data.jumpUrl;
					}
				});
			} else if (data.statusCode == 2) {
				layer.msg(data.message, {
					shift: 6,
					time: 1000
				});
			} else if (data.statusCode == 3) {
				layer.msg(data.message, {
					time: 2000
				}, function() {
					if (data.data.jumpUrl) {
						window.location.href = data.data.jumpUrl;
					}
				});
			}
		}, 'json');
	});
}

/**
 * 打开新窗口
 * @param {String} title 标题
 * @param {String} url 链接地址
 * @param {Number} width 宽度
 * @param {Number} height 高度
 */
function newWindow(title, url, width, height) {
	var argWidth = arguments[2] ? arguments[2] : 800;
	var argHeight = arguments[3] ? arguments[3] : 600;
	layer.open({
		type: 2,
		title: title,
		maxmin: true, //开启最大化最小化按钮
		area: [argWidth + 'px', argHeight + 'px'],
		content: url,
		end: function() {
			window.location.reload();
		}
	});
}