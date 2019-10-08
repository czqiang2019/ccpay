<?php

namespace app\admin\controller;

use app\admin\model\AdminModel;
use app\admin\model\MenuModel;
use app\admin\model\RoleModel;
use think\Controller;
use think\Db;
use think\Request;

class Admin extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $min=isset($_POST["logmin"])?strtotime($_POST["logmin"]):"";
        $max=isset($_POST["logmax"])?strtotime($_POST["logmax"]):"";
        $keyword=isset($_POST['keyword'])?$_POST['keyword']:'';
        $where=null;
        if (!empty($keyword)){
            $where["u.names"]=array("like","%$keyword%");
        }
        $admin=new AdminModel();
        $data=$admin->getAdminUser($where,$min,$max);
        $num=count($data);
        $this->assign("data",$data);
        $this->assign("num",$num);
        //
        return $this->fetch("admin-list");
    }
    /*
     * 添加管理员
     */
    public function addAdmin(){
        if(\request()->isPost()){
            $insert_data=array();
            $insert_data["names"]=input("names");
            $insert_data["email"]=input("email");
            $insert_data["phone"]=input("phone");
            $insert_data["password"]=pswCrypt(input("password"));
            $insert_data["add_time"]=time();
            $insert_data["status"]=input("status");
            $insert_data["role_id"]=input("role_id");
            $info=Db::name("admin")->where(array("names"=>input("names")))->select();
            if (!empty($info)){
                exit(json_encode(array('status'=>0,'msg'=>'当前名称已存在')));
            }
            $result=Db::name("admin")->insert($insert_data);
            if ($result){
                exit(json_encode(array('status'=>1,'msg'=>'添加成功')));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'添加失败')));
            }
        }else{
            $admin=new AdminModel();
            $data=$admin->getAdminRole();
//            var_dump($data);exit();
            $this->assign("data",$data);
            return $this->fetch("admin-add");
        }

    }
    /*
     * 编辑管理员
     */
    public function editAdmin(){
        $id=input("id");
        $data=Db::name("admin")->where(array("id"=>$id))->find();
        if(\request()->isPost()){
            $insert_data=array();
            $insert_data["names"]=input("names");
            $insert_data["email"]=input("email");
            $insert_data["phone"]=input("phone");
            $insert_data["password"]=pswCrypt(input("password"));
            $insert_data["add_time"]=time();
            $insert_data["status"]=input("status");
            $insert_data["role_id"]=input("role_id");
//            $info=Db::name("admin")->where(array("names"=>input("names")))->where(array("id"=>$id))->select();
//            if (!empty($info)){
//                exit(json_encode(array('status'=>0,'msg'=>'当前名称已存在')));
//            }
            $results=Db::name("admin")->where(array("id"=>$id))->update($insert_data);
            if ($results){
                exit(json_encode(array('status'=>1,'msg'=>'编辑成功')));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'编辑失败')));
            }
        }
        $admin=new AdminModel();
        $admins=$admin->getAdminRole();
        $this->assign("admins",$admins);
        $this->assign("data",$data);
        return $this->fetch("admin-edit");
    }
    /*
     * 删除管理员
     */
    public function delAdmin(){
        $id=input("id");
        $admin=new AdminModel();
        $data=$admin->del_admin($id);
        exit(json_encode($data));
    }
    /*
     * 修改用户的状态
     */
    public function updateAdminStatus(){
        $id=input("id");
        $status=input("status");
        $admin=new AdminModel();
        $data=$admin->update_admin_status($id,$status);
        exit(json_encode($data));
    }

    /*
     * 获取角色列表
     */
    public function role(){
        $admin=new AdminModel();
        $admins=$admin->getAdminRole();
        $num=count($admins);
        $this->assign("admins",$admins);
        $this->assign("num",$num);
        return $this->fetch("admin-role");
    }
    /*
     * 添加角色
     */
    public function addRole(){
        if(\request()->isPost()){
            $insert_data=array();
            $insert_data["role_name"]=input("name");
            $insert_data["desc"]=input("desc");
            $insert_data["menu_id"]=trim(input("menuid"),",");
            $info=Db::name("auth_role")->where(array("role_name"=>input('name')))->select();
            if(!empty($info)){
                exit(json_encode(array('status'=>0,'msg'=>'当前名称已存在')));
            }
            $result=Db::name("auth_role")->insert($insert_data);
            if($result){
                exit(json_encode(array("status"=>1,"msg"=>"添加成功")));
            }else{
                exit(json_encode(array("status"=>0,"msg"=>"添加失败")));
            }
        }
        //获取所有菜单栏以及子节点
        $admin=new AdminModel();
        $admins=$admin->getAllPermissionInfo();
//        var_dump($admins);exit;
        $this->assign("admins",$admins);
        return $this->fetch("admin-role-add");
    }
    /*
     * 编辑角色
     */
    public function editRole(){
        $role_id=input("role_id");
        if(\request()->isPost()){
            $insert_data=array();
            $insert_data["role_name"]=input("name");
            $insert_data["desc"]=input("desc");
            $insert_data["menu_id"]=trim(input("menuid"),",");
            $result=Db::name("auth_role")->where(array("role_id"=>$role_id))->update($insert_data);
            if($result){
                exit(json_encode(array("status"=>1,"msg"=>"编辑成功")));
            }else{
                exit(json_encode(array("status"=>0,"msg"=>"编辑失败")));
            }
        }
        $roles=new RoleModel();
        $data=$roles->getRoleInfo($role_id);
        //获取所有菜单栏以及子节点
        $admin=new AdminModel();
        $admins=$admin->getAllPermissionInfo();
        $this->assign("admins",$admins);
        $this->assign("data",$data);
//        var_dump($data);exit();
        return $this->fetch("admin-role-edit");
    }
    /*
     * 删除角色
     *
     */
    public function delRole(){
        $role_id=input("role_id");
        $role=new RoleModel();
        $roles=$role->del_role($role_id);
        exit(json_encode($roles));

    }

    /*
     * 权限列表
     */
    public function permission(){
        $keyword=isset($_POST["keyword"])?$_POST["keyword"]:"";
        $where["type"]=array("eq","per");
        if (!empty($keyword)){
            $where["name"]=array("like","%$keyword%");
        }
        $admin=new AdminModel();
        $admins=$admin->getPermissionInfo($where);
        $num=count($admins);
//        var_dump($admins);exit;
        $this->assign("admins",$admins);
        $this->assign("num",$num);
        return $this->fetch("admin-permission");
    }

    /*
     * 添加权限
     */
    public function addPermission(){
        if(\request()->isPost()) {
            $insert_data = array();
            $insert_data['parent_id'] = input('parent_id');
            $insert_data['url'] = input('url');
            $insert_data['name'] = input('name');
            $insert_data['type'] = 'per';
            $info = Db::name("auth_menu")
                ->where(array('name' => input("name")))
                ->select();
            if (!empty($info)) {
                exit(json_encode(array("status" => 0, "msg" => "当前名称已存在")));
            }
            $res = Db::name("auth_menu")->insert($insert_data);
            if ($res) {
                exit(json_encode(array("status" => 1, "msg" => "添加成功")));
            } else {
                exit(json_encode(array("status" => 0, "msg"=>"添加失败")));
            }
        }
        $admin = new AdminModel();
        $data = $admin->getCmenuInfo();
        $this->assign('data',$data);
        return $this->fetch('admin-permission-add');
    }
    /*
     * 编辑权限
     */
    public function editPermission(){
        $id=input("id");
        $info=Db::name("auth_menu")->where(array("id"=>$id))->find();
        if (\request()->isPost()){
            $insert_data=array();
            $insert_data['parent_id'] = input('parent_id');
            $insert_data['url'] = input('url');
            $insert_data['name'] = input('name');
            $insert_data['type'] = 'per';
            $result=Db::name("auth_menu")
                ->where(array("name"=>input("name")))
                ->where(array("id"=>$id))
                ->find();
            if (!empty($result)){
                exit(json_encode(array("status"=>0,"msg"=>"当前名称已存在")));
            }
            $res=Db::name("auth_menu")->where(array("id"=>$id))->update($insert_data);
            if ($res){
                exit(json_encode(array("status"=>1,"msg"=>"修改成功")));
            }else{
                exit(json_encode(array("status"=>0,"msg"=>"修改失败")));
            }
        }
        if (empty($info)){
            $this->error("信息有误");
        }
        $admin = new AdminModel();
        $data = $admin->getCmenuInfo();
        $this->assign("info",$info);
        $this->assign('data',$data);
        return $this->fetch('admin-permission-edit');
    }

    /*
     * 权限的删除
     */
    public function delPermission(){
        $id=input("id");
        $menu=new MenuModel();
        $data=$menu->del_permission($id);
        exit(json_encode($data));
    }

}
