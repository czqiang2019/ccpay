<?php

namespace app\admin\controller;

use app\admin\model\RecordModel;
use think\Db;
use think\Request;

class Records extends Base
{
    /*
     * 列表页
     */
    public function index()
    {
        if (\request()->isPost()){
            $min = isset($_POST["logmin"]) ? strtotime($_POST["logmin"]) : "";
            $max = isset($_POST["logmax"]) ? strtotime($_POST["logmax"]) : "";
            $type = $_POST["type"] != 1 ? array('type'=>'+') : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $where = null;
            if (!empty($keyword)) {
                $where["mid|oid"] = array("like", "%$keyword%");
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
            $model = new RecordModel();
            $list = $model->records_list($where,$min,$max,$page,$pageSize,$type);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['ctime'] = date('Y-m-d H:i:s', $v['ctime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('type',input('type') == null ? "1" : '2');
        return $this->fetch("record-list");
    }
}
