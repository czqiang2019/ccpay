<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:36:"../template/default/user/mobile.html";i:1568044914;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1568086704;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1568085444;}*/ ?>
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
        <div class="layui-card-header">商户配置
        </div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" lay-filter="form-setting">
                <div class="layui-form-item">
                    <label class="layui-form-label">监控端状态</label>
                    <div class="layui-input-4">
                        <input type="text" autocomplete="off" class="layui-input" value="<?php if(($user['jkstate'] == -1)): ?>监控端未绑定，请您扫码绑定<?php elseif(($user['jkstate'] == 0)): ?>监控端已掉线，请您检查App是否正常运行<?php else: ?>监控端运行正常<?php endif; ?>" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">最后心跳</label>
                    <div class="layui-input-4">
                        <input type="text" placeholder="最后心跳时间" value="<?php echo date('Y-m-d H:i:s',$user['lastheart']); ?>" class="layui-input" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">最后收款</label>
                    <div class="layui-input-4">
                        <input type="text" placeholder="最后收款时间" value="<?php echo date('Y-m-d H:i:s',$user['lastpay']); ?>" class="layui-input" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">配置数据</label>
                    <div class="layui-input-4">
                        <input type="text" value="<?php echo get_sys('site_api'); ?>/<?php echo $user['mid']; ?>/<?php echo $user['apikey']; ?>" autocomplete="off" class="layui-input" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">配置二维码</label>
                    <div class="layui-input-4">
                        <img src="http://<?php echo get_sys('site_api'); ?>/enQrcode?url=<?php echo get_sys('site_api'); ?>/<?php echo $user['mid']; ?>/<?php echo $user['apikey']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            <button class="layui-btn" onclick="window.open('<?php echo get_sys('site_app'); ?>')">下载监控端</button>
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

<style id="LAY_layadmin_theme">.layui-side-menu,.layadmin-pagetabs .layui-tab-title li:after,.layadmin-pagetabs .layui-tab-title li.layui-this:after,.layui-layer-admin .layui-layer-title,.layadmin-side-shrink .layui-side-menu .layui-nav>.layui-nav-item>.layui-nav-child{background-color:#20222A !important;}.layui-nav-tree .layui-this,.layui-nav-tree .layui-this>a,.layui-nav-tree .layui-nav-child dd.layui-this,.layui-nav-tree .layui-nav-child dd.layui-this a{background-color:#009688 !important;}.layui-layout-admin .layui-logo{background-color:#20222A !important;}</style>
</body>


</html>