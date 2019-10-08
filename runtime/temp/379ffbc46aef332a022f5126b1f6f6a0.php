<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:43:"../template/default/qrcode/qrcode-list.html";i:1568085720;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1568086704;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1568085444;}*/ ?>
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

<body class="layui-anim layui-anim-up">
<div class="x-nav">
      <span class="layui-breadcrumb">

        <a>
          <cite><?php echo $title; ?></cite></a>
      </span>
    <a class="layui-btn layui-btn-primary layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>
<div class="x-body">
    <!--div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
            <input class="layui-input" placeholder="开始日" name="start" id="start">
            <input class="layui-input" placeholder="截止日" name="end" id="end">
            <input type="text" id="keyword" name="keyword"  placeholder="请输入固定金额" autocomplete="off" class="layui-input">
            <button class="layui-btn sreach"><i class="layui-icon">&#xe615;</i></button>
        </div>
    </div-->
    <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','<?php echo url('/qrcodes/addQrcode/' . $type); ?>',600,500)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $count; ?> 条</span>
    </xblock>
    <table class="layui-table" id="list" lay-filter="list">

    </table>
</div>
<link rel="stylesheet" href="/static/lib/layui/css/layui.css">
<link rel="stylesheet" href="/static/lib/layui/css/layui.mobile.css">
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script type="text/html" id="qrcode">
   <img src="{{d.qrcode}}" height="40" lay-event="qrcode">
</script>
<script type="text/html" id="action">
    <a href="javascript:;" onclick="x_admin_show('编辑','<?php echo url("qrcode/editQrcode"); ?>?id={{d.id}}',600,500)" class="layui-btn layui-btn-xs layui-btn-normal">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script>
    layui.use(['table','form','laydate'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery, laydate = layui.laydate;
        laydate.render({
            elem: '#start' //指定元素
        });
        laydate.render({
            elem: '#end' //指定元素
        });
        var tableIn = table.render({
            id: 'agent',
            elem: '#list',
            url: '<?php echo url("/qrcode"); ?>',
            method: 'post',
            where:{type:"<?php echo $type; ?>"},
            cellMinWidth: 80,
            totalRow: true,
            page:true,
            cols: [[
                {field: 'id', title: 'ID', width: 80, fixed: true},
                {field: 'pay_url', title: '收款码', width:200, align: 'center', toolbar: '#qrcode'},
                {field: 'record', title: '今日收款', align: 'center', totalRow: true},
                {field: 'price', align: 'center',  title: '固定金额'},
                {field: 'remark', align: 'center',  title: '备注'},
                {field: 'add_time', align: 'center', width:160, title: '添加时间'},
                {field: 'status', align: 'center', width:100, title: '状态',templet: function(d){
                    if (d.status=="1"){
                        return '<span class="layui-btn layui-btn-xs layui-btn-danger">禁用</span>';
                    }else{
                        return '<span class="layui-btn layui-btn-xs layui-btn-normal">启用</span>';
                    }
                }},
                {width: 160, align: 'center', toolbar: '#action'},
            ]],
            limit:10
        });
        $('.search').on('click', function () {
            var keyword = $('#keyword').val();
            var logmin = $('#start').val();
            var logmax = $('#end').val();

            tableIn.reload({ page: {page: 1}, where: {keyword: keyword,logmin:logmin,logmax:logmax,type:<?php echo $type; ?>}});
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'qrcode'){
                layer.open({
                    offset: 'auto',
                    title:'查看收款码',
                    content: '<img src="' + data.qrcode + '" width="300">',
                })
            }else if(obj.event === 'del'){
                layer.confirm('您确定要删除该收款码吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('qrcode/delQrcode'); ?>",{id:data.id},function(res){
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
    });

    /*用户-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){

            if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
            }

        });
    }

    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }



    function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
    }
</script>
</body>

</html>