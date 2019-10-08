<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"../template/default/order/order-test.html";i:1567998495;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1568086704;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1568085444;}*/ ?>
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
<body style="margin:20px;">
<article class="page-container">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">商户号：</label>
            <div class="layui-input-4">
                <input type="text" name="mid" value="<?php echo $user['mid']; ?>" class="layui-input" disabled>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商户订单号：</label>
            <div class="layui-input-4">
                <input type="text" name="payId" placeholder="测试订单号" value="<?php echo $payId; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">价格：</label>
            <div class="layui-input-inline">
                <input type="text" name="price" value="0.1" placeholder="请输入测试付款金额" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">单日收款限额，超过将会轮询其他收款码！</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">自定义参数：</label>
            <div class="layui-input-inline">
                <input type="text" name="param" placeholder="请输入自定义参数" value="ccpay" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付方式：</label>
            <div class="layui-input-block">
                <input type="radio" name="type" value="1" checked title="微信">
                <input type="radio" name="type" value="2" title="支付宝">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交测试</button>
            </div>
        </div>
    </form>
</article>
<!--图片上传-->
<link rel="stylesheet" href="/static/lib/layui/css/layui.css">
<link rel="stylesheet" href="/static/lib/layui/css/layui.mobile.css">
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
    layui.use(['form', 'layer'], function () {
        var form = layui.form, layer = layui.layer,$= layui.jquery;
        form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1500, icon: 1}, function () {
                        window.open(res.data);
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    });
                } else {
                    layer.msg('网络错误', {time: 1500, icon: 2});
                }
            });
        });
    });
</script>
<!--_footer 作为公共模版分离出去-->

<!--/_footer 作为公共模版分离出去-->
</body>
</html>