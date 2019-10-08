<?php
namespace app\home\controller;

use think\Db;
use think\Session;

class Login extends Base
{
    public function login(){
        if(\request()->post()){
            $data = input('post.');
            if(empty($data['tel']) || empty($data['password'])){
                return ['code'=>1,'msg'=>'请输入登陆账号！'];
            }
            if(!is_tel($data['tel'])){
                return ['code'=>1,'msg'=>'请输入正确手机号！'];
            }
            switch ($data['type']){
                case 'reg':
                    $user = Db::name('user')->where('tel',$data['tel'])->find();
                    if($user){
                        return ['code'=>1,'msg'=>'手机已存在！'];
                    }
                    if(!is_email($data['email'])){
                        return ['code'=>1,'msg'=>'请输入正确的邮箱！'];
                    }
                    if($user['status'] != 0){
                        $this->getReturn(1,'商户状态异常！');
                    }
                    $data['password'] = pswCrypt($data['password']);
                    $data['mout'] = get_sys('user_level_mout');
                    $data['add_time'] = time();
                    $data['last_ip'] = request()->ip();
                    $data['last_time'] = time();
                    $data['apikey'] = $this->getKey();
                    $data['user_system'] = getOs();
                    $data['user_browser'] = getBrowse();
                    if(get_sys('reg_give_level') != 0){
                        $data['level'] = get_sys('reg_give_level');
                        $data['mout'] = get_sys('user_level' . get_sys('reg_give_level') . '_mout');
                        $data['exp_time'] = strtotime(date('Y-m-d',strtotime('+ ' . get_sys('reg_give_day') . 'day')));
                    }
                    $data['money'] = get_sys('reg_give_money');
                    unset($data['type']);
                    $uid = Db::name('user')->insertGetId($data);
                    $mid = get_sys('site_mid') + $uid;
                    $res = Db::name('user')->where('id',$uid)->update(['mid'=>$mid]);
                    if($res){
                        Session::set('uid',$uid);
                        return ['code'=>0,'msg'=>'注册成功，即将跳转商户中心！'];
                    }else{
                        return ['code'=>1,'msg'=>'注册失败，请重试！'];
                    }
                    break;
                default:
                    $user = Db::name('user')->where('tel',$data['tel'])->find();
                    if(!$user){
                        return ['code'=>1,'msg'=>'手机号不存在！请点击注册按钮！'];
                    }
                    if(pswCrypt($data['password']) != $user['password']){
                        return ['code'=>1,'msg'=>'密码错误！'];
                    }
                    $res = Db::name('user')->where('tel',$data['tel'])->update(['last_ip'=>request()->ip(),'last_time'=>time(),'user_system'=>getOs(),'user_browser'=>getBrowse()]);
                    if($res){
                        Session::set('uid',$user['id']);
                        return ['code'=>0,'msg'=>'登陆成功，即将跳转商户中心！'];
                    }else{
                        return ['code'=>1,'msg'=>'登陆失败！'];
                    }
                    break;
            }
        }
        $this->assign('title','登陆');
        return $this->fetch();
    }
}