<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class OrderModel extends Model
{
    protected $name="pay_order";

    public function orders_list($where,$min,$max,$page,$pageSize){
        $result=Db::name("pay_order")
            ->where($where)
            ->whereTime('create_date','between',[$min,$max])
            ->order('create_date desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
    /*
     *查询所有
     */
    public function order_list($where,$page,$pageSize,$mid){
        $result=Db::name("pay_order")
            ->where(array('mid'=>$mid))
            ->where($where)
            ->order('create_date desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
    public function get_count($mid){
        return OrderModel::where(array('mid'=>$mid))->count();
    }
}
