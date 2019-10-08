<?php

namespace app\admin\controller;

use app\admin\model\OperationModel;
use app\admin\model\OrderModel;
use app\admin\model\UserModel;
use think\Controller;
use think\Request;
use think\Db;

class System extends Base
{
    public function base(){
        if(\request()->post()){
            $data = \request()->post();
            foreach ($data as $k=>$v){
                $res =  Db::name('config')->where('code',$k)->update(['value'=>$v]);
            }
            return ['code'=>1,'msg'=>'保存成功！'];
        }
        $group =  ['site','email','user','pay','reg','sms'];
        $config = \think\Db::name('config')->where('type','in',$group)->field('code,value')->column('value','code');
        $this->assign('config',json_encode($config,true));
        $this->assign('info',$config);
        return view('system-base');
    }
    /**
     * 显示资源列表   操作日志
     */
    public function operation()
    {
        $min=isset($_POST["logmin"])?strtotime($_POST["logmin"]):"";
        $max=isset($_POST["logmax"])?strtotime($_POST["logmax"]):"";
        $keyword=isset($_POST["keyword"])?$_POST["keyword"]:"";
        $where = null;
        if(!empty($keyword)){
            $where['name'] = array("like","%$keyword%");
        }
        $model=new OperationModel();
        $data=$model->Loglist($where,$min,$max);
        $num=count($data);
        $this->assign("data",$data);
        $this->assign("num",$num);
        //
        return $this->fetch("system-operation");

    }

    /*
     * 批量删除  操作日志
     */
    public function delOperation(){
        $id=input("id/a");
        $model=new OperationModel();
        $data=$model->delAll($id);
        exit(json_encode($data));
    }
    public function del(){
        $data = input('post.');
        if(!empty($data['mode'])){
            switch ($data['mode']){
                case '30':
                    $min = strtotime(date('Y-1-1'));
                    $max = strtotime(date('Y-m-d',strtotime('-30 day')));
                    $res = Db::name($data['type'])->where($data['where'],$data['status'])->whereTime('create_date','between',[$min,$max])->delete();
                    break;
                case 'log':
                    $res = Db::name('log')->where('type',$data['type'])->delete();
                    break;
                default:
                    $res = Db::name($data['type'])->where($data['where'],$data['status'])->delete();
                    break;
            }
        }else{
            $res = Db::name($data['type'])->delete($data['id']);
        }
        if($res){
            return $this->getReturn();
        }else{
            return $this->getReturn(0,'删除失败！');
        }
    }
    public function update(){
        $data = input('post.');
        if(!empty($data['sort'])){
            $res = Db::name($data['type'])->where('id',$data['id'])->update(['sort'=>$data['sort']]);
        }else if($data['type'] == 'bd'){
            return $this->setBd($data['id']);
        }else{
            $res = Db::name($data['type'])->where('id',$data['id'])->update(['status'=>$data['status']]);
        }
        if($res){
            return $this->getReturn();
        }else{
            return $this->getReturn(0,'更新失败！');
        }
    }
    public function setBd($id){
        $res = OrderModel::get($id);
        if ($res){
            $url = $res['notify_url'];
            $user = UserModel::where('mid',$res['mid'])->field('apikey')->find();

            $p = "mid=".$res['mid']."&payId=".$res['pay_id']."&param=".$res['param']."&type=".$res['type']."&price=".$res['price']."&reallyPrice=".$res['really_price'];

            $sign = $res['mid'].$res['pay_id'].$res['param'].$res['type'].$res['price'].$res['really_price'].$user['apikey'];
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
}
