<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:34:"../template/default/user/info.html";i:1568106303;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1568086704;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1568085444;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?> - <?php echo get_sys('site_name'); ?></title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="/static/admin/css/font.css">
	<link rel="stylesheet" href="/static/admin/css/xadmin.css">
	<link rel="stylesheet" href="/static/admin/css/public.css">
</head>
<body class="form-wrap" >

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">用户信息
        </div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" lay-filter="form-setting">
                <div class="layui-form-item">
                    <label class="layui-form-label">商户ID：</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input" value="<?php echo $user['mid']; ?>" disabled>
                    </div>
                    <div class="layui-form-mid layui-word-aux">当前商户等级：<?php echo get_level_name($user['level']); if(($user['level'] == 0)): ?>，<span style="color:red">当前等级每日限收10笔！</span><?php endif; ?>！</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号：</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" lay-verify="phone" class="layui-input" value="<?php echo $user['tel']; ?>" disabled>
                    </div>
                    <div class="layui-form-mid layui-word-aux">暂不支持修改手机！</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱：</label>
                    <div class="layui-input-4">
                        <input type="text" name="email" autocomplete="off" lay-verify="email" placeholder="请输入您的E-mail" value="<?php echo $user['email']; ?>" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">输入邮箱号我们将推送手机监控端离线提醒！</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="real_name" lay-verify="required" autocomplete="off" placeholder="请输入您的姓名" value="<?php echo $user['real_name']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/static/lib/layui/css/layui.css">
<link rel="stylesheet" href="/static/lib/layui/css/layui.mobile.css">
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
    layui.use(['form', 'layer','element'], function () {
        var form = layui.form,layer = layui.layer,$ = layui.jquery;
        //提交监听
        form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        window.location.reload();
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });
    })
</script>

<style id="LAY_layadmin_theme">.layui-side-menu,.layadmin-pagetabs .layui-tab-title li:after,.layadmin-pagetabs .layui-tab-title li.layui-this:after,.layui-layer-admin .layui-layer-title,.layadmin-side-shrink .layui-side-menu .layui-nav>.layui-nav-item>.layui-nav-child{background-color:#20222A !important;}.layui-nav-tree .layui-this,.layui-nav-tree .layui-this>a,.layui-nav-tree .layui-nav-child dd.layui-this,.layui-nav-tree .layui-nav-child dd.layui-this a{background-color:#009688 !important;}.layui-layout-admin .layui-logo{background-color:#20222A !important;}</style>
</body>


</html>