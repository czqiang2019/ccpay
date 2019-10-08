<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/orders/order-list.html";i:1568131454;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
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
<title>商户订单管理</title>
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
    订单管理 <span class="c-gray en">&gt;</span>
    商户订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
    <i class="Hui-iconfont">&#xe68f;</i>
</a>
</nav>
<div class="page-container">
    <div class="text-c">
        日期范围：
        <input type="text" id="logmin" name="logmin" class="input-text Wdate" style="width:120px;" readonly="">
        -
        <input type="text" id="logmax" name="logmax" class="input-text Wdate" style="width:120px;" readonly="">
        <input type="text" class="input-text" style="width:250px" placeholder="输入商户ID，订单号" id="keyword" name="keyword">
        <button type="button" class="btn btn-success radius" id="search" name="search"><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="deloffall(30)" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe6e2;
        </i> 删除30天前超时订单</a>
            <a href="javascript:;" onclick="deloffall('all')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;
        </i> 删除所有超时订单</a>
        </span>
    </div>
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
<script type="text/html" id="is_top">
    <input type="checkbox" name="is_top" value="{{d.id}}" lay-skin="switch" lay-text="顶置|默认" lay-filter="is_top" {{ d.is_top == 0 ? 'checked' : '' }}> |
    <input type="checkbox" name="is_today" value="{{d.id}}" lay-skin="switch" lay-text="推荐|默认" lay-filter="is_today" {{ d.is_today == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="info">详情</a>
    <a href="javascript:;" onclick="product_edit('编辑','<?php echo url("admin/products/editProduct"); ?>?id={{d.id}}','4','1000','510')" class="btn btn-primary size-MINI radius">编辑</a>
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
            id: 'product',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            cellMinWidth: 80,
            totalRow: true,
            page:true,
            cols: [[
                {field: 'id', title: 'ID', width: 80, fixed: true},
                {field: 'mid', title: '商户ID', width:100 , align: 'center'},
                {field: 'order_id', title: '云端订单号', width:200, align: 'center'},
                {field: 'pay_id', title: '商户订单号', align: 'center'},
                {field: 'type', title: '支付方式', width:100 , align: 'center',templet: function(d){
                    if (d.type=="2"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-normal">支付宝</span>';
                    }else if (d.type=="1"){
                        return '<span class="btn btn-success size-MINI radius">微信</span>';
                    }else{
                        return '<span class="layui-btn layui-btn-xs layui-btn-warm">QQ</span>';
                    }
                }},
                {field: 'price', align: 'center',  width:100 ,title: '订单金额', totalRow: true},
                {field: 'really_price', align: 'center',  width:120 ,title: '实际支付金额', totalRow: true},
                {field: 'create_date', align: 'center', width:200, title: '创建时间'},
                {field: 'state', align: 'center', width:120, title: '状态',templet: function(d){
                    if (d.state=="2"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="bd">通知失败</span>';
                    }else if (d.state=="1"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-normal">订单完成</span>';
                    }else if (d.state=="0"){
                        return '<span class="layui-btn layui-btn-xs">待支付</span>';
                    }else if (d.state=="-1"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-warm">过期订单</span>';
                    }
                }},
                {width: 160, align: 'center', toolbar: '#action'}
            ]],
            limit:90
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
                var type = 'pay_order';
                layer.confirm('您确定要删除该订单吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('admin/system/del'); ?>",{id:data.id,type:type},function(res){
                        layer.close(loading);
                        if(res.code>0){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }else if (obj.event === 'info'){
                var out = "<p>创建时间："+data.create_date+"</p>";
                out += "<p>支付时间："+data.pay_date+"</p>";
                out += "<p>关闭时间："+data.close_date+"</p>";
                out += "<p>自定义参数："+data.param+"</p>";
                layer.open({
                    offset: 'auto',
                    title:'订单详情',
                    content: out,
                })
            }else if(obj.event === 'bd'){
                layer.confirm('确定要补单吗？该操作将会将该订单标记为已支付，并向您的服务器发送订单完成通知', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('admin/system/update'); ?>",{id:data.id,type:'bd'},function(res){
                        layer.close(loading);
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else if(res.code==-2){
                            layer.confirm('补单失败，异步通知返回错误，是否查看通知返回数据？', {
                                btn: ['查看','取消'] //按钮
                            }, function(){
                                alert(res.data);
                            }, function(){

                            });
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
    })
    function deloffall(mode) {
        layer.confirm('您确定要删除所有已超时订单吗？', function(index){
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('admin/system/del'); ?>",{type:'pay_order',mode:mode,where:'state',status:-1},function(res){
                layer.close(loading);
                if(res.code>0){
                    layer.msg(res.msg,{time:1000,icon:1});
                    location.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            });
            layer.close(index);
        });
    }
</script>
</body>
</html>