<?php
namespace app\home\controller;

use app\admin\model\UserModel;
use think\Controller;
use think\Db;

class Base extends Controller
{
    public function _initialize()
    {
        $this->assign('uid',$this->uid());
    }
    public function login(){
        $uid = $this->uid();
        if($uid){
            $user = UserModel::field('status')->find($uid);
            if(!$user || $user['status'] != 0){
                $this->redirect('/login');
            }
        }else{
            $this->redirect('/login');
        }
    }
    public function uid(){
        return \think\Session::get('uid');
    }
    public function mid(){
        $user = UserModel::field('mid')->find($this->uid());
        return $user['mid'];
    }
    public function getKey(){
        $key = rand_string(28,0,date('His'));
        $user = UserModel::where('apikey',$key)->find();
        if($user){
            $this->getKey();
        }
        return $key;
    }
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }
    function _empty(){
        header("HTTP/1.0 404 Not Found");
        return $this->fetch(ROOT_PATH . "/public/404.html");
    }
}