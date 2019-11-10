<?php

namespace app\admin\controller;

use app\admin\model\RoleModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Base extends Controller
{
    /*
     * 初始化操作
     */
    public function _initialize()
    {
      	
        //取出seession的值
        $admin=Session::get("admin");
        $adminInfo=Db::name("admin")
            ->where(array("names"=>$admin))
            ->find();
        $url=getActionUrl();
        //日志记录表
        $name=$adminInfo["names"];
        $insert_data=array();
        $insert_data["action"]=$url;
        $insert_data["name"]=$name;
        $insert_data["time"]=time();
        Db::name("operation")->insert($insert_data);

        if (empty($admin)){
        	if(get_sys('admin_login_path') == 'admin' || get_sys('admin_login_path') == '') {
	            $this->redirect("admin/login/login");
	        }
	        exit();
        }else{
            $adminInfo=Db::name("admin")
                ->where(array("names"=>$admin))
                ->find();
        }
        //取出角色
        $role=Db::name("auth_role")
            ->where('role_id',$adminInfo["role_id"])
            ->field('role_name')
            ->find();
        //获取当前管理员是否有当前进去的方法的权限
        $url=getActionUrl();
        $roles=new RoleModel();
        $auth=$roles->getAuthInfo($adminInfo["role_id"]);
        if ($auth==NULL){
            echo '<script>alert("没有权限111");请联系管理员</script>';exit;
        }
        $auth_array=array();
        foreach ($auth as $key=>$value){
            $auth_array[]=strtolower($value['url']);
        }
        //过滤首页和欢迎页
//        var_dump($url);var_dump($auth_array);
        if (!in_array($url,array('admin/index/index','admin/index/welcome'))){
            if (!in_array($url,$auth_array)){
                echo "<script>alert('没有权限2');</script>";exit;
            }
        }
        //获取当前用户可以访问的菜单
        $menuInfo=$roles->getMenuInfo($adminInfo["role_id"]);
        if ($menuInfo==NULL){
            echo '<script>alert("没有权限33");请联系管理员</script>';exit;
        }
        $this->assign('menuInfo',$menuInfo);
        $this->assign('admin',$admin);
        $this->assign('role',$role);
        $this->assign('adminInfo',json_encode($adminInfo));
        parent::_initialize(); // TODO: Change the autogenerated stub

    }

    public function clear(){
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }
    public function send_email($email,$title,$content){
        $address = "";
        $res=sendMail($email,$title,$content);
        if($res){
            return $this->getReturn();
        }else{
            return $this->getReturn(0,'发送失败');
        }
    }
  	function _empty(){
        header("HTTP/1.0 404 Not Found");
        return $this->fetch(ROOT_PATH . "/public/404.html");
    }
}
