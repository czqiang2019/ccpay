<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/users/user-edit.html";i:1568129818;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/lib/html5shiv.js"></script>
<script type="text/javascript" src="/static/lib/respond.min.js"></script>

<!--1-图片上传的引入文件-->
<link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/bootstrap/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="/static/bootstrap/js/jquery-2.0.3.min.js"></script>
<script src="/static/bootstrap/js/fileinput.js" type="text/javascript"></script>
<script src="/static/bootstrap/js/fileinput_locale_de.js" type="text/javascript"></script>
<script src="/static/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<link href="/static/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/static/static/h-ui.admin/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>

<!--引入echarts 数据图-->
 <script src="/static/lib/echarts/echarts.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="/static/lib/DD_belatedPNG_0.0.8a-min.js" ></script>-->
<!--<script>DD_belatedPNG.fix('*');</script>-->

<![endif]-->
<!--/meta 作为公共模版分离出去-->
<style>
	.layui-form-radio{display: none;}
	.layui-input-4{width:60%;float: left;}
</style>
<title>编辑用户 - 初创网络</title>
</head>
<body>
<article class="page-container">
	<form class="layui-form layui-form-pane">
		<div class="layui-form-item">
			<label class="layui-form-label">商户号</label>
			<div class="layui-input-4">
				<input type="text" value="<?php echo $data['mid']; ?>" placeholder="请输入商户号" class="layui-input" disabled>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">手机号</label>
			<div class="layui-input-4">
				<input type="text" name="tel" value="<?php echo $data['tel']; ?>" lay-verify="phone" placeholder="请输入商户手机号" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">联系人</label>
			<div class="layui-input-4">
				<input type="text" name="real_name" value="<?php echo $data['real_name']; ?>" placeholder="请输入商户联系人" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">邮箱</label>
			<div class="layui-input-4">
				<input type="text" name="email" value="<?php echo $data['email']; ?>" lay-verify="email" placeholder="请输入商户邮箱" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">密码</label>
			<div class="layui-input-inline">
				<input type="text" name="password" value="" placeholder="不修改请留空" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">余额</label>
			<div class="layui-input-4">
				<input type="text" name="money" value="<?php echo $data['money']; ?>" placeholder="请输入余额" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">费率</label>
			<div class="layui-input-4">
				<input type="text" name="mout" value="<?php echo $data['mout']; ?>" placeholder="请输入商户费率" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">商户等级</label>
			<div class="layui-input-block">
				<input type="radio" name="level" value="0" <?php if(($data['level'] == 0)): ?>checked<?php endif; ?> title="免费版">
				<input type="radio" name="level" value="1" <?php if(($data['level'] == 1)): ?>checked<?php endif; ?> title="基础版">
				<input type="radio" name="level" value="2" <?php if(($data['level'] == 2)): ?>checked<?php endif; ?> title="标准版">
				<input type="radio" name="level" value="3" <?php if(($data['level'] == 3)): ?>checked<?php endif; ?> title="高级版">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">状态</label>
			<div class="layui-input-block">
				<input type="radio" name="status" value="0" <?php if(($data['status'] == 0)): ?>checked<?php endif; ?> title="启用">
				<input type="radio" name="status" value="1" <?php if(($data['status'] == 1)): ?>checked<?php endif; ?> title="禁用">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
			</div>
		</div>
	</form>
</article>
<!--图片上传-->
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<link href="/static/lib/layui/css/layui.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
	var ue = UE.getEditor('editor');
	layui.use(['form', 'layer','colorpicker'], function () {
		var form = layui.form, layer = layui.layer,$= layui.jquery,colorpicker = layui.colorpicker;
		form.on('submit(submit)', function (data) {
			loading =layer.load(1, {shade: [0.1,'#fff']});
			$.post("", data.field, function (res) {
				layer.close(loading);
				if (res.status > 0) {
					layer.msg(res.msg, {time: 1800, icon: 1}, function () {
						var index = parent.layer.getFrameIndex(window.name);
						window.parent.location.reload();
						parent.layer.close(index);
					});
				} else {
					layer.msg(res.msg, {time: 1800, icon: 2});
				}
			});
		});
		colorpicker.render({
			elem: '#test-form'
			,color: '#1c97f5'
			,done: function(color){
				$('#test-form-input').val(color);
			}
		});
		//RGB 、RGBA
		colorpicker.render({
			elem: '#test3'
			,color: 'rgb(68,66,66)'
			,format: 'rgb' //默认为 hex
		});
		colorpicker.render({
			elem: '#test4'
			,color: 'rgba(68,66,66,0.5)'
			,format: 'rgb'
			,alpha: true //开启透明度滑块
		});
	});
</script>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->
</body>
</html>