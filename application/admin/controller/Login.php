<?php

namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function login()
    {
        //判断是session中是否有值
        if(Session::get('admin')){
            $this->redirect('admin/index/index');
        }else{
            if (\request()->isPost()){
                $name=input("name");
                $pwd=input("pwd");
                $is_rem=input("is_rem");
                if ($is_rem!=1){
                    $pwd=pswCrypt($pwd);
                }
                $captcha=input("captcha");
                $rempsw=input("rempsw");
                //验证用户是否填写
                if (empty($name)||empty($pwd)||empty($pwd)){
                    exit(json_encode(array('status'=>0,'msg'=>'用户名或密码,验证码不可为空')));
                }
                $userInfo=Db::name("admin")->where(array("names"=>$name))->find();
                //验证用户是否存在
                if(empty($userInfo)){
                    exit(json_encode(array('status'=>0,'msg'=>'当前用户不存在或者用户名错误')));
                }
                //验证密码
                if($pwd!=$userInfo["password"]){
                    exit(json_encode(array('status'=>0,'msg'=>'密码错误请从新输入')));
                }
                //验证吗
                if (!captcha_check($captcha)){
                    exit(json_encode(array('status'=>0,'msg'=>'验证码错误')));
                }
                //验证用户的状图
                if ($userInfo["status"]==2){
                    exit(json_encode(array('status'=>0,'msg'=>'当前用户已经被冻结，请联系管理员')));
                }

                //存sessiopn
                Session::set('admin',$name);
                //判断用户是否记住密码
                if ($rempsw==1){
                    //记住密码   存cookie中
                    \cookie('cu',trim($name),3600*24*30);
                    \cookie('CSDFDSA',trim($pwd),3600*24*30);
                }else{
                    //删除cookie、
                    Cookie::delete('cu');
                    Cookie::delete("CSDFDSA");
                }
                //记录时间及ip
                Db::name('admin')->where(array('id'=>$userInfo['id']))->update(['last_login'=>date('Y-m-d H:i:s', time()), 'last_ip'=>request()->ip(),"num"=>$userInfo["num"]+1]);

                exit(json_encode(array('status'=>1,'msg'=>'登录成功')));

            }else{
                $name = Cookie::get('cu');
                $pwd = Cookie::get('CSDFDSA');
                if($name && $pwd) {
                    $this->assign('name',$name);
                    $this->assign('pwd',$pwd);
                }
                return $this->fetch("login");
            }

        }
    }

    /**
     * Login::loginout()
     * 安全退出
     * @author Gary
     * @return void
     */
    public function loginout(){
        Session::delete('admin');
        $this->redirect('admin/login/login');
    }




}
