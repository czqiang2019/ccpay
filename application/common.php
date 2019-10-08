<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
use think\Route;


Route::domain('api', function(){
    // 动态注册域名的路由规则
    Route::rule('/', 'api/Server/index');
    Route::rule('/createOrder', 'api/server/createOrder');
    Route::rule('/appHeart', 'api/server/appHeart');
    Route::rule('/appPush', 'api/server/appPush');
    Route::rule('/getOrder', 'pay/service/getOrder');
    Route::rule('/checkOrder', 'pay/service/checkOrder');
    Route::rule('/returnTest', 'pay/service/returnTest');
    Route::rule('/notifyTest', 'pay/service/notifyTest');
    Route::rule('/returnUrl', 'pay/service/returnUrl');
    Route::rule('/notifyUrl', 'pay/service/notifyUrl');
    Route::rule('/enQrcode', 'pay/service/enQrcode');
});
//公共函数
/**
 * @return mixed
 * 获取站点信息
 */
function get_sys($code){
    return Db::name('config')->where('code',$code)
        ->value('value');
}
/**
 * [pswCrypt description]密码加密
 * @param  [type] $psw [description]
 * @return [type]      [description]
 */
function pswCrypt($psw){
    $psw = md5($psw);
    $salt = substr($psw,0,4);
    $psw = crypt($psw,$salt);
    return $psw;
}
function mid()
{
    return get_sys('site_mid');
}
/**
 *
 * 验证输入手机号是否合法
 * Www.iBoxun.Com
 * $return
 */
function is_tel($tel)
{
    $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
    if (preg_match($chars, $tel)) {
        return true;
    }
    return false;
}
/**
 * 验证输入的邮件地址是否合法
 */
function is_email($email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
        if (preg_match($chars, $email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function getOs() {
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
        $os = "IOS";
    }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
        $os = "Android";
    }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Mac OS')){
        $os = "Mac OS";
    }else{
        $os = "Pc";
    }
    return $os;
}
function getBrowse()
{
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $br = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i', $br)) {
            $br = 'MSIE';
        } else if (preg_match('/MQQBrowser/i', $br)) {
            $br = 'MQQBrowser';
        } else if (preg_match('/AppleWebKit/i', $br)) {
            $br = 'AppleWebKit';
        } else if (preg_match('/QQBrowser/i', $br)) {
            $br = 'QQBrowser';
        } else if (preg_match('/Firefox/i', $br)) {
            $br = 'Firefox';
        } else if (preg_match('/Chrome/i', $br)) {
            $br = 'Chrome';
        } else if (preg_match('/Safari/i', $br)) {
            $br = 'Safari';
        } else if (preg_match('/Opera/i', $br)) {
            $br = 'Opera';
        } else {
            $br = 'Other';
        }
        return $br;
    } else {
        return 'unknow';
    }
}

/**
 * [getActionUrl description]获取当前url
 * @return [type] [description]
 */
function getActionUrl(){
    $module = request()->module();
    $controller = request()->controller();
    $action = request()->action();
    return strtolower($module.'/'.$controller.'/'.$action);

}

/**
 * 数组层级缩进转换
 * @param array $array
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function tree($array, $pid = 0, $level = 1) {
    static $list = [];
    foreach ($array as $v) {
        if ($v['parent_id'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            $this->tree($array, $v['id'], $level + 1);
        }
    }
    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array 要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid 父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid = 'pid', $child_key_name = 'children') {
    $counter = $this->array_children_count($array, $pid);
    if ($counter[0] == 0){
        return false;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid] == 0) {
                $tree[] = $temp;
            } else {
                $array = $this->array_child_append($array, $temp[$pid], $temp, $child_key_name);
            }
        }
        $counter = $this->array_children_count($array, $pid);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param $array
 * @param $pid
 * @return array
 */
function array_children_count($array, $pid) {
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name) {
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}


/**
 * [log description]打印日志
 * @param  [type] $name  [description]
 * @param  [type] $value [description]
 * @param  [type] $file  [description]
 * @param  [type] $line  [description]
 * @return [type]        [description]
 */
function logs($name, $value, $file = __FILE__, $line = __LINE__) {
    $value = date('Y-m-d H:i:s') . " " . $value;
    return app_log(date('Ymd') . $name, $value, "", $line);
}

/**
 * [app_log description]日志
 * @param  [type] $name  [description]
 * @param  [type] $value [description]
 * @param  [type] $file  [description]
 * @param  [type] $line  [description]
 * @return [type]        [description]
 */
