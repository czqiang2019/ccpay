<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/system/system-base.html";i:1568129820;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
﻿﻿<!DOCTYPE HTML>
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

<!--/meta 作为公共模版分离出去-->
<style>
	.layui-form-pane .layui-form-label{width: 150px !important;}
	.layui-input-4{width:60%;float: left;}
	.layui-input-3{width:45%;float: left;}
	.layui-upload-list{margin:10px 40px!important;}
	.tabBar{margin-bottom: 20px;}
</style>
<title>基本设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>
	系统管理
	<span class="c-gray en">&gt;</span>
	基本设置
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
		<i class="Hui-iconfont">&#xe68f;</i>
	</a>
</nav>
<div class="page-container">
	<form class="layui-form layui-form-pane" lay-filter="form-config">
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
				<span>基本设置</span>
				<span>商户设置</span>
				<span>邮件设置</span>
				<span>收款设置</span>
			</div>
			<div class="tabCon">
				<div class="layui-form-item">
					<label class="layui-form-label">网站名称</label>
					<div class="layui-input-4">
						<input type="text" name="site_name" value="" lay-verify="required" placeholder="请输入网站名称" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">英文简称</label>
					<div class="layui-input-4">
						<input type="text" name="site_engname" value="" placeholder="请输入网站英文简称" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">网站标题</label>
					<div class="layui-input-3">
						<input type="text" name="site_title" value="" placeholder="请输入网站标题" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">网站域名</label>
					<div class="layui-input-3">
						<input type="text" name="site_url" value="" lay-verify="required" placeholder="请输入网站域名" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">API域名</label>
					<div class="layui-input-3">
						<input type="text" name="site_api" value="" placeholder="请输入API接口域名" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">监控端下载</label>
					<div class="layui-input-3">
						<input type="text" name="site_app" value="" placeholder="请输入手机监控端下载链接" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">备案号</label>
					<div class="layui-input-3">
						<input type="text" name="site_icp" value="" placeholder="请输入网站备案号" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">客服微信</label>
					<div class="layui-input-3">
						<input type="text" name="site_wechat" value="" placeholder="请输入客服微信号" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">客服QQ</label>
					<div class="layui-input-3">
						<input type="text" name="site_qq" value="" placeholder="请输入客服QQ号" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">客服邮箱</label>
					<div class="layui-input-3">
						<input type="text" name="site_mail" value="" placeholder="请输入客服邮箱" class="layui-input">
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="layui-form-item">
					<label class="layui-form-label">商户初始MID</label>
					<div class="layui-input-3">
						<input type="text" name="site_mid" value="" placeholder="请输入注册商户初始费率（免费版）" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">商户初始费率(%)</label>
					<div class="layui-input-3">
						<input type="text" name="user_level_mout" value="" placeholder="请输入商户初始MID,设置好切勿随意更改！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">基础版费率(%)</label>
					<div class="layui-input-3">
						<input type="text" name="user_level1_mout" value="" placeholder="请输入基础版商户费率！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">标准版费率(%)</label>
					<div class="layui-input-3">
						<input type="text" name="user_level2_mout" value="" placeholder="请输入标准版商户费率！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">高级版费率(%)</label>
					<div class="layui-input-3">
						<input type="text" name="user_level3_mout" value="" placeholder="请输入高级版商户费率！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">基础版价格</label>
					<div class="layui-input-3">
						<input type="text" name="user_level1_price" value="" placeholder="请输入基础版商户套餐价格！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">标准版价格</label>
					<div class="layui-input-3">
						<input type="text" name="user_level2_price" value="" placeholder="请输入标准版商户套餐价格！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">高级版价格</label>
					<div class="layui-input-3">
						<input type="text" name="user_level3_price" value="" placeholder="请输入高级版商户套餐价格！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">商户注册赠送金</label>
					<div class="layui-input-3">
						<input type="text" name="reg_give_money" value="" placeholder="请输入商户注册赠送测试体验金！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">商户注册版本</label>
					<div class="layui-input-3">
						<input type="text" name="reg_give_level" value="" placeholder="请输入商户注册赠送体验版本0免费1基础2标准3高级！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">版本体验天数</label>
					<div class="layui-input-3">
						<input type="text" name="reg_give_day" value="" placeholder="请输入商户注册赠送测试体验版本！" class="layui-input">
					</div>
				</div>

			</div>
			<div class="tabCon">
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱1 SMTP</label>
					<div class="layui-input-3">
						<input type="text" name="email_smtp1" value="" placeholder="请输入系统提醒邮箱1SMTP服务器地址！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱1端口</label>
					<div class="layui-input-3">
						<input type="text" name="email_port1" value="" placeholder="请输入系统提醒邮箱1SMTP端口！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱1账号</label>
					<div class="layui-input-3">
						<input type="text" name="email_user1" value="" placeholder="请输入系统提醒邮箱1账号！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱1密码</label>
					<div class="layui-input-3">
						<input type="text" name="email_password1" value="" placeholder="请输入系统提醒邮箱1密码！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱2 SMTP</label>
					<div class="layui-input-3">
						<input type="text" name="email_smtp2" value="" placeholder="请输入系统提醒邮箱2SMTP服务器地址！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱2端口</label>
					<div class="layui-input-3">
						<input type="text" name="email_port2" value="" placeholder="请输入系统提醒邮箱2SMTP端口！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱2账号</label>
					<div class="layui-input-3">
						<input type="text" name="email_user2" value="" placeholder="请输入系统提醒邮箱2账号！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱2密码</label>
					<div class="layui-input-3">
						<input type="text" name="email_password2" value="" placeholder="请输入系统提醒邮箱2密码！" class="layui-input">
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="layui-form-item">
					<label class="layui-form-label">平台收款模式</label>
					<div class="layui-input-3">
						<input type="radio" name="pay_mode" value="0" <?php if(($info['pay_mode'] == 0)): ?>checked<?php endif; ?> title="全部">
						<input type="radio" name="pay_mode" value="1" <?php if(($info['pay_mode'] == 1)): ?>checked<?php endif; ?> title="平台收款接口">
						<input type="radio" name="pay_mode" value="2" <?php if(($info['pay_mode'] == 2)): ?>checked<?php endif; ?> title="官方接口">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">收款商户ID</label>
					<div class="layui-input-3">
						<input type="text" name="pay_qrcode_mid" value="" placeholder="请输入系统收款使用平台商户MID！" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">平台接口收款</label>
					<div class="layui-input-3">
						<input type="radio" name="pay_qrcode_mode" value="0" <?php if(($info['pay_qrcode_mode'] == 0)): ?>checked<?php endif; ?> title="全部">
						<input type="radio" name="pay_qrcode_mode" value="1" <?php if(($info['pay_qrcode_mode'] == 1)): ?>checked<?php endif; ?> title="微信">
						<input type="radio" name="pay_qrcode_mode" value="2" <?php if(($info['pay_qrcode_mode'] == 2)): ?>checked<?php endif; ?> title="支付宝">
					</div>
				</div>
			</div>
			<div class="tabCon">

			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="button" class="btn btn-primary radius" lay-submit="" lay-filter="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->
<link href="/static/lib/layui/css/layui.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
	layui.use(['form', 'layer','upload','element'], function () {
		var form = layui.form,layer = layui.layer,upload = layui.upload,$ = layui.jquery,element = layui.element;
		var config = <?php echo $config; ?>;

		form.val("form-config", config);
		form.on('submit(submit)', function (data) {
			loading =layer.load(1, {shade: [0.1,'#fff']});
			$.post("", data.field, function (res) {
				layer.close(loading);
				if (res.code > 0) {
					layer.msg(res.msg, {time: 1800, icon: 1}, function () {
						var index = parent.layer.getFrameIndex(window.name);
						parent.$('.btn-primary').click();
						window.location.reload();
					});
				} else {
					layer.msg(res.msg, {time: 1800, icon: 2});
				}
			});
		});
	});
</script>
<!--请在下方写此页面业务相关的脚本-->

<script type="text/javascript">
	$(function(){
		$('.skin-minimal input').iCheck({
			checkboxClass: 'icheckbox-blue',
			radioClass: 'iradio-blue',
			increaseArea: '20%'
		});
		$("#tab-system").Huitab({
			index:0
		});
	});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
