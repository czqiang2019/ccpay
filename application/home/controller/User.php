<?php
namespace app\home\controller;

use app\admin\model\UserModel;
use think\Db;
use think\Session;

class User extends Base
{
    public function _initialize()
    {
        $this->login();
        $user = UserModel::get($this->uid());
        $this->assign('user',$user);
    }
    public function index(){

        $this->assign('title','商户中心');
        return $this->fetch();
    }
    public function main(){

        $this->assign('title','商户数据');
        return view();
    }
    public function api(){

        $this->assign('title','API说明文档');
        return view();
    }
    public function mobile(){

        $this->assign('title','手机监控端配置');
        return $this->fetch();
    }
    public function info(){
        if(\request()->post()){
            $data = input('post.');
            $res = UserModel::where('id',$this->uid())->update($data);
            if($res){
                return json($this->getReturn(1,'保存成功！'));
            }else{
                return json($this->getReturn(0,'保存失败！'));
            }
        }
        $this->assign('title','用户信息');
        return $this->fetch();
    }
    public function pwd(){
        if(\request()->post()){
            $data = input('post.');
            $user = UserModel::field('password')->find($this->uid());
            if(pswCrypt($data['password']) != $user['password']){
                return json($this->getReturn(0,'原密码错误！'));
            }
            if($data['password1'] != $data['password2']){
                return json($this->getReturn(0,'两次输入密码不一致！'));
            }
            $password = pswCrypt($data['password1']);
            $res = UserModel::where('id',$this->uid())->update(['password'=>$password]);
            if($res){
                return json($this->getReturn(1,'修改成功！'));
            }else{
                return json($this->getReturn(0,'修改失败！'));
            }
        }
        $this->assign('title','修改密码');
        return $this->fetch();
    }
    public function setting(){
        if(\request()->post()){
            $data = input('post.');
            $data['update_time'] = time();
            $res = UserModel::where('id',$this->uid())->update($data);
            if($res){
                return json($this->getReturn(1,'保存成功！'));
            }else{
                return json($this->getReturn(0,'保存失败！'));
            }
        }
        $this->assign('title','商户配置');
        return $this->fetch();
    }
    public function getApi(){
        return json($this->getReturn(1,'生成成功，请保存生效！',$this->getKey()));
    }
    public function getMain(){

        $today = strtotime(date("Y-m-d"),time());

        $todayOrder = Db::name("pay_order")
            ->where("create_date >=".$today)
            ->where("create_date <=".($today+86400))
            ->count();


        $todaySuccessOrder = Db::name("pay_order")
            ->where("state >=1")
            ->where("create_date >=".$today)
            ->where("create_date <=".($today+86400))
            ->count();



        $todayCloseOrder = Db::name("pay_order")
            ->where("state",-1)
            ->where("create_date >=".$today)
            ->where("create_date <=".($today+86400))
            ->count();

        $todayMoney = Db::name("pay_order")
            ->where("state >=1")
            ->where("create_date >=".$today)
            ->where("create_date <=".($today+86400))
            ->sum("price");


        $countOrder = Db::name("pay_order")
            ->count();
        $countMoney = Db::name("pay_order")
            ->where("state >=1")
            ->sum("price");


        return json($this->getReturn(1,"成功",array(
            "todayOrder"=>$todayOrder,
            "todaySuccessOrder"=>$todaySuccessOrder,
            "todayCloseOrder"=>$todayCloseOrder,
            "todayMoney"=>round($todayMoney,2),
            "countOrder"=>$countOrder,
            "countMoney"=>round($countMoney),
        )));

    }
    public function logout(){
        Session::set('uid',null);
        $this->redirect('/login');
    }
}