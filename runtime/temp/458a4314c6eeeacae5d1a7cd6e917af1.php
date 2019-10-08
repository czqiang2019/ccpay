<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:36:"../template/default/login/login.html";i:1567999219;s:60:"/www/wwwroot/epay.3ii.cn/template/default/common/header.html";i:1567758822;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow, archive">
    <meta name="author" content="<?php echo get_sys('site_author'); ?>">
    <title><?php echo $title; ?> - <?php echo get_sys('site_title'); ?></title>
    <meta name="description" content="<?php echo get_sys('site_description'); ?>">
    <meta name="keywords" content="<?php echo get_sys('site_keywords'); ?>">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="/static/home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/home/css/creative.css" rel="stylesheet">
    <link href="/static/home/css/main.css" rel="stylesheet">
    <link href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet">
    <meta property="og:title" content="<?php echo get_sys('site_name'); ?>">
    <meta property="og:description" content="<?php echo get_sys('site_desc'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo get_sys('site_url'); ?>">
    <meta property="og:image" content="<?php echo get_sys('site_logo'); ?>">
</head>
<body>
<div class="login-body" onkeydown="on_return();">
    <div class="login">
        <h3><a href="<?php echo get_sys('site_url'); ?>"><?php echo get_sys('site_name'); ?></a></h3>
        <div class="m-cell">
            <div class="cell-item">
                <div class="cell-left Hui-iconfont Hui-iconfont-user"></div>
                <div class="cell-right"><input type="number" id="tel" pattern="[0-9]*" class="cell-input" placeholder="请输入手机号" autocomplete="off" /></div>
            </div>
            <div class="cell-item email" style="display: none">
                <div class="cell-left Hui-iconfont Hui-iconfont-email"></div>
                <div class="cell-right"><input type="text" id="email" class="cell-input" placeholder="请输入邮箱号，将推送监控状态" autocomplete="off" /></div>
            </div>
            <div class="cell-item">
                <div class="cell-left Hui-iconfont Hui-iconfont-suoding"></div>
                <div class="cell-right"><input type="password" id="password" class="cell-input" placeholder="请输入密码" autocomplete="off" /></div>
            </div>
            <div class="cell-item" style="margin-top:.3rem;">
                <div class="left">
                    <label class="cell-item">
                        <label class="cell-right checkbox">
                            <input type="checkbox" name="reg" value="login"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <span class="cell-left regs">我要注册</span>
                </div>
                <div class="right">
                    <span class="cell-left">记住密码</span>
                    <label class="cell-item">
                        <label class="cell-right checkbox" style="float: left;">
                            <input type="checkbox" name="rempass"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>

                </div>
            </div>
            <p style="display: none;"><a href="<?php echo url('/login/service'); ?>">注册既表示接受《<?php echo get_sys('site_engname'); ?>用户注册协议》</a></p>
            <button type="button" class="login-btn success" onclick="login()">登陆</button>
            <button type="button" id="getpwd" onclick="javascript:window.location.href='<?php echo url('/login/forpwd'); ?>'">忘记密码</button>
        </div>
    </div>
</div>
<script src="/static/home/js/jquery.min.js"></script>
<link href="/static/ydui/css/ydui.css" rel="stylesheet">
<script src="/static/ydui/js/ydui.js"></script>
<script src="/static/ydui/js/ydui.flexible.js"></script>
<script>
    $("input[name='reg']").click(function(){
        if($("input[name='reg']:checked").length>0){
            $(this).attr('value','reg');
            $('.login-btn').removeClass('success');
            $('.login-btn').addClass('primary');
            $('.regs').addClass('p-primary');
            $('.login-btn').html('注册');
            $('.login p').show();
            $('.email').show();
        }else{
            $(this).attr('value','login');
            $('.login-btn').addClass('success');
            $('.login-btn').removeClass('primary');
            $('.regs').removeClass('p-primary');
            $('.login-btn').html('登陆');
            $('.login p').hide();
            $('.email').hide();
        }
    })
    function login() {
        var tel = $('#tel').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var type = $('input[name="reg"]').val();
        if(tel == '' || password == ''){
            YDUI.dialog.toast('请输入账号或密码！','error',1000);
            return false;
        }
        $.post("",{tel:tel,password:password,type:type,email:email},function (res) {
            if(res.code == 0){
                YDUI.dialog.toast(res.msg,'success',1000,function () {
                    location.href = "<?php echo url('/user'); ?>";
                })
            }else{
                YDUI.dialog.toast(res.msg,'error',1000);
            }
        })
    }
    //回车时，默认是登陆
    function on_return(){
        if(window.event.keyCode == 13){
            if ($('#sub')!=null) {
                login();
            }
        }
    }
</script>
</body>
</html>