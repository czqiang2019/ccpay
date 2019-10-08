<?php
namespace app\home\controller;

use app\admin\model\OrderModel;
use app\admin\model\UserModel;
use think\Db;

class Order extends Base
{
    public function _initialize()
    {
        $this->login();
        $user = UserModel::get($this->uid());
        $this->assign('user',$user);
    }
    public function index(){
        $model = new OrderModel();
        if(request()->post()){
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["pay_id"] = array("like", "%$keyword%");
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $list = $model->order_list($where,$page,$pageSize,$this->mid());
            foreach ($list['data'] as $k => $v){
                $list['data'][$k]['create_date'] = date('Y-m-d H:i:s',$v['create_date']);
                $list['data'][$k]['type'] = $v['type'] == 1 ? "微信" : "支付宝";
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('count',$model->get_count($this->mid()));
        $this->assign('title','订单列表');
        return $this->fetch('order-list');
    }
    public function setBd(){
        $res = Db::name("pay_order")->where("id",input("id"))->find();
        if ($res){
            $url = $res['notify_url'];
            $user = UserModel::field('apikey')->find($this->uid());

            $p = "mid=".$this->mid()."&payId=".$res['pay_id']."&param=".$res['param']."&type=".$res['type']."&price=".$res['price']."&reallyPrice=".$res['really_price'];

            $sign = $this->mid().$res['pay_id'].$res['param'].$res['type'].$res['price'].$res['really_price'].$user['apikey'];
            $p = $p . "&sign=".md5($sign);
            if (strpos($url,"?")===false){
                $url = $url."?".$p;
            }else{
                $url = $url."&".$p;
            }
            $re = getCurl($url);
            if ($re=="success"){
                if ($res['state']==0){
                    Db::name("tmp_price")->where("oid",$res['order_id'])->delete();
                }
                Db::name("pay_order")->where("id",$res['id'])->update(array("state"=>1));

                return json($this->getReturn());
            }else{
                return json($this->getReturn(-2,"补单失败",$re));
            }
        }else{
            return json($this->getReturn(-1,"订单不存在"));

        }
    }
    public function delOrder(){
        $id = input('id');
        $order = OrderModel::get($id);
        if(!$order){
            return $this->getReturn([0,'订单不存在！']);
        }
        if($order['mid'] != $this->mid()){
            return ['code'=>0,'msg'=>'权限不足！'];
        }
        $res = Db::name('pay_order')->delete($id);
        if($res){
            return $this->getReturn();
        }else{
            return $this->getReturn([0,'删除失败！']);
        }
    }
    public function test(){
        if(request()->post()){
            $user = UserModel::field('id,apikey')->find($this->uid());
            $sign = md5(input('mid') . input('payId').input('param').input('type').input('price').$user['apikey']);
            $server = "http://" . get_sys('site_api') . "/createOrder";
            $post = "?mid=".input('mid')."&payId=".input('payId').'&param='.input('param').'&type='.input('type')."&price=".input('price').'&sign='.$sign.'&isHtml=1';
            $notify = "&notifyUrl=http://" . get_sys('site_api') . "/notifyTest&returnUrl=http://" . get_sys('site_api') . "/returnTest";
            $url = $server . $post . $notify;
            return $this->getReturn(1,'即将跳转测试',$url);

        }
        $this->assign('payId',date('YmdHis') . $this->uid());
        $this->assign('title','支付测试');
        return $this->fetch('order-test');
    }

}