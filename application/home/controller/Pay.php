<?php
namespace app\home\controller;

use app\admin\model\OrderModel;
use app\admin\model\UserModel;
use think\Db;

class Pay extends Base
{
    public function _initialize()
    {
        $this->login();
        $user = UserModel::get($this->uid());
        $this->assign('user',$user);
    }
    public function recharge(){
        if(request()->post()){
            $money = input('money');
            if($money == '' || $money == null){
                $money = get_sys('user_level' . input('level') . '_price');
                $day = input('day');
                $money = $money * $day;
                $days = $day * 30;
                $types = 2;
                $level = input('level');
                $remark = $this->mid() . "商户升级续费" . $day . "月" . $money . "元";
            }else{
                $days = null;
                $types = 1;
                $level = 0;
                $remark = $this->mid() . "商户充值" . $money . "元";
            }
            $user = UserModel::where('mid',get_sys('pay_qrcode_mid'))->field('id,apikey')->find();
            $payId = "CCR" . date('YmdHis') . rand(10,99) . rand(10,99);
            $sign = md5(get_sys('pay_qrcode_mid') . $payId . $remark .input('type').$money.$user['apikey']);
            $server = "http://" . get_sys('site_api') . "/createOrder";
            $post = "?mid=".get_sys('pay_qrcode_mid')."&payId=".$payId.'&param='.$remark.'&type='.input('type')."&price=".$money.'&sign='.$sign.'&isHtml=0';
            $notify = "&notifyUrl=http://" . get_sys('site_api') . "/notifyUrl&returnUrl=http://" . get_sys('site_api') . "/returnUrl";
            $url = $server . $post . $notify;
            $res = getCurl($url);
            Db::name('pay')->insert(['sn'=>$payId,'mid'=>$this->mid(),'level'=>$level,'day'=>$days,'money'=>$money,'ctime'=>time(),'type'=>$types,'remark'=>$remark,'mode'=>1]);
            if($res){
                return $this->getReturn(1,'请扫码付款',$res);
            }else{
                return $this->getReturn(0,'请重试！');
            }
        }
        $this->assign('types',input('types'));
        $this->assign('title','商户充值');
        return $this->fetch();
    }

}