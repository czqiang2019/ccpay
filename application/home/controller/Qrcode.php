<?php
namespace app\home\controller;

use app\admin\model\QrcodeModel;
use app\admin\model\UserModel;
use app\common\util\QrcodeServer;
use think\Db;

class Qrcode extends Base
{
    public function _initialize()
    {
        $this->login();
        $user = UserModel::get($this->uid());
        $this->assign('user',$user);
    }
    public function index(){
        $type = input('type');
        $model = new QrcodeModel();
        if(request()->post()){
            $type = isset($_POST['type']) ? $_POST['type'] : $type;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["price"] = array("like", "%$keyword%");
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $list = $model->qrcode_list($where,$page,$pageSize,$type,$this->uid());
            foreach ($list['data'] as $k => $v){
                $list['data'][$k]['add_time'] = date('Y-m-d H:i',$v['add_time']);
                $list['data'][$k]['record'] = Db::name('pay_record')->where(array('mid'=>$this->mid(),'qid'=>$v['id'],'type'=>$v['type'],'date'=>strtotime(date('Y-m-d'))))->sum('money');
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('count',$model->get_count($this->uid(),1));
        $this->assign('type',$type);
        $this->assign('title',$type == 1 ? "微信收款码" : "支付宝收款码");
        return $this->fetch('qrcode-list');
    }
    public function addQrcode($type){
        if(\request()->post()){
            $data = request()->except('file');
            $data['uid'] = $this->uid();
            $data['add_time'] = time();
            if($data['price'] == ''){
                $data['mode'] = 1;
                $data['price'] = null;
            }else{
                $data['mode'] = 2;
            }
            $data['type'] = $type;
            $res = Db::name('pay_qrcode')->insert($data);
            if($res){
                return $this->getReturn();
            }else{
                return $this->getReturn([0,'添加失败！']);
            }
        }
        $this->assign('title','添加二维码');
        return $this->fetch('qrcodes-add');
    }
    public function editQrcode(){
        $id = input('id');
        if(\request()->post()){
            $data = request()->except('file');
            $data['uid'] = $this->uid();
            $data['add_time'] = time();
            if($data['price'] == ''){
                $data['mode'] = 1;
                $data['price'] = null;
            }else{
                $data['mode'] = 2;
            }
            $res = Db::name('pay_qrcode')->where('id',$id)->update($data);
            if($res){
                return $this->getReturn();
            }else{
                return $this->getReturn([0,'添加失败！']);
            }
        }
        $info = QrcodeModel::get($id);
        $this->assign('info',$info);
        $this->assign('title','编辑二维码');
        return $this->fetch('qrcodes-edit');
    }
    public function delQrcode(){
        $id = input('id');
        $qrcode = QrcodeModel::get($id);
        if(!$qrcode){
            $this->getReturn(['code'=>0,'收款码不存在！']);
        }
        if($qrcode['uid'] != $this->uid()){
            $this->getReturn([0,'权限不足！']);
        }
        $res = Db::name('pay_qrcode')->delete($id);
        if($res){
            $this->getReturn();
        }else{
            $this->getReturn([0,'删除失败！']);
        }
    }
    
}