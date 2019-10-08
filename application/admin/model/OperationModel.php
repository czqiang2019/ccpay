<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class OperationModel extends Model
{
    protected $table="box_operation";
    /*
     * 获取所有的信息
     *
     */
    public function Loglist($where,$min,$max){
        if ($min && $max){
            return Db::name("operation")->where($where)->whereTime('time', 'between', [$min, $max])->select();
        }
        return Db::name("operation")->where($where)->select();
    }

    /*
     * 批量删除
     */
    public function delAll($id){
        $data=Db::name("operation")->delete($id);
        if ($data){
            return array("status"=>1,"msg"=>"删除成功");
        }else{
            return array("status"=>0,"msg"=>"删除失败");
        }
    }

}
