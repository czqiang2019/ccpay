<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class QrcodeModel extends Model
{
    protected $name="pay_qrcode";

    /*
     *查询所有
     */
    public function qrcodes_list($where,$page,$pageSize){
        $result=Db::name("pay_qrcode")
            ->alias('p')
            ->join('user u','p.uid=u.id','left')
            ->field('p.*,u.mid,u.tel')
            ->where($where)
            ->order('p.add_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
    public function qrcode_list($where,$page,$pageSize,$type,$uid){
        $result=Db::name("pay_qrcode")
            ->where(array('uid'=>$uid,'type'=>$type))
            ->where($where)
            ->order('add_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        return $result;
    }
    public function get_count($uid,$type){
        $num = QrcodeModel::where(array('uid'=>$uid,'type'=>$type))->count();
        return $num;
    }
    public function get_record($qid){

    }
}
