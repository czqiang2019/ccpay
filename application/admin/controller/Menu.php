<?php

namespace app\admin\controller;

use app\admin\model\MenuModel;
use think\Controller;
use think\Db;
use think\Request;

class Menu extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $keyword=isset($_POST["keyword"])?$_POST["keyword"]:"";
        if (!empty($keyword)){
            $where["name"]=array("like","%$keyword%");
            $where["type"]=array('eq',"menu");
            $menuInfo=Db::name("auth_menu")->where($where)->select();
            $num=count($menuInfo);
        }else{
            $menu=new MenuModel();
            $menuInfo=$menu->getMenu();
            $num = count(Db::name('auth_menu')->where(array('type'=>'menu'))->select());
        }
        $this->assign("menuInfo",$menuInfo);
        $this->assign("keyword",$keyword);
        $this->assign("num",$num);
        //
        return $this->fetch("menu-index");

    }
    /*
     * 添加菜单栏
     */
    public function addMenu()
    {
        if (\request()->isPost()){
            $insert_data=array();
            $insert_data["name"]=input("name");
            $insert_data["ico"]=input("ico");
            $insert_data["parent_id"]=input("parent_id");
            if ($insert_data["parent_id"]!=0){
                $insert_data["url"]=input("url");
            }
            $insert_data["sort"]=input("sort");
            $insert_data['status'] = input('is_show');
            $res = Db::name('auth_menu')->insert($insert_data);
            if ($res) {
                exit(json_encode(array('status'=>1,'msg'=>'添加成功')));
            } else {
                exit(json_encode(array('status'=>0,'msg'=>'添加失败')));
            }
        }
        $menu=new MenuModel();
        $menuInfo=$menu->getMenu();
        $this->assign("menuInfo",$menuInfo);
        //
        return $this->fetch("menu-add");

    }
    /*
     * 编辑菜单栏
     */
    public function editMenu(){
        $id=input("id");
        if (\request()->isPost()){
            $insert_data=array();
            $insert_data["name"]=input("name");
            $insert_data["ico"]=input("ico");
            $insert_data["parent_id"]=input("parent_id");
            if ($insert_data["parent_id"]!=0){
                $insert_data["url"]=input("url");
            }
            $insert_data["sort"]=input("sort");
            $insert_data['status'] = input('is_show');
            $res=Db::name('auth_menu')->where(array("id"=>$id))->update($insert_data);
            if ($res){
                exit(json_encode(array("status"=>1,"msg"=>"编辑成功")));
            }else{
                exit(json_encode(array("status"=>0,"msg"=>"编辑失败")));
            }
        }
        $info=Db::name("auth_menu")->where(array("id"=>$id))->find();
        if (empty($info)){
            $this->error("信息错误");
        }
        $menu=new MenuModel();
        $menuInfo=$menu->getMenu();
        $this->assign("menuInfo",$menuInfo);
        $this->assign("info",$info);
        return $this->fetch("menu-add");
    }
    /*
     * 删除菜单栏
     *
     */
    public function delMenu(){
        $id=input("id");
        $menu=new MenuModel();
        $data=$menu->del_menu($id);
        exit(json_encode($data));
    }

}
