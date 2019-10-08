<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class MessageModel extends Model
{
    protected $table="box_msg";

    public function message_list($where,$page,$pageSize){
        $result=\think\Db::name("msg")
            ->where($where)
            ->order('ctime','desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
}
