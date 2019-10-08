<?php

namespace app\admin\controller;

use app\admin\model\QrcodeModel;
use think\Db;
use think\Request;

class Qrcodes extends Base
{
    /*
     * 列表页
     */
    public function index()
    {
        if (\request()->isPost()){
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["u.mid|u.tel"] = array("like", "%$keyword%");
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $product = new QrcodeModel();
            $list = $product->qrcodes_list($where,$page,$pageSize);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $list['data'][$k]['record'] = Db::name('pay_record')->where(array('mid'=>$v['mid'],'qid'=>$v['id'],'type'=>$v['type'],'date'=>strtotime(date('Y-m-d'))))->sum('money');
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        return $this->fetch("qrcodes-list");
    }
}
