<?php

namespace app\admin\controller;

use app\admin\model\AdminModel;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        if(Session("admin") == null){
        	if(get_sys('admin_login_path') == 'admin' || get_sys('admin_login_path') == '') {
	            $this->redirect("admin/login/login");
	        } else {
	            header("HTTP/1.1 404 Not Found");
	            return $this->fetch(ROOT_PATH . '/public/404.html');
	        }
        }
        
        return $this->fetch("index");

    }
    public function welcome(){
        //获取用户的登录信息
        $admin=session("admin");
        $data=AdminModel::get(["names"=>$admin]);
        //服务器信息表
        $sys_info['os']             = PHP_OS;
        $sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
        $sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off
        $sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $sys_info['curl']			= function_exists('curl_init') ? 'YES' : 'NO';
        $sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['phpv']           = phpversion();
        // $sys_info['ip'] 			= GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['ip'] 			= '127.0.0.1';
        $sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
        $sys_info['max_ex_time'] 	= @ini_get("max_execution_time").'s'; //脚本最大执行时间
        $sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $sys_info['domain'] 		= $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit']   = ini_get('memory_limit');
        $sys_info['timezone']       = date_default_timezone_get();
        $sys_info['time']           = date('Y-m-d H:i:s',time());
        $sys_info['php_uname']         = php_uname();

        $mysqlinfo = Db::query("SELECT VERSION() as version");
        $sys_info['mysql_version']  = $mysqlinfo[0]['version'];
        if(function_exists("gd_info")){
            $gd = gd_info();
            $sys_info['gdinfo'] 	= $gd['GD Version'];
        }else {
            $sys_info['gdinfo'] 	= "未知";
        }
        $this->assign('data',$data);
        $this->assign('sys_info',$sys_info);
        return $this->fetch("welcome");
    }


}
