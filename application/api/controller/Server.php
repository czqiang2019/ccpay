<?php
namespace app\api\controller;

use app\admin\model\OrderModel;
use app\admin\model\QrcodeModel;
use app\admin\model\UserModel;
use think\Log;
use think\Controller;
use think\Db;

class Server extends Controller
{
    public function index(){
        exit("欢迎接入 ". get_sys('site_engname') . " Api");
    }
    public function appHeart(){
      	$mid = input('mid');
      	//Log::record("商户ID：" . $mid . "，检测心跳，时间：" . date('Y-m-d H:i:s'),'api');
        $this->closeEndOrder();
        $res2 = UserModel::where('mid',$mid)->field('apikey')->find();
        $key = $res2['apikey'];
        $t = input("t");

        $_sign = $t.$mid.$key;

        if (md5($_sign)!=input("sign")){
            return json("签名校验不通过");
        }

        $jg = time()*1000 - $t;
        if ($jg>50000 || $jg<-50000){
            return json("客户端时间错误");
        }
        UserModel::where("mid",$mid)->update(['lastheart'=>time(),'jkstate'=>1]);

        return json("监控心跳正常！");
    }
    //创建订单
    public function createOrder()
    {
      	//检测订单信息
        $mid = input('mid');
        $payId = input("payId");
      	//Log::record("商户ID：" . $mid . "，创建订单号：" . $payId . "，时间：" . date('Y-m-d H:i:s'),'api');
        $this->closeEndOrder();
        if (!$payId || $payId == "" || !$mid || $mid == '') {
            return json($this->getReturn(-1, "请传入商户号/商户订单号"));
        }
        $type = input("type");
        if (!$type || $type == "") {
            return json($this->getReturn(-1, "请传入支付方式=>1|微信 2|支付宝"));
        }
        if ($type != 1 && $type != 2) {
            return json($this->getReturn(-1, "支付方式错误=>1|微信 2|支付宝"));
        }
        $price = input("price");
        if (!$price || $price == "" || $price <= 0) {
            return json($this->getReturn(-1, "请传入订单金额，金额必须大于0"));
        }
        $sign = input("sign");
        if (!$sign || $sign == "") {
            return json($this->getReturn(-1, "请传入签名"));
        }
        //是否跳转支付
        $isHtml = input("isHtml");
        if (!$isHtml || $isHtml == "") {
            $isHtml = 0;
        }
        $param = input("param");
        if (!$param) {
            $param = "";
        }
        //效验签名
        $user = UserModel::where('mid',$mid)->field('id,mid,money,level,exp_time,apikey,notifyUrl,returnUrl,jkstate,payQf,close_time,email,status')->find();
        if(!$user || $user['status'] != 0){
            return json($this->getReturn(-6,'商户不存在或商户状态异常！'));
        }
        if($user['level'] == 0 || $user['exp_time'] < time() && $user['level'] != 0){
            $min = strtotime(date('Y-m-d 00:00:00'));
            $max = strtotime(date('Y-m-d 23:59:59'));
            $order = OrderModel::where(array('mid'=>$mid))->whereTime('create_date','between',[$min,$max])->count();
            if($order >= 10){
            	$this->send_email($user['email'],'套餐已过期或免费版单日10笔限额已到！请升级或者续费，避免影响使用！');
                return json($this->getReturn(-5,'套餐已过期或免费版单日10笔限额已到！请升级或者续费！'));
            }
        }
        if($user['money'] <= 0){
        	$this->send_email($user['email'],'您的用户余额已不足以抵扣支付手续费，请及时充值，避免影响您的收款！');
            return json($this->getReturn(-4,'账户余额不足，不足以支付手续费！请联系管理员充值！'));
        }
        if (input("notifyUrl")) {
            $notify_url = input("notifyUrl");
        } else {
            $notify_url = $user['notifyUrl'];
        }

        if (input("returnUrl")) {
            $return_url = input("returnUrl");
        } else {
            $return_url = $user['returnUrl'];
        }
        //检查签名and状态
        $_sign = md5($mid . $payId . $param . $type . $price . $user['apikey']);
        if ($sign != $_sign) {
            return json($this->getReturn(-1, "签名错误"));
        }
        if ($user['jkstate'] != "1"){
        	$this->send_email($user['email'],'用户发起支付失败！请检查！');
            return json($this->getReturn(-1, "监控端状态异常，请检查"));
        }
        $reallyPrice = bcmul($price ,100);
        $orderId = date("YmdHms") . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);

