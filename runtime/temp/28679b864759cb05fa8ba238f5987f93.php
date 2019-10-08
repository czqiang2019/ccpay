<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:43:"../template/default/qrcode/qrcodes-add.html";i:1568012998;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_header.html";i:1567840979;s:66:"/www/wwwroot/epay.3ii.cn/template/default/common/admin_footer.html";i:1567849217;}*/ ?>
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
            <label class="layui-form-label">上传二维码</label>
            <input type="hidden" name="pay_url" id="image">
            <input type="hidden" name="qrcode" id="qrcode">
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="logoBtn"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="logoImage" width="100px">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">固定金额：</label>
            <div class="layui-input-4">
                <input type="text" name="price" placeholder="若生成固定金额请输入金额，若无请留空！" class="layui-input">
            </div>
        </div>
        <!--div class="layui-form-item">
            <label class="layui-form-label">单日限次：</label>
            <div class="layui-input-inline">
                <input type="text" name="max_num" placeholder="不限制请留空" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">限额，限次二选一输入！</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单日限额：</label>
            <div class="layui-input-inline">
                <input type="text" name="max_money" placeholder="不限制请留空" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">单日收款限额，超过将会轮询其他收款码！</div>
        </div-->
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="0" checked title="正常">
                <input type="radio" name="status" value="1" title="禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注：</label>
            <div class="layui-input-inline">
                <input type="text" name="remark" placeholder="请输入备注" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">添加</button>
            </div>
        </div>
    </form>
</article>
<!--图片上传-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<link rel="stylesheet" href="/static/lib/layui/css/layui.css">
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<script>
    layui.use(['form', 'layer','upload'], function () {
        var form = layui.form, layer = layui.layer,$= layui.jquery,upload = layui.upload;
        var uploadInst = upload.render({
            elem: '#logoBtn',
            url: '<?php echo url('Upfile/upload'); ?>'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    loading =layer.load(1, {shade: [0.1,'#fff']});
                    $('#logoImage').attr('src', result);
                });
            },
            done: function(res){
                layer.close(loading);
                if(res.code>0){
                    $('#image').val(res.data);
                    $('#qrcode').val(res.qrcode);
                    layer.msg('上传成功！',{icon:1,time:1000});
                }else{
                    //如果上传失败
                    return layer.msg('上传失败');
                }
            },
            error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
        form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1500, icon: 1}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.location.reload();
                        parent.layer.close(index);
                    });
                } else {
                    layer.msg(res.msg, {time: 1500, icon: 2});
                }
            });
        });
    });
</script>
<!--_footer 作为公共模版分离出去-->

<!--/_footer 作为公共模版分离出去-->
</body>
</html>