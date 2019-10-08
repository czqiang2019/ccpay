<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class AdModel extends Model
{
    protected $table="box_ad";

    public function ad_list($where,$page,$pageSize){
        $result=\think\Db::name("ad")
            ->where($where)
            ->order('add_time','desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
}