function app_log($name,$value,$file=__FILE__,$line=__LINE__){
    $value="<?exit;?".">$file\t$line\t".$value."\n";
    if (!is_dir(ROOT_PATH.'cache')){//当路径不穿在
        mkdir(ROOT_PATH.'cache', 0777);
        chmod(ROOT_PATH.'cache', 0777);
    }
    file_put_contents(ROOT_PATH.'cache/log.'.$name.'.php',$value,FILE_APPEND);
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)){
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}
function rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='abcdefghijklmnopqrstuvwxyz1234567890'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
            $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}
/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $arr = db('config')->where('inc_type','smtp')->select();
    $config = convert_arr_kv($arr,'name','value');

    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];

    if($mail->Port == '465') {
        $mail->SMTPSecure = 'ssl';
    }// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //发送邮箱
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user'],$config['email_id']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    return $mail->send();
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
function get_level_name($level){
    switch ($level){
        case '1':
            return "基础版";
            break;
        case '2':
            return "标准版";
            break;
        case '3':
            return "高级版";
            break;
        default:
            return "免费版";
            break;
    }
}
function sendMail($to, $title, $content, $filePath = '', $throwExceptions = false) {
    //步骤
    //1复制文件到当前项目下的Thinkphp/libary/Org/Util (class.pop3.php class.smtp.php class.phpmailer.php)
    //2.修改类文件的名称
    //3.修改命名空间
    //4.注意在PHPMailer中最后一个继承
    $mail = new Util\Mailer\PHPMailer($throwExceptions);
    // $mail->SMTPDebug  = 1;
    $mail->CharSet = "utf-8"; //设置采用utf8中文编码
    $mail->IsSMTP(); //设置采用SMTP方式发送邮件

    $max   = 2;
    $index = rand(1, 2);

    $tried = explode(',', trim(',', session('last_try_email')));
    if(empty($tried)) $tried = [];

    while (in_array($index, $tried)) {
        $index = rand(1, 2);
    }
    if (empty($index)) {
        $configIndex = '';
    } else {
        $configIndex = $index;
    }

    $host     = get_sys('email_smtp' . $configIndex);
    $port     = get_sys('email_port' . $configIndex);
    $from     = get_sys('email_user' . $configIndex);
    $password = get_sys('email_password' . $configIndex);


    //$host     = "smtp.qq.com";//sysconf('email_smtp' . $configIndex);
    //$port     = "465";//sysconf('email_port' . $configIndex);
    //$from     = "ccfaka@foxmail.com";//sysconf('email_user' . $configIndex);
    //$password = "cgivsubpthaybifc";//sysconf('email_pass' . $configIndex);


    $mail->Host       = $host; //设置邮件服务器的地址
    $mail->Port       = $port; //设置邮件服务器的端口，默认为25
    $mail->From       = $from; //设置发件人的邮箱地址
    $mail->FromName   = get_sys('sys_engname'); //设置发件人的姓名
    $mail->SMTPAuth   = true; //设置SMTP是否需要密码验证，true表示需要
    $mail->SMTPSecure = "ssl";
    $mail->Username   = $from;
    $mail->Password   = $password;
    $mail->Subject    = $title; //设置邮件的标题
    $mail->AltBody    = "text/html"; // optional, comment out and test
    $mail->Body       = $content;
    $mail->IsHTML(true); //设置内容是否为html类型
    $mail->AddAddress(trim($to), ''); //设置收件的地址
    if (!empty($filePath)) {
        $mail->AddAttachment($filePath);
    }
    $try = session('email_try');
    if (empty($try)) {
        session('email_try', 0);
    }
    if (!$mail->Send()) {
        //发送邮件
        //echo '发送失败:' . $mail->ErrorInfo;
        record_file_log('email_error', 'index: ' . $index . "\r\n" . $mail->ErrorInfo);
        //更新可用的邮箱，保证下一封邮件可以发出
        if ($try >= $max) {
            session('email_try', 0);
            session('last_try_email', '');
            return false;
        } else {
            session('email_try', $try + 1);
            session('last_try_email', session('last_try_email') . ',' . $index);
            return sendMail($to, $title, $content, $filePath, $throwExceptions);
        }
    } else {
        // echo "发送成功";
        session('email_try', 0);
        session('last_try_email', '');
        return true;
    }
}
