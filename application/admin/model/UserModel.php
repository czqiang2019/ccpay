<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class UserModel extends Model
{
    protected $table="box_user";

    /*
     *查询所有
     */
    public function user_list($where,$min,$max,$page,$pageSize){
        $result=Db::name("user")
            ->where($where)
            ->whereTime("add_time","between",[$min,$max])
            ->order('add_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }

    /*
     * 删除
     */
    public function del_user($id){
        $user=UserModel::get($id);
        if(empty($user)){
            return array("status"=>0,"msg"=>"信息有误");
        }
        $data=Db::name("user")->delete($id);
        if ($data){
            return array("status"=>1,"msg"=>"删除成功");
        }else{
            return array("status"=>0,"msg"=>"删除失败");
        }
    }
    /*
     * 修改会员的状态
     */
    public function update_user_status($id,$status){
        $info=UserModel::get($id);
        if(empty($info)){
            return array("status"=>0,"msg"=>"信息有误");
        }
        $result=Db::name("user")->where(array("id"=>$id))->update(array("status"=>$status));
        if($result){
            return array("status"=>1,"msg"=>"修改成功");
        }else{
            return array("status"=>0,"msg"=>"修改失败");
        }
    }
}