        $ok = false;
        for ($i = 0; $i < 10; $i++) {
            $tmpPrice = $user['id'] . $reallyPrice . "-" . $type;

            $row = Db::execute("INSERT IGNORE INTO box_tmp_price (price,oid,mid) VALUES ('".$tmpPrice."','".$orderId."','".$mid."')");
            if ($row) {
                $ok = true;
                break;
            }
            if ($user['payQf'] == 1) {
                $reallyPrice++;
            } else if ($user['payQf'] == 2) {
                $reallyPrice--;
            }
        }
        if (!$ok) {
            return json($this->getReturn(-1, "订单超出负荷，请更换金额或稍后重试"));
        }
        //echo $reallyPrice;
        $reallyPrice = bcdiv($reallyPrice, 100,2);


        $payCode = QrcodeModel::where(array('uid'=>$user['id'],'type'=>$type,'mode'=>1,'status'=>0))->select();
        $count = count($payCode);
        if($count == 0){
            return json($this->getReturn(-1, "商户未上传二维码！",$count));
        }
        if($count > 1){
            $num = rand(0,$count-1);
        }else{
            $num = "0";
        }
        $qid = $payCode[$num]['id'];
        $payUrl = $payCode[$num]['pay_url'];
        $isAuto = 1;
        $_payUrl = QrcodeModel::where(array("price"=>$reallyPrice,"type"=>$type,"uid"=>$user['id'],'mode'=>2,'status'=>0))->find();
        if ($_payUrl) {
            $payUrl = $_payUrl['pay_url'];
            $isAuto = 0;
        }

        $res = OrderModel::where(array("mid"=>$mid,"pay_id"=>$payId))->find();
        if ($res) {
            return json($this->getReturn(-1, "商户订单号已存在"));
        }

        $createDate = time();
        $data = array(
            "mid"=>$mid,
            "close_date" => 0,
            "create_date" => $createDate,
            "is_auto" => $isAuto,
            "notify_url" => $notify_url,
            "order_id" => $orderId,
            "param" => $param,
            "pay_date" => 0,
            "pay_id" => $payId,
            "pay_url" => $payUrl,
            "price" => $price,
            "really_price" => $reallyPrice,
            "return_url" => $return_url,
            "state" => 0,
            "type" => $type,
            "qid"=>$qid

        );

        Db::name("pay_order")->insert($data);

        //return "<script>window.location.href = '/payPage/pay.html?orderId=" + c.getOrderId() + "'</script>";

