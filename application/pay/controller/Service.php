<?php
namespace app\pay\controller;

use app\admin\model\OrderModel;
use app\admin\model\UserModel;
use app\common\util\QrcodeServer;
use think\Controller;
use think\Db;

class Service extends Controller
{
    public function index(){
        echo get_sys('site_engname') . " 支付网关";
    }
    public function payinfo(){

        return view('pay-info');
    }
    //获取订单信息
    public function getOrder()
    {
        $res = OrderModel::where("order_id", input("orderId"))->find();
        if ($res){
            $user = UserModel::where('mid',$res['mid'])->field('close_time')->find();

            $data = array(
                "payId" => $res['pay_id'],
                "orderId" => $res['order_id'],
                "payType" => $res['type'],
                "price" => $res['price'],
                "reallyPrice" => $res['really_price'],
                "payUrl" => $res['pay_url'],
                "isAuto" => $res['is_auto'],
                "state" => $res['state'],
                "timeOut" => $user['close_time'],
                "date" => $res['create_date']
            );
            return json($this->getReturn(1, "成功", $data));
        }else{
            return json($this->getReturn(-1, "云端订单编号不存在"));
        }
    }
    //查询订单状态
    public function checkOrder()
    {
        $res = OrderModel::where("order_id", input("orderId"))->find();
        if ($res){
            if ($res['state']==0){
                return json($this->getReturn(-1, "订单未支付"));
            }
            if ($res['state']==-1){
                return json($this->getReturn(-1, "订单已过期"));
            }

            $user = UserModel::where('mid',$res['mid'])->field('apikey')->find();
            $res['price'] = number_format($res['price'],2,".","");
            $res['really_price'] = number_format($res['really_price'],2,".","");


            $p = "payId=".$res['pay_id']."&param=".$res['param']."&type=".$res['type']."&price=".$res['price']."&reallyPrice=".$res['really_price'];

            $sign = $res['mid'].$res['pay_id'].$res['param'].$res['type'].$res['price'].$res['really_price'].$user['apikey'];
            $p = $p . "&sign=".md5($sign);

            $url = $res['return_url'];

            if (strpos($url,"?")===false){
                $url = $url."?".$p;
            }else{
                $url = $url."&".$p;
            }

            return json($this->getReturn(1, "成功", $url));
        }else{
            return json($this->getReturn(-1, "云端订单编号不存在"));
        }

    }

    public function returnTest(){
        $payId = input('payId');//商户订单号
        $param = input('param');//创建订单的时候传入的参数
        $type = input('type');//支付方式 ：微信支付为1 支付宝支付为2
        $price = input('price');//订单金额
        $reallyPrice = input('reallyPrice');//实际支付金额
        $sign = input('sign');//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
		$order = OrderModel::where('pay_id',$payId)->field('mid')->find();
		$user = UserModel::where('mid',$order['mid'])->field('apikey')->find();
        $_sign =  md5($order['mid'] . $payId . $param . $type . $price . $reallyPrice . $user['apikey']);
        if ($_sign != $sign) {
            //echo "error_sign";//sign校验不通过e
            exit('fail');
        }
        echo "商户订单号：".$payId ."<br>自定义参数：". $param ."<br>支付方式：". $type ."<br>订单金额：". $price ."<br>实际支付金额：". $reallyPrice;
    }
    public function notifyTest(){
        $payId = input('payId');//商户订单号
        $param = input('param');//创建订单的时候传入的参数
        $type = input('type');//支付方式 ：微信支付为1 支付宝支付为2
        $price = input('price');//订单金额
        $reallyPrice = input('reallyPrice');//实际支付金额
        $sign = input('sign');//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
		$order = OrderModel::where('pay_id',$payId)->field('mid')->find();
		$user = UserModel::where('mid',$order['mid'])->field('apikey')->find();
        $_sign =  md5($order['mid'] . $payId . $param . $type . $price . $reallyPrice . $user['apikey']);
        if ($_sign != $sign) {
            exit('fail');
        }
        exit('success');
    }

