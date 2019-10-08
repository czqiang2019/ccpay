<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/users/user-list.html";i:1568190413;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
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
<title>用户管理</title>
<style>
	.list_order{
		height: 24px!important;
		line-height: 24px!important;
		border: #FC6 solid 1px!important;
	}
</style>
</head>
<body>
<nav class="breadcrumb">
	<i class="Hui-iconfont">&#xe67f;</i>
	首页 <span class="c-gray en">&gt;</span>
	用户管理 <span class="c-gray en">&gt;</span>
	用户列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
	<i class="Hui-iconfont">&#xe68f;</i>
</a>
</nav>
<div class="page-container">
	<form action="<?php echo url('admin/users/index'); ?>" method="post">
		<div class="text-c">
			日期范围：
			<input type="text" id="logmin" name="logmin" class="input-text Wdate" style="width:120px;" readonly="">
			-
			<input type="text" id="logmax" name="logmax" class="input-text Wdate" style="width:120px;" readonly="">
			<input type="text" class="input-text" style="width:250px" placeholder="输入商户手机" id="keyword" name="keyword">
			<button type="button" class="btn btn-success radius" id="search" name="search"><i class="Hui-iconfont">&#xe665;</i> 搜商户</button>
		</div>
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l">
				<a href="javascript:;" onclick="loan_add('添加商户','<?php echo url("admin/users/addUser"); ?>','800','400')" class="btn btn-primary radius">
				<i class="Hui-iconfont">&#xe600;</i>
				添加商户</a>
				<button type="submit" class="btn btn-secondary radius" id="do" name="do"><i class="Hui-iconfont">&#xe644;</i>导出用户</button>
			</span>
		</div>
	</form>
	<div class="mt-20">
		<table class="layui-table" id="list" lay-filter="list"></table>
	</div>
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

<!--请在下方写此页面业务相关的脚本-->
<link href="/static/lib/layui/css/layui.css" rel="stylesheet">
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script type="text/html" id="open">
	<input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="open" {{ d.status == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="level">
	{{# if(d.level == 0){ }}
	<span class="layui-btn layui-btn-xs layui-btn-danger">{{d.level_name}}</span>
	{{# }else if(d.level==1){  }}
	<span class="layui-btn layui-btn-xs layui-btn-warm">{{d.level_name}}</span>
	{{# }else{  }}
	<span class="layui-btn layui-btn-xs layui-btn-normal">{{d.level_name}}</span>
	{{# } }}
</script>
<script type="text/html" id="action">
	<a href="javascript:;" onclick="product_edit('编辑','<?php echo url("admin/users/editUser"); ?>?id={{d.id}}','4','1000','510')" class="btn btn-primary size-MINI radius">编辑</a>
	<a class="btn btn-warning size-MINI radius" lay-event="del">删除</a>
</script>
<script>
	layui.use(['table','form','laydate'], function() {
		var table = layui.table,form = layui.form,$ = layui.jquery, laydate = layui.laydate;
		//日期范围
		laydate.render({
			elem: '#logmin'
			,type: 'date'
			,done: function(value, date, startDate){
			}
		});
		laydate.render({
			elem: '#logmax'
			,type: 'date'
			,done: function(value, date, endDate){
			}
		});
		var tableIn = table.render({
			id: 'user',
			elem: '#list',
			url: '<?php echo url("index"); ?>',
			method: 'post',
			toolbar: '#topBtn',
			cellMinWidth: 80,
			totalRow: true,
			page:true,
			cols: [[
				{field: 'id', title: '序号', width: 80, fixed: true},
				{field: 'mid', title: '商户号', align: 'center',width:140},
				{field: 'tel', title: '手机号', align: 'center',width:140},
				{field: 'level', title: '等级', align: 'center', toolbar: '#level'},
				{field: 'mout', title: '费率', align: 'center'},
				{field: 'money', title: '余额', align: 'center',totalRow: true},
				{field: 'add_time', title: '注册日期', align: 'center',width:160},
				{field: 'last_time', align: 'center',  title: '最后登陆时间',width:160},
				{field: 'exp_time', align: 'center',  title: '到期时间',width:120},
				{field: 'last_ip', title: '登陆IP', align: 'center'},
				{field: 'inviter', align: 'center',  title: '邀请人',width:80},
				{field: 'jkstate', align: 'center', width:100, title: '监控端',templet: function(d){
					if (d.jkstate=="-1"){
						return '<span class="layui-btn layui-btn-xs layui-btn-danger">未绑定</span>';
					}else if (d.jkstate=="1"){
						return '<span class="layui-btn layui-btn-xs layui-btn-normal">正常</span>';
					}else{
						return '<span class="layui-btn layui-btn-xs layui-btn-warm">已掉线</span>';
					}
				}},
				{field: 'status', align: 'center', width:100, title: '状态', toolbar: '#open'},
				{width: 180, title:'操作',align: 'center', toolbar: '#action'}
			]],
			limit:90
		});
		form.on('switch(open)', function(obj){
			loading =layer.load(1, {shade: [0.1,'#fff']});
			var id = this.value;
			var status = obj.elem.checked===true?0:1;
			$.post('<?php echo url("users/updateUserStatus"); ?>',{'id':id,'status':status},function (res) {
				layer.close(loading);
				if (res.status==1) {
					layer.msg(res.msg,{time:1000,icon:1});
					tableIn.reload();
				}else{
					layer.msg(res.msg,{time:1000,icon:2});
					return false;
				}
			})
		});
		//搜索
		$('#search').on('click', function () {
			var keyword = $('#keyword').val();
			var logmin = $('#logmin').val();
			var logmax = $('#logmax').val();

			tableIn.reload({ page: {page: 1}, where: {keyword: keyword,logmin:logmin,logmax:logmax}});
		});
		table.on('tool(list)', function(obj) {
			var data = obj.data;
			if (obj.event === 'del'){
				layer.confirm('您确定要删除该会员吗？', function(index){
					var loading = layer.load(1, {shade: [0.1, '#fff']});
					$.post("<?php echo url('users/delUser'); ?>",{id:data.id},function(res){
						layer.close(loading);
						if(res.status==1){
							layer.msg(res.msg,{time:1000,icon:1});
							tableIn.reload();
						}else{
							layer.msg('操作失败！',{time:1000,icon:2});
						}
					});
					layer.close(index);
				});
			}
		});
	})
	/*产品-添加*/
	function loan_add(title,url,w,h){
		layer_show(title,url,w,h);
	}
	/*产品-编辑*/
	function product_edit(title,url,id,w,h){
		layer_show(title,url,w,h);
	}
</script>
</body>
</html>