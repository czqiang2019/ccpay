-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-10-08 18:28:44
-- 服务器版本： 5.6.44-log
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_ichuchuang_`
--

-- --------------------------------------------------------

--
-- 表的结构 `box_ad`
--

CREATE TABLE `box_ad` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_admin`
--

CREATE TABLE `box_admin` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `names` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(200) DEFAULT '' COMMENT 'email',
  `password` varchar(200) DEFAULT '' COMMENT '密码',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_login` varchar(50) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `phone` varchar(14) DEFAULT NULL,
  `role_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '角色id',
  `status` tinyint(10) NOT NULL DEFAULT '1' COMMENT '状态 1正常，2冻结',
  `num` int(11) DEFAULT NULL COMMENT '登录的次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `box_admin`
--

INSERT INTO `box_admin` (`id`, `names`, `email`, `password`, `add_time`, `last_login`, `last_ip`, `phone`, `role_id`, `status`, `num`) VALUES
(1, 'admin', '2235@qq.com', 'e9q0ru/s1vmWU', 1568044209, '2019-10-08 17:41:04', '121.206.8.230', '1878276', '1', 1, 27);

-- --------------------------------------------------------

--
-- 表的结构 `box_auth_menu`
--

CREATE TABLE `box_auth_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单名',
  `parent_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '父级ID, 0为顶级菜单',
  `status` tinyint(4) DEFAULT '1' COMMENT '1表示显示，2表示隐藏',
  `url` varchar(100) DEFAULT NULL,
  `sort` tinyint(4) DEFAULT '0' COMMENT '排序',
  `type` varchar(10) NOT NULL DEFAULT 'menu' COMMENT '类型 menu表示菜单栏控制，per表示节点控制',
  `ico` varchar(255) DEFAULT NULL COMMENT '图标'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `box_auth_menu`
--

