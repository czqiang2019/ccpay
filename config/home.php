<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
$admin_login_path = get_sys('admin_login_path');
if ($admin_login_path == '') {
    $admin_login_path = 'admin';
}
$route_config = [
    '/'=>'home/index/index',
    '/user'=>'home/user/index',
    '/user/setting'=>'home/user/setting',
    '/user/info'=>'home/user/info',
    '/user/pwd'=>'home/user/pwd',

    '/login'=>'home/login/login',
    '/login/forpwd'=>'home/login/forpwd',

    '/qrcode'=>'home/qrcode/index',
    '/qrcodes/addqrcode/:type'=>'home/qrcode/addQrcode',

    '/order'=>'home/order/index',
    '/order/test'=>'home/order/test',
    '/getOrder'=>'pay/service/getOrder',
    '/checkOrder'=>'pay/service/checkOrder',

    
];

if ($admin_login_path != 'admin') {
    $admin_route_config = [
        //后台
        'admin/$' => 'admin/index/index',
        'admin/login$' => 'admin/index/index',
        'admin/login/index' => 'admin/index/index',
        $admin_login_path . '/$' => 'admin/login/login',
    ];
    $route_config = array_merge($route_config, $admin_route_config);
}

return $route_config;
