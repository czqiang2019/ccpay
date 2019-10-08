<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class RecordModel extends Model
{
    protected $name="record";

    public function records_list($where,$min,$max,$page,$pageSize,$type){
    	$mid = get_sys('pay_qrcode_mid');
        $result=Db::name("record")
            ->where($type)
            
            ->where($where)
            ->whereTime('ctime','between',[$min,$max])
            ->order('ctime desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
}