    //关闭订单
    public function closeOrder(){
        $res2 = Db::name("setting")->where("vkey","key")->find();
        $key = $res2['vvalue'];
        $orderId = input("orderId");

        $_sign = $orderId.$key;

        if (md5($_sign)!=input("sign")){
            return json($this->getReturn(-1, "签名校验不通过"));
        }

        $res = Db::name("pay_order")->where("order_id",$orderId)->find();

        if ($res){
            if ($res['state']!=0){
                return json($this->getReturn(-1, "订单状态不允许关闭"));
            }
            Db::name("pay_order")->where("order_id",$orderId)->update(array("state"=>-1,"close_date"=>time()));
            Db::name("tmp_price")
                ->where("oid",$res['order_id'])
                ->delete();
            return json($this->getReturn(1, "成功"));
        }else{
            return json($this->getReturn(-1, "云端订单编号不存在"));

        }
    }
    public function notifyUrl(){
        $mid = input('mid');
        $user = UserModel::where('mid',get_sys('pay_qrcode_mid'))->field('mid,apikey')->find();
        $payId = input('payId');//商户订单号
        $param = input('param');//创建订单的时候传入的参数
        $type = input('type');//支付方式 ：微信支付为1 支付宝支付为2
        $price = input('price');//订单金额
        $reallyPrice = input('reallyPrice');//实际支付金额
        $sign = input('sign');//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)

        $_sign =  md5($user['mid'] . $payId . $param . $type . $price . $reallyPrice . $user['apikey']);
        if ($_sign != $sign) {
            exit('fail');
        }
        $order = Db::name('pay')->where('sn',$payId)->find();
        if($order['status'] == 0){
            exit('success');
        }
        $user = UserModel::where('mid',$order['mid'])->field('id,mid,money,level,exp_time')->find();
        if($order['type'] == 1){
            $money = $user['money'] + $order['money'];
            $res = Db::name('user')->where('mid',$order['mid'])->update(['money'=>$money]);
            Db::name('record')->insert(['mid'=>$order['mid'],'oid'=>$order['sn'],'money'=>$order['money'],'ctime'=>time(),'type'=>'+','remark'=>'商户充值' . $order['money'] . '元']);
        }else{
            if(time() - $user['exp_time'] > 86400){
                $exp_time = strtotime(date('Y-m-d 23:59:59',strtotime('+ ' . $order['day'] . 'day')));
            }else{
                $exp = date('Y-m-d',$user['exp_time']);
                $exp_time = strtotime('+'. $order['day'] .' day',strtotime($exp));
            }
            $res = Db::name('user')->where('mid',$order['mid'])->update(['level'=>$order['level'],'mout'=>get_sys('user_level' . $order['level'] . '_mout'),'exp_time'=>$exp_time]);
            Db::name('record')->insert(['mid'=>$order['mid'],'oid'=>$order['sn'],'money'=>$order['money'],'ctime'=>time(),'type'=>'+','remark'=>'商户充值' . $order['money'] . '元']);
            Db::name('record')->insert(['mid'=>$order['mid'],'oid'=>$order['sn'],'money'=>$order['money'],'ctime'=>time(),'type'=>'-','remark'=>'商户升级' . get_level_name($order['level']) . '支出' . $order['money'] . '元']);
        }
        Db::name('pay')->where('sn',$payId)->update(['status'=>0,'ptime'=>time()]);
        if($res){
            exit('success');
        }else{
            exit('fail');
        }
    }
    public function enQrcode($url){

        $qr_code = new QrcodeServer(['generate'=>"display","size",200]);
        $content = $qr_code->createServer($url);

        return response($content,200,['Content-Length'=>strlen($content)])->contentType('image/png');

    }
    public function returnUrl(){
        echo "支付成功！请刷新页面！";
    }
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }
}