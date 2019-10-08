<?php

namespace app\admin\controller;

use app\admin\model\UserModel;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

class Users extends Base
{
    /*
     * 列表页
     */
    public function index(){
        if (\request()->isPost()){
            $min = isset($_POST["logmin"]) ? strtotime($_POST["logmin"]) : "";
            $max = isset($_POST["logmax"]) ? strtotime($_POST["logmax"]) : "";
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["tel|mid|email"] = array("like", "%$keyword%");
            }
            if ($min != '' && $max == '') {
                $max = strtotime(date('Y-m-d',strtotime('+1 day')));
            }
            if($min == '' && $max ==''){
                $min = strtotime(date('Y-01-01'));
                $max = strtotime(date('Y-m-d',strtotime('+1 day')));
            }
            if(isset($_POST['do'])){
                $this->userExcel($min,$max);
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $user = new UserModel();
            $list = $user->user_list($where,$min,$max,$page,$pageSize);
            foreach ($list['data'] as $k => $v){
                $list['data'][$k]['add_time'] = date('Y-m-d H:i',$v['add_time']);
                $list['data'][$k]['last_time'] = $v['last_time'] == null ? "" : date('Y-m-d H:i', $v['last_time']);
                $list['data'][$k]['exp_time'] = $v['exp_time'] == null ? "" : date('Y-m-d', $v['exp_time']);
                $list['data'][$k]['level_name'] = get_level_name($v['level']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        return $this->fetch("user-list");
    }

    /*
     * 会员的添加
     */
    public function addUser(){
        if(\request()->isPost()){
            $data = input('post.');
            $user = UserModel::where('tel',$data['tel'])->find();
            if($user){
                return array("status"=>0,"msg"=>"该手机号已存在！");
            }
            if($data['password'] == '') {
                $data['password'] = pswCrypt(123456);
            }else {
                $data['password'] = pswCrypt($data['password']);
            }
            $data['apikey'] = $this->getKey();
            $data['add_time'] = time();
            $data['mout'] = get_sys('user_level' . $data['level'] . '_mout');
            $uid = Db::name("user")->insertGetId($data);
            $mid = get_sys('site_mid') + $uid;
            $res = Db::name('user')->where('id',$uid)->update(['mid'=>$mid]);
            if ($res){
                return array("status"=>1,"msg"=>"添加成功");
            }else{
                return array("status"=>0,"msg"=>"添加失败");
            }
        }
        return $this->fetch("user-add");
    }
    public function editUser(){
        $id=input("id");
        $info=UserModel::get($id);
        if (empty($id)){
            return array("status"=>0,"msg"=>"参数错误");
        }
        if(\request()->isPost()){
            $data = input('post.');
            if($data['tel'] != $info['tel']){
                $user = UserModel::where('tel',$data['tel'])->find();
                if($user){
                    return array("status"=>0,"msg"=>"该手机号已存在");
                }
            }
            if($data['password'] == '') {
                unset($data['password']);
            }else {
                $data['password'] = pswCrypt($data['password']);
            }
            $data['mout'] = get_sys('user_level' . $data['level'] . '_mout');
            $result=Db::name("user")->where("id",$id)->update($data);
            if ($result){
                return array("status"=>1,"msg"=>"编辑成功");
            }else{
                return array("status"=>0,"msg"=>"编辑失败");
            }
        }
        $this->assign("data",$info);
        return $this->fetch("user-edit");
    }
    /*
     * 删除会员
     */
    public function delUser(){
        $id=input("id");
        $user=new UserModel();
        $data=$user->del_user($id);
        return $data;
    }

    /*
     *修改状态
     */
    public function updateUserStatus(){
        $id=input("id");
        $status=input("status");
        $user=new UserModel();
        $data=$user->update_user_status($id,$status);
        return $data;
    }
    public function getKey(){
        $key = rand_string(28,0,date('His'));
        $user = UserModel::where('apikey',$key)->find();
        if($user){
            $this->getKey();
        }
        return $key;
    }
    /*
     * 导出会员信息
     */
    public function userExcel(){

        $users = UserModel::all();     //数据库查询
        $path = dirname(__FILE__); //找到当前脚本所在路径

        vendor("PHPExcel.PHPExcel"); //方法一

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $PHPSheet->setTitle("demo"); //给当前活动sheet设置名称
        $PHPSheet->setCellValue("A1", "ID")
            ->setCellValue("B1", "商户号")
            ->setCellValue("C1", "邮箱")
            ->setCellValue("D1", "手机")
            ->setCellValue("E1", "余额")
            ->setCellValue("F1", "登录ip")
            ->setCellValue("G1", "登录时间")
            ->setCellValue("H1", "商户等级");
        $i = 2;
        foreach($users as $data){
            $PHPSheet->setCellValue("A" . $i, $data['id'])
                ->setCellValue("B" . $i, $data['mid'])
                ->setCellValue("C" . $i, $data['email'])
                ->setCellValue("D" . $i, $data['tel'])
                ->setCellValue("E" . $i, $data['money'])
                ->setCellValue("F" . $i, $data['last_ip'])
                ->setCellValue("G" . $i, $data['last_time'])
                ->setCellValue("H" . $i, get_level_name($data['level']));
            $i++;
        }

        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="会员表单数据.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
}
