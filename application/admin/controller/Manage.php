<?php

namespace app\admin\controller;

use app\admin\model\AdModel;
use app\admin\model\MessageModel;
use app\admin\model\UserModel;
use think\Controller;
use think\Db;
use think\Request;

class Manage extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function ad()
    {
        if (\request()->isPost()){
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["title"] = array("like", "%$keyword%");
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $help = new AdModel();
            $list = $help->ad_list($where,$page,$pageSize);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        //
        return $this->fetch("ad-list");

    }
    public function message()
    {
        if (\request()->isPost()){
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["title"] = array("like", "%$keyword%");
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $model = new MessageModel();
            $list = $model->message_list($where,$page,$pageSize);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
                $list['data'][$k]['jtime'] = $v['jtime'] == null ? "" : date('Y-m-d H:i:s',$v['jtime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        //
        return $this->fetch("message-list");
    }
    public function emaillog()
    {
        if (\request()->isPost()){
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $list = Db::name("log")
                ->order('ctime desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        //
        return $this->fetch("email-log");
    }
    /*
     * 添加帮助
     */
    public function addAd(){
        if(\request()->isPost()){
            $data = input('post.');
            $data['add_time'] = time();
            $res = Db::name('ad')->insert($data);
            if($res){
                return $this->getReturn();
            }else{
                return $this->getReturn(0,'公告添加失败!');
            }
        }
        return $this->fetch("ad-add");
    }
    public function sendMsg(){
        if(\request()->isPost()){
            $data = input('post.');
            $data['ctime'] = time();
            if($data['email'] == 0){
                if($data['mid'] != ''){
                    $user = UserModel::where('mid',$data['mid'])->field('email')->find();
                    $this->send_email($user['email'],$data['title'],$data['content']);
                }else{
                    $user = UserModel::where('status',0)->field('email')->select();
                    foreach ($user as $row){
                        $this->send_email($row['email'],$data['title'],$data['content']);
                    }
                }
            }
            unset($data['email']);
            $res = Db::name('msg')->insert($data);
            if($res){
                return $this->getReturn();
            }else{
                return $this->getReturn(0,'消息发送失败!');
            }
        }
        return $this->fetch("message-send");
    }
    /*
     * 编辑帮助
     */
    public function editAd(){
        $id = input("id");
        $data = AdModel::get($id);
        if (empty($id)){
            return array("status"=>0,"msg"=>"参数错误");
        }
        if(\request()->isPost()){
            $data = input('post.');
            $res = Db::name('ad')->where('id',$id)->update($data);
            if($res){
                return $this->getReturn();
            }else{
                return $this->getReturn(0,'公告修改失败!');
            }
        }
        $this->assign("data",$data);
        return $this->fetch("ad-edit");
    }
}
