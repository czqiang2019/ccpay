<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:35:"../template/default/user/index.html";i:1568106267;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1568086704;s:58:"/www/wwwroot/epay.3ii.cn/template/default/common/menu.html";i:1568006260;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1568085444;}*/ ?>
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
<body>
<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="<?php echo get_sys('site_url'); ?>"><?php echo get_sys('site_name'); ?></a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onClick="x_admin_show('添加微信收款码','<?php echo url('/qrcodes/addQrcode/1'); ?>',600,450)"><i class="iconfont">&#xe6a2;</i>微信收款码</a></dd>
                <dd><a onClick="x_admin_show('添加支付宝收款码','<?php echo url('/qrcodes/addQrcode/2'); ?>',600,450)"><i class="iconfont">&#xe6a8;</i>支付宝收款码</a></dd>
                <dd><a onClick="x_admin_show('支付测试','<?php echo url('/order/test'); ?>',600,400)"><i class="iconfont">&#xe6b8;</i>支付测试</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item"><a onClick="x_admin_show('商户充值','<?php echo url('pay/recharge?types=1'); ?>',600,450)">余额：¥<?php echo $user['money']; ?> 充值</a></li>
        <li class="layui-nav-item"><a onClick="x_admin_show('升级/续费套餐','<?php echo url('pay/recharge?types=2'); ?>',600,450)"><span style="color:#fff"><?php echo $user['exp_time']==null?"" : get_level_name($user['level']) . "到期时间：" . date('Y-m-d',$user['exp_time']); ?></span></a></li>
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $user['tel']; ?>（<?php echo get_level_name($user['level']); ?>）</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onClick="x_admin_show('升级/续费套餐','<?php echo url('pay/recharge?types=2'); ?>',600,450)">升级/续费套餐</a></dd>
                <dd><a onClick="x_admin_show('个人信息','<?php echo url('/user/info'); ?>',600,650)">个人信息</a></dd>
                <dd><a href="<?php echo url('/login'); ?>">切换帐号</a></dd>
                <dd><a href="<?php echo url('logout'); ?>">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="<?php echo get_sys('site_url'); ?>">前台首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
	<div id="side-nav">
		<ul id="nav">
			<li >
				<a href="javascript:;">
					<i class="iconfont">&#xe6eb;</i>
					<cite>商户设置</cite>
					<i class="iconfont nav_right">&#xe6a7;</i>
				</a>
				<ul class="sub-menu">
					<li><a _href="<?php echo url('/user/setting'); ?>"><i class="iconfont">&#xe6a7;</i><cite>商户配置</cite></a></li>
					<li><a _href="<?php echo url('mobile'); ?>"><i class="iconfont">&#xe6a7;</i><cite>监控端</cite></a></li>
					<li><a _href="javescript:;" onClick="x_admin_show('支付测试','<?php echo url('/order/test'); ?>',600,400)"><i class="iconfont">&#xe6a7;</i><cite>支付测试</cite></a></li>
				</ul>
			</li>



			<li>
				<a href="javascript:;"><i class="iconfont">&#xe6f6;</i><cite>收款二维码</cite><i class="iconfont nav_right">&#xe6a7;</i></a>
				<ul class="sub-menu">
					<li><a _href="<?php echo url('/qrcode?type=1'); ?>"><i class="iconfont">&#xe6a7;</i><cite>微信</cite></a></li>
					<li><a _href="<?php echo url('/qrcode?type=2'); ?>"><i class="iconfont">&#xe6a7;</i><cite>支付宝</cite></a></li>
				</ul>
			</li>

			<li>
				<a href="javascript:;">
					<i class="iconfont">&#xe69e;</i>
					<cite>订单管理</cite>
					<i class="iconfont nav_right">&#xe6a7;</i>
				</a>
				<ul class="sub-menu">
					<li>
						<a _href="<?php echo url('/order'); ?>">
							<i class="iconfont">&#xe6a7;</i>
							<cite>订单列表</cite>
						</a>
					</li >
				</ul>
			</li>
			<li>
				<a href="javascript:;">
					<i class="iconfont">&#xe726;</i>
					<cite>账号管理</cite>
					<i class="iconfont nav_right">&#xe6a7;</i>
				</a>
				<ul class="sub-menu">
					<li>
						<a _href="<?php echo url('/user/info'); ?>">
							<i class="iconfont">&#xe6a7;</i>
							<cite>基本资料</cite>
						</a>
					</li >
					<li>
						<a _href="<?php echo url('/user/pwd'); ?>">
							<i class="iconfont">&#xe6a7;</i>
							<cite>密码修改</cite>
						</a>
					</li >
				</ul>
			</li>

			<!--li>
				<a href="javascript:;">
					<i class="iconfont">&#xe6ae;</i>
					<cite>系统统计</cite>
					<i class="iconfont nav_right">&#xe6a7;</i>
				</a>
				<ul class="sub-menu">
					<li>
						<a _href="html/echarts1.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>拆线图</cite>
						</a>
					</li >
					<li>
						<a _href="html/echarts2.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>柱状图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts3.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>地图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts4.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>饼图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts5.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>雷达图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts6.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>k线图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts7.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>热力图</cite>
						</a>
					</li>
					<li>
						<a _href="html/echarts8.html">
							<i class="iconfont">&#xe6a7;</i>
							<cite>仪表图</cite>
						</a>
					</li>
				</ul>
			</li-->
			<li >
				<a href="javascript:;">
					<i class="iconfont">&#xe6b4;</i>
					<cite>帮助中心</cite>
					<i class="iconfont nav_right">&#xe6a7;</i>
				</a>
				<ul class="sub-menu">
					<li><a _href="html/grid.html"><i class="iconfont">&#xe6a7;</i><cite>文档中心</cite></a></li>
					<li><a _href="<?php echo url('api'); ?>"><i class="iconfont">&#xe6a7;</i><cite>API说明</cite></a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src="<?php echo url('main'); ?>" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<link rel="stylesheet" href="/static/lib/layui/css/layui.css">
<link rel="stylesheet" href="/static/lib/layui/css/layui.mobile.css">
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<!--<div class="footer">
    <div class="copyright">Copyright ©2019 L-admin v2.3 All Rights Reserved</div>
</div>-->
<!-- 底部结束 -->
</body>
</html>