INSERT INTO `box_auth_menu` (`id`, `name`, `parent_id`, `status`, `url`, `sort`, `type`, `ico`) VALUES
(1, '管理员管理', 0, 1, NULL, 2, 'menu', ''),
(2, '收款码管理', 0, 1, NULL, 3, 'menu', '&#xe627;'),
(3, '角色管理', 1, 1, 'admin/admin/role', 0, 'menu', NULL),
(4, '权限管理', 1, 1, 'admin/admin/permission', 0, 'menu', NULL),
(5, '管理员列表', 1, 1, 'admin/admin/index', 0, 'menu', NULL),
(6, '菜单栏管理', 1, 1, 'admin/menu/index', 9, 'menu', ''),
(7, '添加管理员', 5, 1, 'admin/admin/addAdmin', 0, 'per', NULL),
(8, '删除管理员', 5, 1, 'admin/admin/delAdmin', 0, 'per', NULL),
(9, '修改管理员状态', 5, 1, 'admin/admin/updateAdminStatus', 0, 'per', NULL),
(10, '修改管理员', 5, 1, 'admin/admin/editAdmin', 0, 'per', NULL),
(11, '添加角色', 3, 1, 'admin/admin/addRole', 0, 'per', NULL),
(12, '编辑角色', 3, 1, 'admin/admin/editRole', 0, 'per', NULL),
(13, '删除角色', 3, 1, 'admin/admin/delRole', 0, 'per', NULL),
(14, '添加权限', 4, 1, 'admin/admin/addPermission', 0, 'per', NULL),
(15, '编辑权限', 4, 1, 'admin/admin/editPermission', 0, 'per', NULL),
(16, '删除权限', 4, 1, 'admin/admin/delPermission', 0, 'per', NULL),
(17, '添加菜单栏', 6, 1, 'admin/menu/addMenu', 0, 'per', NULL),
(18, '修改菜单栏', 6, 1, 'admin/menu/editMenu', 0, 'per', NULL),
(20, '删除菜单栏', 6, 1, 'admin/menu/delMenu', 1, 'per', NULL),
(26, '系统管理', 0, 1, NULL, 0, 'menu', '&#xe63c;'),
(32, '日志列表', 26, 1, 'admin/system/operation', NULL, 'menu', NULL),
(34, '删除所有', 32, 1, 'admin/system/delOperation', 0, 'per', NULL),
(35, '清空缓存', 32, 1, 'admin/base/clear', 0, 'per', NULL),
(36, '商户管理', 0, 1, NULL, 8, 'menu', ''),
(37, '商户列表', 36, 1, 'admin/users/index', NULL, 'menu', ''),
(38, '邮件日志', 55, 1, 'admin/manage/emaillog', 5, 'menu', ''),
(39, '会员的添加', 37, 1, 'admin/users/addUser', 0, 'per', NULL),
(40, '会员的编辑', 37, 1, 'admin/users/editUser', 0, 'per', NULL),
(41, '会员的删除', 37, 1, 'admin/users/delUser', 0, 'per', NULL),
(42, '添加公告', 56, 1, 'admin/manage/addAd', 0, 'per', NULL),
(43, '修改会员状态', 37, 1, 'admin/users/updateUserStatus', 0, 'per', NULL),
(44, '导出会员信息', 37, 1, 'admin/users/userExcel', 0, 'per', NULL),
(45, '系统统计', 0, 1, NULL, 10, 'menu', ''),
(46, '会员统计', 45, 1, 'admin/echarts/user', NULL, 'menu', ''),
(47, '收款码列表', 2, 1, 'admin/qrcodes/index', 0, 'menu', ''),
(48, '基础配置', 26, 1, 'admin/system/base', 0, 'menu', ''),
(49, '删除', 48, 1, 'admin/system/del', 0, 'per', NULL),
(50, '更新状态', 48, 1, 'admin/system/update', 0, 'per', NULL),
(51, '订单管理', 0, 1, NULL, 6, 'menu', '&#xe628;'),
(52, '支付订单', 51, 1, 'admin/orders/pay?type=1', 6, 'menu', ''),
(53, '升级订单', 51, 1, 'admin/orders/pay?type=2', 8, 'menu', ''),
(54, '商户订单', 51, 1, 'admin/orders/index', 0, 'menu', ''),
(55, '网站功能', 0, 1, NULL, 9, 'menu', '&#xe72b;'),
(56, '公告列表', 55, 1, 'admin/manage/ad', 0, 'menu', ''),
(57, '消息管理', 55, 1, 'admin/manage/message', 1, 'menu', ''),
(58, '平台订单', 52, 1, 'admin/orders/pay', 0, 'per', NULL),
(59, '财务管理', 0, 1, NULL, 7, 'menu', '&#xe6b5;'),
(60, '商户资金明细', 59, 1, 'admin/records/index', 0, 'menu', ''),
(61, '平台资金明细', 59, 1, 'admin/records/index?type=platform', 1, 'menu', ''),
(62, '编辑公告', 56, 1, 'admin/manage/editAd', 0, 'per', NULL),
(63, '发送消息', 57, 1, 'admin/manage/sendMsg', 0, 'per', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `box_auth_role`
--

CREATE TABLE `box_auth_role` (
  `role_id` tinyint(3) UNSIGNED NOT NULL COMMENT '自增ID',
  `role_name` varchar(100) NOT NULL DEFAULT '' COMMENT '角色名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `menu_id` varchar(255) NOT NULL COMMENT '菜单栏id',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统角色表';

--
-- 转存表中的数据 `box_auth_role`
--

INSERT INTO `box_auth_role` (`role_id`, `role_name`, `desc`, `menu_id`, `modified`) VALUES
(1, '超级管理员', '超级管理员', '26,32,34,35,48,49,50,1,3,11,12,13,4,14,15,16,5,7,8,9,10,6,17,18,20,2,47,51,54,52,58,53,59,60,61,36,37,39,40,41,43,44,38,55,56,42,62,57,63,45,46', '2019-09-10 14:20:47'),
(2, '操作员', '操作员', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,20,26,32,34,35,36,37,38,39,40,41,42,43,44', '2018-10-26 02:25:23'),
(3, '都看', '都看', '', '2018-10-12 07:37:32'),
(4, '游客', '游客', '', '2018-10-12 07:37:30');

-- --------------------------------------------------------

--
-- 表的结构 `box_config`
--

CREATE TABLE `box_config` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'site',
  `status` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `box_config`
--

INSERT INTO `box_config` (`id`, `code`, `value`, `remark`, `type`, `status`) VALUES
(1, 'site_name', 'CcPay免签开源支付系统', '网站名称', 'site', 0),
(2, 'site_title', 'CcPay免签开源支付系统', '网站标题', 'site', 0),
(3, 'site_desc', 'CcPay免签开源支付系统', '网站简介', 'site', 0),
(4, 'site_keywords', 'CcPay免签开源支付系统', '网站关键词', 'site', 0),
(5, 'site_description', 'CcPay免签开源支付系统', '站点描述', 'site', 0),
(6, 'site_author', 'CcPay', '站点作者', 'site', 0),
(7, 'site_url', 'http://127.0.0.1/', '站点链接', 'site', 0),
(8, 'site_logo', NULL, '站点LOGO', 'site', 0),
(9, 'site_engname', 'CcPay', '英文简称', 'site', 0),
(10, 'site_wechat', '7435962', '客服微信', 'site', 0),
(11, 'site_qq', '7435962', '客服QQ', 'site', 0),
(12, 'site_mail', 'iboxun@qq.com', '客服邮箱', 'site', 0),
(13, 'site_icp', '闽ICP备xxxxxxxx号-1', '站点备案号', 'site', 0),
(14, 'site_api', 'api.pay.cn', 'API接口域名', 'site', 0),
(15, 'site_app', '', '监控端下载链接', 'site', 0),
(16, 'site_mid', '999', '初始商户编号', 'site', 0),
(17, 'site_ff', NULL, '分发平台链接', 'site', 0),
(18, 'user_level_mout', '0.5', '注册会员费率', 'user', 0),
(19, 'user_level1_mout', '0.3', '基础版费率', 'user', 0),
(20, 'user_level2_mout', '0.2', '标准版费率', 'user', 0),
(21, 'user_level3_mout', '0.1', '高级版费率', 'user', 0),
(22, 'user_level1_price', '20', '基础版升级价格', 'user', 0),
(23, 'user_level2_price', '30', '标准版升级价格', 'user', 0),
(24, 'user_level3_price', '60', '高级版升级价格', 'user', 0),
(25, 'reg_give_money', '1.00', '注册赠送金额', 'user', 0),
(26, 'reg_give_level', '0', '注册赠送体验套餐', 'reg', 0),
(27, 'reg_give_day', '0', '注册赠送体验天数', 'reg', 0),
(28, 'email_user1', 'cxx@qq.com', '邮箱提醒账号1用户名', 'email', 0),
(29, 'email_password1', '123', '邮箱提醒账号1密码', 'email', 0),
(30, 'email_smtp1', 'smtp.qq.com', '邮箱系统账号1SMTP', 'email', 0),
(31, 'email_port1', '465', '邮箱系统账号1SMTP端口', 'email', 0),
(32, 'email_user2', 'c212@qq.com', '邮箱提醒账号2用户名', 'email', 0),
(33, 'email_password2', 'adsf', '邮箱提醒账号2密码', 'email', 0),
(34, 'email_smtp2', 'smtp.qq.com', '有限提醒账号2SMTP', 'email', 0),
(35, 'email_port2', '465', '邮箱提醒账号2SMTP端口', 'email', 0),
(36, 'pay_mode', '1', '平台收款模式0全部1平台收款2官方接口', 'pay', 0),
(37, 'pay_qrcode_mid', '1000', '系统收款使用商户ID', 'pay', 0),
(38, 'pay_qrcode_mode', '1', '0全部接口1微信2支付宝', 'pay', 0),
(39, 'admin_login_path', 'admin', '后台登陆路径', 'site', 0);

-- --------------------------------------------------------

--
-- 表的结构 `box_log`
--

CREATE TABLE `box_log` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_msg`
--

CREATE TABLE `box_msg` (
  `id` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `jtime` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_operation`
--

CREATE TABLE `box_operation` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL COMMENT '操作管理员',
  `action` varchar(255) DEFAULT NULL COMMENT '操作方法',
  `time` int(11) DEFAULT NULL COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_pay`
--

CREATE TABLE `box_pay` (
  `id` int(11) NOT NULL,
  `sn` varchar(100) NOT NULL COMMENT '订单编号',
  `mid` int(11) NOT NULL COMMENT '商户ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `level` tinyint(2) DEFAULT '0' COMMENT '升级等级',
  `day` int(11) DEFAULT NULL COMMENT '升级天数',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `ptime` int(11) DEFAULT NULL COMMENT '支付时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态1待支付 0支付 2超时',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1充值 2套餐',
  `mode` tinyint(2) NOT NULL DEFAULT '1' COMMENT '支付模式1平台商户 2官方接口'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_pay_noorder`
--

CREATE TABLE `box_pay_noorder` (
  `id` bigint(20) NOT NULL,
  `mid` int(11) NOT NULL,
  `qid` int(11) DEFAULT NULL,
  `close_date` bigint(20) NOT NULL,
  `create_date` bigint(20) NOT NULL,
  `is_auto` int(11) NOT NULL,
  `notify_url` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `pay_date` bigint(20) NOT NULL,
  `pay_id` varchar(255) DEFAULT NULL,
  `pay_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `really_price` double NOT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_pay_order`
--

CREATE TABLE `box_pay_order` (
  `id` bigint(20) NOT NULL,
  `mid` int(11) NOT NULL,
  `qid` int(11) DEFAULT NULL,
  `close_date` bigint(20) NOT NULL,
  `create_date` bigint(20) NOT NULL,
  `is_auto` int(11) NOT NULL,
  `notify_url` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `pay_date` bigint(20) NOT NULL,
  `pay_id` varchar(255) DEFAULT NULL,
  `pay_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `really_price` double NOT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_pay_qrcode`
--

CREATE TABLE `box_pay_qrcode` (
  `id` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `pay_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1微信 2支付宝',
  `mode` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1无固定 2固定金额',
  `max_num` int(11) NOT NULL DEFAULT '0',
  `max_money` double NOT NULL DEFAULT '0',
  `add_time` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_pay_record`
--

CREATE TABLE `box_pay_record` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL COMMENT '商户ID',
  `qid` int(11) NOT NULL COMMENT '二维码ID',
  `date` int(11) NOT NULL COMMENT '日期',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1微信 2支付宝',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入金额'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_record`
--

CREATE TABLE `box_record` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `oid` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `ctime` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '-',
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_tmp_price`
--

CREATE TABLE `box_tmp_price` (
  `price` varchar(255) NOT NULL,
  `oid` varchar(255) NOT NULL,
  `mid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_user`
--

CREATE TABLE `box_user` (
  `id` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '商户ID',
  `level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '商户等级0默认',
  `real_name` varchar(64) DEFAULT NULL COMMENT '会员的名称',
  `password` varchar(120) DEFAULT NULL COMMENT '会员密码',
  `email` varchar(255) DEFAULT NULL COMMENT '会员的邮箱',
  `tel` varchar(120) DEFAULT NULL COMMENT '电话',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `mout` decimal(5,2) DEFAULT '0.50',
  `apikey` varchar(100) DEFAULT NULL COMMENT 'apikey',
  `user_logo` varchar(255) DEFAULT NULL COMMENT '会员头像',
  `last_ip` varchar(255) DEFAULT NULL COMMENT '用户登录的ip',
  `last_time` int(11) DEFAULT NULL COMMENT '会员登录的时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新的时间',
  `exp_time` int(11) DEFAULT NULL COMMENT '会员到期时间',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '会员状态 0 禁用 1 启用',
  `rective` tinyint(2) DEFAULT '1' COMMENT '会员删除   0 删除  1恢复',
  `user_browser` varchar(255) DEFAULT NULL COMMENT '用户使用的设备',
  `user_system` varchar(255) DEFAULT NULL COMMENT '系统',
  `close_time` varchar(20) NOT NULL DEFAULT '5' COMMENT '订单关闭时间',
  `returnUrl` varchar(100) DEFAULT NULL,
  `notifyUrl` varchar(100) DEFAULT NULL,
  `payQf` tinyint(2) NOT NULL DEFAULT '1',
  `lastheart` int(11) DEFAULT NULL,
  `lastpay` int(11) DEFAULT NULL,
  `jkstate` varchar(20) NOT NULL DEFAULT '-1',
  `inviter` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `box_ad`
--
ALTER TABLE `box_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_admin`
--
ALTER TABLE `box_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`names`) USING BTREE;

--
-- Indexes for table `box_auth_menu`
--
ALTER TABLE `box_auth_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `box_auth_role`
--
ALTER TABLE `box_auth_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `box_config`
--
ALTER TABLE `box_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_log`
--
ALTER TABLE `box_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_msg`
--
ALTER TABLE `box_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_operation`
--
ALTER TABLE `box_operation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_pay`
--
ALTER TABLE `box_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_pay_noorder`
--
ALTER TABLE `box_pay_noorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_pay_order`
--
ALTER TABLE `box_pay_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_pay_qrcode`
--
ALTER TABLE `box_pay_qrcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_pay_record`
--
ALTER TABLE `box_pay_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_record`
--
ALTER TABLE `box_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_tmp_price`
--
ALTER TABLE `box_tmp_price`
  ADD PRIMARY KEY (`price`);

--
-- Indexes for table `box_user`
--
ALTER TABLE `box_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `box_ad`
--
ALTER TABLE `box_ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_admin`
--
ALTER TABLE `box_admin`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id', AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `box_auth_menu`
--
ALTER TABLE `box_auth_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- 使用表AUTO_INCREMENT `box_auth_role`
--
ALTER TABLE `box_auth_role`
  MODIFY `role_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `box_config`
--
ALTER TABLE `box_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `box_log`
--
ALTER TABLE `box_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_msg`
--
ALTER TABLE `box_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_operation`
--
ALTER TABLE `box_operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_pay`
--
ALTER TABLE `box_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_pay_noorder`
--
ALTER TABLE `box_pay_noorder`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_pay_order`
--
ALTER TABLE `box_pay_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_pay_qrcode`
--
ALTER TABLE `box_pay_qrcode`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_pay_record`
--
ALTER TABLE `box_pay_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_record`
--
ALTER TABLE `box_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `box_user`
--
ALTER TABLE `box_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
