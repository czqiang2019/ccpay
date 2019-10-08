<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class AdminModel extends Model
{
    protected $table="box_admin";
    //
    //获取管理员信息
    public function getAdminUser($where,$min,$max){
        if ($min && $max){
            $result=Db::name("admin")
                ->alias('u')
                ->join('auth_role r','u.role_id=r.role_id','left')
                ->where($where)
                ->whereTime('u.add_time', 'between', [$min, $max])
                ->select();
            return $result;

        }else{
            $result=Db::name("admin")
                ->alias('u')
                ->join('auth_role r','u.role_id=r.role_id','left')
                ->where($where)
                ->select();
            return $result;
        }

    }

    //获取角色
    public function getAdminRole(){
        $result=Db::name("auth_role")->select();
        foreach ($result as $key=>$value){
            $admin_user=Db::name("admin")
                ->field("names")
                ->where(array('role_id'=>$value["role_id"]))
                ->select();
            $tmp=array();
            if (!empty($admin_user)){
                foreach ($admin_user as $k=>$v){
                    $tmp[]=$v["names"];
                }
                $result[$key]["admin"]=implode(',',$tmp);
            }else{
                $result[$key]["admin"]='无';
            }
        }
        return $result;
    }

    /*
     * 获取子节点
     */
    public function getPermissionInfo($where){
        $result=Db::name("auth_menu")
            ->where($where)
            ->select();
        foreach ($result as $key=>$value){
            $result[$key]['parent']=Db::name("auth_menu")
                ->where(array('id'=>$value["parent_id"]))
                ->field("name")
                ->find();
        }
        return $result;
    }

    /*
     * 获取所有的菜单栏以及子节点
     *
     */
    public function getAllPermissionInfo(){
       $menus=new MenuModel();
       $data=$menus->getMenu();
       $tmp=array();
       foreach ($data as $key=>$value){
           if (!empty($value["cmenu"])){
               foreach ($value['cmenu'] as $k => $v) {
                   $tmp = DB::name('auth_menu')
                       ->where(array('type'=>'per','parent_id'=>$v['id']))
                       ->select();
                   if (!empty($tmp)) {
                       $data[$key]['cmenu'][$k]['per'] = $tmp;
                   } else {
                       $data[$key]['cmenu'][$k]['per'] = array();
                   }
               }
           }
       }
       return $data;
    }

    /*
     * 获取二级菜单
     */
    public function getCmenuInfo(){
        $where["parent_id"]=array('neq','0');
        $where["type"]=array('eq','menu');
        $menu=Db::name("auth_menu")
            ->where($where)
            ->order("sort asc")
            ->select();
        return $menu;
    }

    /*
     *删除管理员
     */
    public function del_admin($id){
        $info=Db::name("admin")->where(array("id"=>$id))->find();
        if(empty($info)){
            return array("status"=>0,"msg"=>"信息有误");
        }
        if ($info["names"]=="admin"){
            return array("status"=>0,"msg"=>"admin用户不能删除");
        }
        $result=Db::name("admin")->where(array("id"=>$id))->delete();
        if($result){
            return array("status"=>1,"msg"=>"删除成功");
        }else{
            return array("status"=>0,"msg"=>"删除失败");
        }
    }
    /*
     *修改管理员状态
     */
    public function update_admin_status($id,$status){
        $info=Db::name("admin")->where(array("id"=>$id))->find();
        if(empty($info)){
            return array("status"=>0,"msg"=>"信息有误");
        }
        if ($info["names"]=="admin"){
            return array("status"=>0,"msg"=>"admin用户的状态不能更改");
        }
        $result=Db::name("admin")->where(array("id"=>$id))->update(array("status"=>$status));
        if($result){
            return array("status"=>1,"msg"=>"修改成功");
        }else{
            return array("status"=>0,"msg"=>"修改失败");
        }
    }


}
