<?php

namespace app\admin\controller;

use app\admin\model\OrderModel;
use app\admin\model\PayModel;
use think\Db;
use think\Request;

class Orders extends Base
{
    /*
     * 列表页
     */
    public function index()
    {
        if (\request()->isPost()){
            $min = isset($_POST["logmin"]) ? strtotime($_POST["logmin"]) : "";
            $max = isset($_POST["logmax"]) ? strtotime($_POST["logmax"]) : "";
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["mid|order_id|pay_id"] = array("like", "%$keyword%");
            }
            if ($min == '' && $max == '') {
                $min = strtotime(date('Y-m-1 00:00:00'));
                $max = strtotime(date('Y-m-d 23:59:59'));
            }
            if ($min != '' && $max == '') {
                $max = strtotime(date('Y-m-d 23:59:59'));
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $product = new OrderModel();
            $list = $product->orders_list($where,$min,$max,$page,$pageSize);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['create_date'] = date('Y-m-d H:i:s', $v['create_date']);
                $list['data'][$k]['pay_date'] = date('Y-m-d H:i:s',$v['pay_date']);
                $list['data'][$k]['close_date'] = date('Y-m-d H:i:s',$v['close_date']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        return $this->fetch("order-list");
    }
    public function pay(){
        if (\request()->isPost()){
            $min = isset($_POST["logmin"]) ? strtotime($_POST["logmin"]) : "";
            $max = isset($_POST["logmax"]) ? strtotime($_POST["logmax"]) : "";
            $type = isset($_POST["type"]) ? $_POST["type"] : "1";
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["mid|sn"] = array("like", "%$keyword%");
            }
            if ($min == '' && $max == '') {
                $min = strtotime(date('Y-m-1 00:00:00'));
                $max = strtotime(date('Y-m-d 23:59:59'));
            }
            if ($min != '' && $max == '') {
                $max = strtotime(date('Y-m-d 23:59:59'));
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $product = new PayModel();
            $list = $product->order_list($where,$min,$max,$page,$pageSize,$type);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['day'] = $v['type'] == 1 ? "充值" : $v['day'];
                $list['data'][$k]['level'] = $v['type'] == 1 ? "充值" : get_level_name($v['level']);
                $list['data'][$k]['ctime'] = date('Y-m-d H:i:s', $v['ctime']);
                $list['data'][$k]['ptime'] = $v['ptime'] == null ? "" :date('Y-m-d H:i:s', $v['ptime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('title',input('type') == 1 ? "商户充值订单" : "商户升级订单");
        $this->assign('type',input('type'));
        return $this->fetch("pay-list");
    }
}
