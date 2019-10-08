<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/epay.3ii.cn/public/../application/admin/view/orders/pay-list.html";i:1568129818;s:65:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/blank.html";i:1568129819;s:66:"/www/wwwroot/epay.3ii.cn/application/admin/view/common/footer.html";i:1568129819;}*/ ?>
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
<title><?php echo $title; ?></title>
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
    <?php echo $title; ?>列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
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
			<a href="javascript:;" onclick="deloffall()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;
</i> 批量删除所有未支付订单</a>
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
<script type="text/html" id="action">
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
            url: '<?php echo url("pay"); ?>',
            method: 'post',
            where:{type:<?php echo $type; ?>},
            cellMinWidth: 80,
            totalRow: true,
            page:true,
            cols: [[
                {field: 'id', title: 'ID', width: 80, fixed: true},
                {field: 'mid', title: '商户ID', width:100 , align: 'center'},
                {field: 'sn', title: '订单号', width:200, align: 'center'},
                {field: 'mode', title: '支付方式', width:100 , align: 'center',templet: function(d){
                    if (d.type=="2"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-normal">支付宝</span>';
                    }else if (d.type=="1"){
                        return '<span class="btn btn-success size-MINI radius">微信</span>';
                    }else{
                        return '<span class="layui-btn layui-btn-xs layui-btn-warm">QQ</span>';
                    }
                }},
                {field: 'money', align: 'center', title: '订单金额', totalRow: true},
                {field: 'level', align: 'center', title: '升级等级'},
                {field: 'day', align: 'center', title: '升级天数'},
                {field: 'ctime', align: 'center', width:200, title: '创建时间'},
                {field: 'ptime', align: 'center', width:200, title: '支付时间'},
                {field: 'state', align: 'center', width:120, title: '状态',templet: function(d){
                        if (d.status=="2"){
                            return '<span class="layui-btn layui-btn-xs layui-btn-danger">超时支付</span>';
                        }else if (d.status=="0"){
                            return '<span class="layui-btn layui-btn-xs layui-btn-normal">订单完成</span>';
                        }else{
                            return '<span class="layui-btn layui-btn-xs">待支付</span>';
                        }
                    }},
                {field: 'remark', align: 'center', width:200, title: '备注'},
                {width: 80, align: 'center', toolbar: '#action'}
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
                var type = 'pay';
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
            }
        });
    })
    function deloffall() {
        layer.confirm('您确定要删除所有未支付订单吗？', function(index){
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('admin/system/del'); ?>",{type:'pay',mode:'all',where:'status',status:2},function(res){
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