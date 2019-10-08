<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/index/welcome.html";i:1570529062;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;}*/ ?>
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

<![endif]-->
<title>我的桌面</title>
</head>
<body>
<div class="page-container">
	<p class="f-20 text-success">欢迎使用CcPay多商户码支付系统 <span class="f-14">v1.1</span>免费开源版！</p>
	<p>登录次数：<?php echo $data['num']; ?> </p><p>登录IP：<?php echo $data['last_ip']; ?>  登录时间：<?php echo $data['last_login']; ?></p>
	<p>CcPay系统交流QQ群：281911918，若有疑问，bug请联系QQ：7435962</p>
	<p>系统基于ThinkPhp V5.0.24，码支付及APP监控部分采用V免签开源项目（在单人收款基础上进行开发，深度开发基于ThinkPhp），后台框架集成H-hui admin。</p>
</div>
<footer class="footer mt-20">
	<div class="container">
		<p>感谢V免签提供优质开源项目，感谢h-ui提供优质后台管理模板！<br>
			Copyright &copy;2015-2017 CcPay v1.1 All Rights Reserved.<br>
			本后台系统由<a href="http://www.netchu.cn/" target="_blank" title="CcPay">初创网络科技</a>提供技术支持</p>
	</div>
</footer>
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.min.js"></script> 
<!--此乃百度统计代码，请自行删除-->

<!--/此乃百度统计代码，请自行删除-->
</body>
</html>