<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/admin/admin-list.html";i:1568129818;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
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
<title>管理员列表</title>
</head>
<body>
<nav class="breadcrumb">
	<i class="Hui-iconfont">&#xe67f;</i>
	首页 <span class="c-gray en">&gt;</span>
	管理员管理 <span class="c-gray en">&gt;</span>
	管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
	<i class="Hui-iconfont">&#xe68f;</i>
		</a>
</nav>
<div class="page-container">
	<form action="<?php echo url('admin/admin/index'); ?>" method="post">
		<div class="text-c">
			日期范围：
			<input type="text" onfocus="WdatePicker()" id="logmin" name="logmin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker()" id="logmax" name="logmax" class="input-text Wdate" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="keyword">
			<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
			<i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
			<a href="javascript:;" onclick="admin_add('添加管理员','<?php echo url("admin/admin/addAdmin"); ?>','800','500')" class="btn btn-primary radius">
				<i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
		</span>
		<span class="r">共有数据：<strong><?php echo $num; ?></strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="11">员工列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="150">登录名</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th>角色</th>
				<th width="130">加入时间</th>
				<th width="130">最后登录的时间</th>
				<th width="130">登录时的Ip</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?>
			<tr class="text-c">
				<td><input type="checkbox" value="1" name=""></td>
				<td><?php echo $admin['id']; ?></td>
				<td><?php echo $admin['names']; ?></td>
				<td><?php echo $admin['phone']; ?></td>
				<td><?php echo $admin['email']; ?></td>
				<td><?php echo $admin['role_name']; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$admin['add_time']); ?></td>
				<td><?php echo $admin['last_login']; ?></td>
				<td><?php echo $admin['last_ip']; ?></td>
				<?php if($admin['status'] == 1): ?>
				<td class="td-status"><span class="label label-success radius">已启用</span></td>
				<?php else: ?>
				<td class="td-status"><span class="label label-default radius">已禁用</span></td>
				<?php endif; ?>
				<td class="td-manage">
					<?php if($admin['status'] == 1): ?>
						<a style="text-decoration:none" onClick="admin_stop(this,'<?php echo $admin['id']; ?>')" href="javascript:;" title="停用">
							<i class="Hui-iconfont">&#xe631;</i>
						</a>
					<?php else: ?>
						<a style="text-decoration:none" onClick="admin_start(this,'<?php echo $admin['id']; ?>')" href="javascript:;" title="启用">
							<i class="Hui-iconfont">&#xe615;</i>
						</a>
					<?php endif; ?>
					<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','<?php echo url("admin/admin/editAdmin",array("id"=>$admin['id'])); ?>','1','800','500')" class="ml-5" style="text-decoration:none">
						<i class="Hui-iconfont">&#xe6df;</i>
					</a>
					<a title="删除" href="javascript:;" onclick="admin_del(this,'<?php echo $admin['id']; ?>')" class="ml-5" style="text-decoration:none">
						<i class="Hui-iconfont">&#xe6e2;</i>
					</a>
				</td>
			</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>

		</tbody>
	</table>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.js"></script>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/static/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/static/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.post(
            "<?php echo url('admin/admin/delAdmin'); ?>",
            {id:id},
            function(data){
                var data = JSON.parse(data);
                if(data.status==1){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    var msg = data.msg;
                    layer.msg(msg,{icon:2,time:2000});
                }
            });
    });
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
            var status = 2;
            //此处请求后台程序，下方是成功后的前台处理……
            $.post(
                '<?php echo url("admin/admin/updateAdminStatus"); ?>',
                {id:id,status:status},
                function(data){
                    var data = JSON.parse(data);
                    if(data.status == 1){
                        $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                        $(obj).remove();
                        layer.msg('已停用!',{icon: 5,time:1000});

                    }else{
                        var msg = data.msg;
                        layer.msg(msg,{icon:2,time:2000});
                    }
                });
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
        var status = 1;
        //此处请求后台程序，下方是成功后的前台处理……
        $.post(
            '<?php echo url("admin/admin/updateAdminStatus"); ?>',
            {id:id,status:status},
            function(data){
                var data = JSON.parse(data);
                if(data.status == 1){
                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!', {icon: 6,time:1000});
                }else{
                    var msg = data.msg;
                    layer.msg(msg,{icon:2,time:2000});
                }
            });
	});
}
</script>
</body>
</html>