<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Echarts extends Base
{
    public function user(){
        $data=Db::name("user")->field("user_name,age")->where("rective","=",1)->select();
        $sql=Db::query("SELECT user_system,count(*) as num FROM `user` GROUP BY user_system");
        $this->assign("sql",$sql);
        $this->assign("data",$data);
        return $this->fetch("echarts-user");
    }
}
