<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/admin/admin-edit.html";i:1540627322;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1540627322;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1540627322;}*/ ?>
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
<title>添加管理员 - 管理员管理 - H-ui.admin v3.1</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
		<!--隐藏域 id-->
		<input type="hidden" name="id" id="id" value="<?php echo $data['id']; ?>">
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="<?php echo $data['names']; ?>" placeholder="" id="adminName" name="adminName">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off" value="<?php echo $data['password']; ?>" placeholder="密码" id="password" name="password">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off"  value="<?php echo $data['password']; ?>" placeholder="确认新密码" id="password2" name="password2">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否启用：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="status" type="radio" id="sex-1" value="1" <?php if($data['status'] == 1): ?>checked<?php endif; ?>>
				<label for="sex-1">是</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" name="status" value="2" <?php if($data['status'] == 2): ?>checked<?php endif; ?>>
				<label for="sex-2">否</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="<?php echo $data['phone']; ?>" placeholder="" id="phone" name="phone">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="@" name="email" id="email" value="<?php echo $data['email']; ?>">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="adminRole" id="adminRole" size="1">
				<?php if(is_array($admins) || $admins instanceof \think\Collection || $admins instanceof \think\Paginator): $i = 0; $__LIST__ = $admins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo $admin['role_id']; ?>" <?php if($admin['role_id'] == $data['role_id']): ?>selected<?php endif; ?>><?php echo $admin['role_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			</span> </div>
	</div>
	<!--<div class="row cl">-->
		<!--<label class="form-label col-xs-4 col-sm-3">备注：</label>-->
		<!--<div class="formControls col-xs-8 col-sm-9">-->
			<!--<textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>-->
			<!--<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>-->
		<!--</div>-->
	<!--</div>-->
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" onclick="check()" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--_footer 作为公共模版分离出去--> 

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	$("#form-admin-add").validate({
		rules:{
			adminName:{
				required:true,
				minlength:4,
				maxlength:16
			},
			password:{
				required:true,
			},
			password2:{
				required:true,
				equalTo: "#password"
			},
			sex:{
				required:true,
			},
			phone:{
				required:true,
				isPhone:true,
			},
			email:{
				required:true,
				email:true,
			},
			adminRole:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
//			$(form).ajaxSubmit({
//				type: 'post',
//				url: "<?php echo url('admin/admin/addAdmin'); ?>" ,
//				success: function(data){
//					layer.msg('添加成功!',{icon:1,time:1000});
//				},
//                error: function(XmlHttpRequest, textStatus, errorThrown){
//					layer.msg('error!',{icon:1,time:1000});
//				}
//			});
//			var index = parent.layer.getFrameIndex(window.name);
//			parent.$('.btn-refresh').click();
//			parent.layer.close(index);
		}
	});
});
function check() {
    var names = $.trim($('#adminName').val());
    var email = $.trim($('#email').val());
    var phone = $.trim($('#phone').val());
    var password = $.trim($('#password').val());
    var status = $('input[name=status]:checked').val();
    var role_id = $('#adminRole').val();
    if(names=="" || email=="" || phone=="" || password==""){
        layer.msg('请填写信息',{icon:2,time:2000});
        return false;
	}
	var id=$("#id").val();
    console.log(id);
	$.post(
	    "<?php echo url('admin/admin/editAdmin'); ?>",
        {names:names,email:email,phone:phone,password:password,status:status,role_id:role_id,id:id},
		function (dat) {
			var data=JSON.parse(dat);
			var msgs=data.msg;
            if(data.status == 1){
                layer.msg(msgs, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.$('.btn-primary').click();
                    window.parent.location.reload();
                    parent.layer.close(index);
                });
            }else{
                layer.msg(msgs,{icon:2,time:2000});
            }
        });

}
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>