        if ($isHtml == 1) {

            echo "<script>window.location.href = '/pay/service/payinfo?orderId=" . $orderId . "'</script>";

        } else {
            $data = array(
                "payId" => $payId,
                "orderId" => $orderId,
                "payType" => $type,
                "price" => $price,
                "reallyPrice" => $reallyPrice,
                "payUrl" => $payUrl,
                "isAuto" => $isAuto,
                "state" => 0,
                "timeOut" => $user['close_time'],
                "date" => $createDate
            );
            return json($this->getReturn(1, "成功", $data));

        }
    }
    //App推送付款数据接口
    public function appPush(){
      	$mid = input('mid');
      	$t = input("t");
        $type = input("type");
        $price = input("price");
      	//Log::record("商户ID：" . $mid . "，收款推送，金额：" . $price . "，时间：" . date('Y-m-d H:i:s'),'api');
        $this->closeEndOrder();
        
        $user = UserModel::where('mid',$mid)->field('id,mid,level,money,mout,exp_time,apikey')->find();

        $_sign = $mid . $type . $price . $t . $user['apikey'];
        if (md5($_sign)!=input("sign")){
            return json($this->getReturn(-1, "签名校验不通过"));
        }
        $jg = time()*1000 - $t;
        if ($jg>50000 || $jg<-50000){
            return json($this->getReturn(-1, "客户端时间错误"));
        }
        if($user['exp_time'] < time() && $user['level'] != 1){
            $mout = get_sys('user_level_mout');
        }else{
            $mout = $user['mout'];
        }
        $mout_money = $price * $mout / 100;
        if($mout_money < 0.01){
            $mout_money = 0.01;
        }
        $money = $user['money'] - $mout_money ;
        UserModel::where("mid",$mid)->update(['money'=>$money,'lastpay'=>time()]);
        $order = OrderModel::where(array('mid'=>$mid,'really_price'=>$price,'state'=>0,'type'=>$type))->find();
		Db::name('record')->insert(['mid'=>$mid,'oid'=>$order['order_id'],'price'=>$price,'money'=>$mout_money,'ctime'=>time(),'type'=>'-','remark'=>'订单' . $order['order_id'] . '手续费' . $mout_money]);
        if ($order){
            Db::name("tmp_price")->where(array("oid"=>$order['order_id']))->delete();
            OrderModel::where("id",$order['id'])->update(array("state"=>1,"pay_date"=>time(),"close_date"=>time()));
            $date = strtotime(date('Y-m-d'));
            $record = Db::name('pay_record')->where(array('mid'=>$mid,'qid'=>$order['qid'],'type'=>$type,'date'=>$date))->find();
            if($record){

                Db::name('pay_record')->where(array('mid'=>$mid,'qid'=>$order['qid'],'type'=>$type,'date'=>$date))->update(['money'=>$record['money'] + $price]);
            }else{
                Db::name('pay_record')->insert(array('mid'=>$mid,'qid'=>$order['qid'],'type'=>$type,'date'=>$date,'money'=>$price));
            }
            $url = $order['notify_url'];

            $p = "payId=" . $order['pay_id'] . "&param=" . $order['param'] . "&type=" . $order['type'] . "&price=" . $order['price']. "&reallyPrice=" . $order['really_price'];

            $post = $p . "&sign=" . md5($mid . $order['pay_id'] . $order['param'] . $order['type'] . $order['price'] . $order['really_price'] . $user['apikey']);

            if (strpos($url,"?")===false){
                $url = $url."?".$post;
            }else{
                $url = $url."&".$post;
            }
            $res = getCurl($url);
            if ($res == "success"){
                return json($this->getReturn());
            }else{
                Db::name("pay_order")->where("id",$order['id'])->update(array("state"=>2));
                return json($this->getReturn(-1,"异步通知失败"));
            }

        }else{
            $data = array(
                "mid"=>$mid,
                "close_date" => 0,
                "create_date" => time(),
                "is_auto" => 0,
                "notify_url" => "",
                "order_id" => "无订单转账",
                "param" => "无订单转账",
                "pay_date" => 0,
                "pay_id" => "无订单转账",
                "pay_url" => "",
                "price" => $price,
                "really_price" => $price,
                "return_url" => "",
                "state" => 1,
                "type" => $type
            );
            Db::name("pay_noorder")->insert($data);
            return json($this->getReturn());

        }


    }
    //定时关闭订单
    public function closeEndOrder(){
        //检测商户监控端状态
        $user = UserModel::where('jkstate',1)->field('id,lastheart,email,mid,jkstate')->select();
        foreach ($user as $value){
            if ((time() - $value['lastheart']) > 150){
                UserModel::where("id",$value['id'])->update(['jkstate'=>0]);
                $this->send_email($value['email']);
            }
        }
        //检测订单
        $order = OrderModel::where('state',0)->select();
        foreach ($order as $value){
            $user = UserModel::where('mid',$value['mid'])->field('close_time')->find();
            $closeTime = time() - 60 * $user['close_time'];
            $res = OrderModel::where("create_date <=".$closeTime)->where(array("state"=>0,"mid"=>$value['mid']))->update(["state"=>-1,"close_date"=>time()]);
            if($res){
                Db::name("tmp_price")->where(array('mid'=>$value['mid'],'oid'=>$value['order_id']))->delete();
            }
        }
        //清理价格缓存
        $rows = Db::name("tmp_price")->select();
        foreach ($rows as $row){
            $re = OrderModel::where("order_id",$row['oid'])->find();
            if (!$re){
                Db::name("tmp_price")->where("oid",$row['oid'])->delete();
            }
        }
        $pay = Db::name('pay')->where('status',1)->field('id,ctime,status')->select();
        foreach ($pay as $value){
        	if(time() - $value['ctime'] > 300){
        		Db::name('pay')->where('id',$value['id'])->update(['status'=>2]);
        	}
        }
        return json($this->getReturn());
    }
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }
    public function send_email($email,$txt=null){
        $content = get_sys('site_name') . '提醒您：系统检测到您的监控端已离线，请检查挂机状态！' . $txt;
        $res = sendMail($email,get_sys('site_engname') . '监控端离线提醒',$content);
        if($res){
        	Db::name('log')->insert(['type'=>'email','content'=>'发送成功！' . $email . $content,'ctime'=>time()]);
        }else{
        	Db::name('log')->insert(['type'=>'email','content'=>'发送失败！' . $email . $content,'ctime'=>time()]);
        }
    }
}