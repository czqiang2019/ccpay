<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class MenuModel extends Model
{
    protected $table="box_auth_menu";
    /*
     * 获取所有的菜单栏
     */
    public function getMenu($menuid_array=null){

        if (!empty($menuid_array)){
                $menu=Db::name("auth_menu")
                    ->where(array("parent_id"=>0,"type"=>"menu"))
                    ->where('id','in',$menuid_array)
                    ->order("sort asc")
                    ->select();
        }else{
            $menu=Db::name("auth_menu")
                ->where(array("parent_id"=>0,"type"=>"menu"))
                ->order("sort asc")
                ->select();

        }
        $nmenu=array();
        if (!empty($menu)){
            foreach ($menu as $key=>$value){
                $pid=$value['id'];
                $nmenu[$key]=$value;
                if (!empty($menuid_array)){
                    $cmenu=Db::name("auth_menu")
                        ->where(array('parent_id'=>$pid,'type'=>'menu'))
                        ->where('id','in',$menuid_array)
                        ->order("sort asc")
                        ->select();
                }else{
                    $cmenu=Db::name("auth_menu")
                        ->where(array('parent_id'=>$pid,'type'=>'menu'))
                        ->order("sort asc")
                        ->select();
                }
                if(!empty($cmenu)){
                    $nmenu[$key]['cmenu']=$cmenu;
                }else{
                    $nmenu[$key]['cmenu']=array();
                }
            }
        }
        return $nmenu;
    }
    /*
     * 子权限删除
     */
    public function del_permission($id){
        $info=Db::name("auth_menu")->where(array("id"=>$id))->find();
        if(empty($info)){
            return array("status"=>0,"msg"=>"信息错误");
        }
        $data=Db::name("auth_role")->field("menu_id")->select();
        $tmp=array();
        foreach ($data as $key=>$value){
            $tmp[]=explode(",",$value["menu_id"]);
        }
        foreach ($tmp as $k=>$v){
            if (in_array($id,$v)){
                return array("status"=>0,"msg"=>"当前的子权限已经绑定角色，需要解除绑定才可以删除");
            }
        }
        $res=Db::name("auth_menu")->where(array("id"=>$id))->delete();
        if($res){
            return array("status"=>1,"msg"=>"删除成功");
        }else{
            return array("status"=>0,"msg"=>"删除失败");
        }
    }
    /*
     * 删除菜单
     *
     */
    public function del_menu($id){
        $info=Db::name("auth_menu")->where(array("id"=>$id))->find();
        if(empty($info)){
            return array("status"=>0,"msg"=>"信息错误");
        }
        $cmenu_info=Db::name("auth_menu")->where(array("parent_id"=>$id))->find();
        if (!empty($cmenu_info)){
            return array("status"=>0,"msg"=>"当前菜单栏有子菜单或者子权限，不可删除");
        }else{
            $res=Db::name("auth_menu")->where(array("id"=>$id))->delete();
            if ($res){
                return array("status"=>1,"msg"=>"删除成功");
            }else{
                return array("status"=>0,"msg"=>"删除失败");
            }
        }

    }

}
