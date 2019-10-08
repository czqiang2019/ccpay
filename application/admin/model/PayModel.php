<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class PayModel extends Model
{
    protected $name="pay";

    public function order_list($where,$min,$max,$page,$pageSize,$type){
        $result=Db::name("pay")
            ->where(array('type'=>$type))
            ->where($where)
            ->whereTime('ctime','between',[$min,$max])
            ->order('ctime desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
}
