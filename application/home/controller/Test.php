<?php
namespace app\home\controller;

use app\admin\model\OrderModel;
use app\admin\model\UserModel;
use think\Controller;
use think\Db;

class Test extends Controller
{
    public function index()
    {
        $user = UserModel::where('mid',19)->field('id,mid,money,mout,exp_time,apikey')->find();
        if($user['exp_time'] < time() && $user['level'] != 1){
            $mout = get_sys('user_level_mout');
        }else{
            $mout = $user['mout'];
        }
        echo $mout;
    }
    public function showurl($url_long)
    {
        $api = 'http://api.t.sina.com.cn/short_url/shorten.json';
        $source = '4250147345';
        $url_long = $url_long;
        $request_url = sprintf($api.'?source=%s&url_long=%s', $source, $url_long);
        return $this->getCurl($request_url);
    }
    //发送Http请求
    function getCurl($url, $post = 0, $cookie = 0, $header = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $klsf[] = 'Accept:*/*';
        $klsf[] = 'Accept-Language:zh-cn';
        //$klsf[] = 'Content-Type:application/json';
        $klsf[] = 'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_1 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Mobile/15C153 MicroMessenger/6.6.1 NetType/WIFI Language/zh_CN';
        $klsf[] = 'Referer:https://servicewechat.com/wx7c8d593b2c3a7703/5/page-frame.html';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $klsf);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

}