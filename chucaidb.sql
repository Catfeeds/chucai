-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- 主机: 
-- 生成日期: 2018-03-08 14:51:09
-- 服务器版本: 5.7.12-log
-- PHP 版本: 5.3.29p1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `chucaidb`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_adminuser`
--

CREATE TABLE IF NOT EXISTS `tp_adminuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(32) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `password_reset_token` char(43) DEFAULT NULL,
  `auth_key` char(32) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `email` char(64) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '10',
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10015 ;

--
-- 转存表中的数据 `tp_adminuser`
--

INSERT INTO `tp_adminuser` (`id`, `username`, `password_hash`, `password_reset_token`, `auth_key`, `role`, `email`, `status`, `created_at`, `updated_at`) VALUES
(10000, 'admin', '$2y$13$gTnKxaJhPi6P6KBQ9NQCPe./aUiJ2Y7vboY1r9StRxft207My.ZAC', 'NYojJhDXGBJ5GXHNhUIWdc-swc6r-Wf__1488158311', 'rkHke3ruFO3TTGDA3QSY-eUYQlKU-QYQ', 10, 'admin@192.168.5.58', 10, 1501729418, 1501729418),
(10013, 'admin111', '$2y$13$Dzqipmt1f8fTTKoy/6rnre2oETD0cE/qKbKTZmL/sF3BQcSgvncu.', 'bG3FiLbLA45fqrmLKvyd6MOgT5VlPUpJ_1518400326', '6cLdONYK920jHu7J-5iDHt2LRSCb1a9v', 10, '747250175@qq.com', 0, 1518400353, 1518400353),
(10014, 'admin222', '$2y$13$mZEgfwDS0quUFWzFu/WDf.fTh/oA0an4xdJLVFdQUmtE4G1zt2axW', 'B4KKA8fcdU-F8H_cEqMTpO1Xza8Yiszr_1518401063', '9CXleKX64MiM3PeFm4pxrXMTexwjAIwj', 10, '747250175@qq.com', 10, 1518401062, 1518401062);

-- --------------------------------------------------------

--
-- 表的结构 `tp_article`
--

CREATE TABLE IF NOT EXISTS `tp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表ID',
  `title` varchar(30) NOT NULL COMMENT '文章标题',
  `abstract` varchar(50) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '内容',
  `auth` varchar(30) NOT NULL COMMENT '作者',
  `add_time` int(20) DEFAULT NULL COMMENT '添加时间',
  `view` int(10) DEFAULT '1' COMMENT '查看量',
  `share` int(10) DEFAULT '1' COMMENT '分享数量',
  `art_img` varchar(50) DEFAULT NULL COMMENT '文章缩略图',
  `source` tinyint(1) DEFAULT '1' COMMENT '来源(0.外链，1.内部)',
  `type` tinyint(1) DEFAULT '1' COMMENT '是否可以分享(1.是,0.否)',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(1.开启，0.禁用)',
  `sort` tinyint(1) DEFAULT '1' COMMENT '排序',
  `cid` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '所属分类',
  `chani_url` varchar(255) DEFAULT '' COMMENT '外部链接(如果是转载，记录转载地址)',
  `con_url` varchar(255) DEFAULT '' COMMENT '生成的模板存储地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `tp_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_assignment`
--

INSERT INTO `tp_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin1', '10000', 1481700642),
('员工账户', '10001', 1471919653),
('超级管理员', '10000', 1471583483);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_item`
--

CREATE TABLE IF NOT EXISTS `tp_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_item`
--

INSERT INTO `tp_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1471583483, 1471583483),
('/setting/*', 2, NULL, NULL, NULL, 1471834838, 1471834838),
('/setting/default/*', 2, NULL, NULL, NULL, 1471834849, 1471834849),
('/setting/default/create', 2, NULL, NULL, NULL, 1471834849, 1471834849),
('/setting/default/delete', 2, NULL, NULL, NULL, 1471834849, 1471834849),
('/setting/default/index', 2, NULL, NULL, NULL, 1471834842, 1471834842),
('/setting/default/update', 2, NULL, NULL, NULL, 1471834849, 1471834849),
('/setting/default/view', 2, NULL, NULL, NULL, 1471834849, 1471834849),
('/site/*', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/cache', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/captcha', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/error', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/index', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/login', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/logout', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/site/phpinfo', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/*', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/create', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/delete', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/index', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/update', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('/user/view', 2, NULL, NULL, NULL, 1471854961, 1471854961),
('admin1', 2, '最高权限', NULL, NULL, 1481700502, 1481700597),
('员工账户', 1, '公司员工使用', NULL, NULL, 1471834931, 1476778545),
('超级管理员', 1, '拥有最高权限', NULL, NULL, 1471583483, 1481700627);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `tp_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_rule`
--

CREATE TABLE IF NOT EXISTS `tp_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tp_bank`
--

CREATE TABLE IF NOT EXISTS `tp_bank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '银行ID',
  `name` varchar(50) NOT NULL COMMENT '银行名称',
  `code` varchar(50) DEFAULT '' COMMENT '银行代码(英文简称)',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(1.启用，0.禁用)',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `rgb` varchar(50) NOT NULL DEFAULT '' COMMENT '背景颜色',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_index` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='银行表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `tp_bank`
--

INSERT INTO `tp_bank` (`id`, `name`, `code`, `status`, `logo`, `rgb`) VALUES
(1, '支付宝', '', 1, '/zhifubao.png', '19ACEB'),
(2, '农业银行', 'ICBC', 1, '/nongye.png', '149273'),
(3, '建设银行', '', 1, '/jianshe.png', '00398F'),
(4, '工商银行', '', 1, '/gongshang.png', 'E50010'),
(5, '交通银行', '', 1, '/jiaotong.png', '1B1E88'),
(7, '招商银行', '', 1, '/zhaoshang.png', 'E50010'),
(8, '中国银行', '', 1, '/zgyh.png', 'b81c22');

-- --------------------------------------------------------

--
-- 表的结构 `tp_base_useriotype`
--

CREATE TABLE IF NOT EXISTS `tp_base_useriotype` (
  `uo_id` int(10) NOT NULL AUTO_INCREMENT,
  `uo_inout` int(1) DEFAULT NULL,
  `uo_fatherid` int(10) DEFAULT NULL,
  `uo_level` int(10) DEFAULT NULL,
  `uo_note` varchar(30) NOT NULL,
  `uo_shortcode` varchar(10) NOT NULL,
  `uo_ordernum` int(10) DEFAULT '0',
  `uo_isshow` int(1) DEFAULT '1',
  PRIMARY KEY (`uo_id`),
  KEY `FK_BASE_USERIOTYPE_F_USERIOTYPE` (`uo_fatherid`),
  KEY `inoutFlag_idx` (`uo_inout`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户交易类型定义表' AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `tp_base_useriotype`
--

INSERT INTO `tp_base_useriotype` (`uo_id`, `uo_inout`, `uo_fatherid`, `uo_level`, `uo_note`, `uo_shortcode`, `uo_ordernum`, `uo_isshow`) VALUES
(19, 1, 0, NULL, '购彩支出', 'GC', 10, 1),
(20, 1, 19, NULL, '普通购买', 'GC', 0, 1),
(22, 1, 0, NULL, '支出', 'ZC', 0, 1),
(23, 0, 0, NULL, '充值', 'CZ', 0, 1),
(26, 0, 0, NULL, '取消订单返款', 'CD', 2, 1),
(27, 1, 22, NULL, '用户提款支出', 'TX', 0, 1),
(28, 1, 22, NULL, '手工扣款支出', 'KK', 0, 1),
(29, 0, 26, NULL, '购彩记录取消', 'CD', 0, 1),
(30, 0, 26, NULL, '追号任务取消', 'CD', 0, 1),
(31, 0, 0, NULL, '中奖奖金派送', 'PS', 0, 1),
(32, 0, 31, NULL, '派送发起人提成', 'PS', 0, 1),
(33, 0, 31, NULL, '派送中奖奖金', 'PS', 0, 1),
(34, 0, 0, NULL, '公司活动派送', 'PS', 0, 1),
(35, 0, 34, NULL, '购彩奖励派送', 'PS', 0, 1),
(36, 0, 23, NULL, '挂帐添加', 'TJ', 0, 1),
(37, 1, 0, NULL, '冻结预付款', 'DJ', 8, 1),
(38, 1, 37, NULL, '保底冻结', 'DJ', 0, 1),
(39, 1, 37, NULL, '提款冻结', 'DJ', 0, 1),
(40, 1, 37, NULL, '手工冻结', 'DJ', 0, 1),
(41, 0, NULL, NULL, '解除冻结预付款', 'JD', 0, 1),
(42, 0, 41, NULL, '解除保底冻结', 'JD', 0, 1),
(43, 0, 41, NULL, '解除提款冻结', 'JD', 0, 1),
(44, 0, 41, NULL, '解除手工冻结', 'JD', 0, 1),
(45, 1, 22, NULL, '挂账还款支出', 'kk', 0, 1),
(46, 0, 23, NULL, '支付宝支付', 'CZ', 1, 1),
(47, 0, 23, NULL, '微信支付', 'CZ', 1, 1),
(48, 0, 23, NULL, '爱农支付', 'CZ', 1, 1),
(49, 0, 23, NULL, '连连支付', 'CZ', 1, 1),
(50, 1, 19, NULL, '跟单购买彩票', 'GD', 0, 1),
(51, 0, 22, NULL, '代理佣金转入APP', 'TX', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_card`
--

CREATE TABLE IF NOT EXISTS `tp_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '开卡表ID',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '关联用户ID',
  `bank_id` int(10) NOT NULL COMMENT '开卡银行',
  `card_no` varchar(50) NOT NULL COMMENT '卡号',
  `card_name` varchar(20) DEFAULT '' COMMENT '账户姓名',
  `phone` varchar(20) DEFAULT '' COMMENT '银行卡绑定手机号',
  `province` varchar(20) DEFAULT '' COMMENT '开卡省份',
  `city` varchar(20) DEFAULT '' COMMENT '开卡市',
  `open_bank` varchar(255) DEFAULT '' COMMENT '开户行',
  `remarks` varchar(255) DEFAULT '' COMMENT '备注',
  `status` tinyint(2) DEFAULT '1' COMMENT '银行卡状态(1.启用，0.禁用)',
  `is_def` tinyint(2) unsigned NOT NULL COMMENT '是否默认 1默认 0非默认',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bank_id` (`bank_id`),
  KEY `phone` (`phone`),
  KEY `is_def` (`is_def`),
  KEY `status` (`status`),
  KEY `city` (`city`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `tp_card`
--

INSERT INTO `tp_card` (`id`, `user_id`, `bank_id`, `card_no`, `card_name`, `phone`, `province`, `city`, `open_bank`, `remarks`, `status`, `is_def`) VALUES
(1, 16, 2, '12333081', '', '', '', '', '', '', 1, 0),
(2, 16, 2, '123330812', '', '', '', '', '', '', 1, 0),
(3, 16, 2, '12313131', '', '', '', '', '', '', 1, 1),
(5, 18, 7, '6214855741500975', '', '', '', '', '', '', 1, 0),
(7, 18, 1, 'dyc', '', '', '', '', '', '', 1, 1),
(8, 21, 7, '6214835896791058', '', '', '', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_category`
--

CREATE TABLE IF NOT EXISTS `tp_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类表ID',
  `name` varchar(30) NOT NULL COMMENT '分类名称',
  `sort` tinyint(2) DEFAULT '1' COMMENT '排序',
  `status` tinyint(2) DEFAULT NULL COMMENT '状态(1.启用，0.禁用)',
  `pid` int(10) DEFAULT '0' COMMENT '父ID',
  `position` varchar(10) DEFAULT NULL COMMENT '显示位置(top上,middle中,bottom下)',
  `model_sn` int(10) DEFAULT '1' COMMENT '模板编码',
  PRIMARY KEY (`id`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `tp_category`
--

INSERT INTO `tp_category` (`id`, `name`, `sort`, `status`, `pid`, `position`, `model_sn`) VALUES
(1, '平台', 1, 1, 0, 'top', 1),
(2, '平台公告', 10, 1, 1, 'middle', 1),
(3, '平台新闻', 11, 1, 1, 'middle', 1),
(4, '支付', 2, 1, 0, 'middle', 1),
(5, '支付帮助', 20, 1, 4, 'middle', 1),
(6, '支付须知', 21, 1, 4, 'middle', 1),
(7, '注册', 3, 1, 0, 'top', 1),
(8, '注册协议', 30, 1, 7, 'middle', 1),
(9, '用户须知', 31, 1, 7, 'middle', 1),
(10, '购彩须知', 1, 1, 7, 'middle', 1),
(11, '老蔡解球', 1, 1, 1, 'middle', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_good`
--

CREATE TABLE IF NOT EXISTS `tp_good` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(15) NOT NULL COMMENT '商品标题',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '商品链接',
  `passwd` varchar(30) NOT NULL DEFAULT '' COMMENT '商品密码',
  `prize` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `prize_youhui` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠价格',
  `intro` varchar(200) NOT NULL DEFAULT '' COMMENT '商品描述',
  `month_sale_num` int(11) NOT NULL DEFAULT '0' COMMENT '月销售量',
  `status` varchar(3) NOT NULL DEFAULT '0' COMMENT '0 审核中 1审核通过 2审核失败',
  `admin_name` varchar(30) NOT NULL COMMENT '审核人',
  `admin_remarks` varchar(100) NOT NULL COMMENT '审核说明',
  `good_category_id` int(11) NOT NULL COMMENT '分类id',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- 转存表中的数据 `tp_good`
--

INSERT INTO `tp_good` (`id`, `user_id`, `title`, `url`, `passwd`, `prize`, `prize_youhui`, `intro`, `month_sale_num`, `status`, `admin_name`, `admin_remarks`, `good_category_id`, `create_at`, `update_at`) VALUES
(1, 1, '', 'utl2222', '123', 110.40, 0.00, '2', 0, '0', '', '', 0, '2018-02-23 14:42:41', '2018-03-08 13:52:32'),
(2, 1, '', 'utl', '123', 110.40, 0.00, '2', 0, '0', '', '', 0, '2018-02-23 14:43:18', '2018-02-23 14:50:30'),
(3, 1, '', 'utl', '123', 110.40, 0.00, '2', 0, '0', '', '', 0, '2018-02-23 14:43:55', '2018-02-23 14:50:32'),
(4, 1, '', 'http://cc.99caihong.net/api/goodUpload2', '123123', 299.00, 299.00, '精品源码', 0, '0', '', '', 0, '2018-02-23 14:44:54', '2018-02-23 16:24:11'),
(5, 16, '标题', 'http://cc.99caihong.net/api/goodUpload2', '123123', 299.00, 299.00, '精品源码', 22, '1', '', '', 0, '2018-02-23 14:52:09', '2018-02-27 11:12:54'),
(6, 16, '', 'http://cc.99caihong.net/api/goodUpload2', '', 299.00, 299.00, '', 12, '1', '', '', 0, '2018-02-23 15:03:28', '2018-02-27 11:12:56'),
(7, 18, '', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 11, '1', '', '', 2, '2018-02-27 11:06:08', '2018-02-27 11:12:57'),
(8, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 11:52:31', '2018-02-27 11:52:31'),
(9, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:03:34', '2018-02-27 12:03:34'),
(10, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:06:42', '2018-02-27 12:06:42'),
(11, 16, '2', '11', '3', 4.00, 4.00, '5', 0, '0', '', '', 0, '2018-02-27 12:09:51', '2018-02-27 12:09:51'),
(12, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:10:16', '2018-02-27 12:10:16'),
(13, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:12:01', '2018-02-27 12:12:01'),
(14, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:13:20', '2018-02-27 12:13:20'),
(15, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:14:41', '2018-02-27 12:14:41'),
(16, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:16:29', '2018-02-27 12:16:29'),
(17, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:22:40', '2018-02-27 12:22:40'),
(18, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:23:31', '2018-02-27 12:23:31'),
(19, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:40:11', '2018-02-27 12:40:11'),
(20, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:41:18', '2018-02-27 12:41:18'),
(21, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:46:03', '2018-02-27 12:46:03'),
(22, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:48:24', '2018-02-27 12:48:24'),
(23, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:49:29', '2018-02-27 12:49:29'),
(24, 16, '2', '11', '3', 4.00, 4.00, '5', 0, '0', '', '', 0, '2018-02-27 12:51:38', '2018-02-27 12:51:38'),
(25, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:53:11', '2018-02-27 12:53:11'),
(26, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:56:23', '2018-02-27 12:56:23'),
(27, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:58:08', '2018-02-27 12:58:08'),
(28, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 12:58:47', '2018-02-27 12:58:47'),
(29, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:01:21', '2018-02-27 13:01:21'),
(30, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:07:00', '2018-02-27 13:07:00'),
(31, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:07:49', '2018-02-27 13:07:49'),
(32, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:26:36', '2018-02-27 13:26:36'),
(33, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:30:55', '2018-02-27 13:30:55'),
(34, 18, '5', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:33:47', '2018-02-27 13:33:47'),
(35, 18, '最新负！！！！', 'http://cc.99caihong.net/api/goodUpload', '2', 3.00, 3.00, '4', 0, '0', '', '', 0, '2018-02-27 13:35:07', '2018-02-27 13:35:07'),
(36, 18, '好带吗', 'www', '撒啊', 155555.00, 155555.00, '藐视', 0, '0', '', '', 1, '2018-02-27 17:07:35', '2018-02-27 17:07:35'),
(37, 18, '神码', 'www.baidu.com', '123', 5555.00, 5555.00, '最好的源码', 0, '0', '', '', 2, '2018-03-01 09:55:35', '2018-03-01 09:55:35');

-- --------------------------------------------------------

--
-- 表的结构 `tp_good_category`
--

CREATE TABLE IF NOT EXISTS `tp_good_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 启用 0 禁用',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `tp_good_category`
--

INSERT INTO `tp_good_category` (`id`, `name`, `img_path`, `status`, `create_at`, `update_at`) VALUES
(1, '综合商城', '/syl_sc.png', 1, '2018-02-27 10:28:25', '2018-02-28 16:30:40'),
(2, 'o2o', '/syl_oo.png', 1, '2018-02-27 10:28:25', '2018-02-27 10:37:05'),
(3, '企业管理', '/syl_qy.png', 1, '2018-02-27 10:28:45', '2018-02-27 10:36:40'),
(4, '热门APP', '/syl_app.png', 1, '2018-02-27 10:28:45', '2018-02-27 10:37:18'),
(5, '微信H5', '/syl_h.png', 1, '2018-02-27 10:28:52', '2018-02-27 10:36:32'),
(21, 'xzczx', '/1520309240.jpg', 1, '2018-03-06 12:07:20', '2018-03-06 12:07:20');

-- --------------------------------------------------------

--
-- 表的结构 `tp_good_collect`
--

CREATE TABLE IF NOT EXISTS `tp_good_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `tp_good_collect`
--

INSERT INTO `tp_good_collect` (`id`, `user_id`, `good_id`, `create_at`, `update_at`) VALUES
(3, 16, 4, '2018-02-28 10:29:33', '2018-02-28 10:29:33');

-- --------------------------------------------------------

--
-- 表的结构 `tp_good_imgs`
--

CREATE TABLE IF NOT EXISTS `tp_good_imgs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `img_path` varchar(50) NOT NULL COMMENT '图片路径',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `tp_good_imgs`
--

INSERT INTO `tp_good_imgs` (`id`, `good_id`, `img_path`, `create_at`, `update_at`) VALUES
(1, 2, '/20180223/5e2dfdcc54cc98984af1ebbb55072a72.png', '2018-02-23 14:43:18', '2018-02-23 14:43:18'),
(2, 3, '/20180223/f622200718953934875c359cee4f75ff.png', '2018-02-23 14:43:55', '2018-02-23 14:43:55'),
(20, 37, '/20180301/7957086e5f52b8d5221e02b9b4cf64f3.jpg', '2018-03-01 09:55:35', '2018-03-01 09:55:35'),
(19, 37, '/20180301/a636d6958d5d665335532c2c854d0c4c.jpg', '2018-03-01 09:55:35', '2018-03-01 09:55:35'),
(18, 37, '/20180301/12c49d07c67c6e8b1b5ba7db1b23ffc1.jpg', '2018-03-01 09:55:35', '2018-03-01 09:55:35'),
(6, 5, '/20180223/43973286c07ee5fd491d5afa1add14eb.png', '2018-02-23 14:52:09', '2018-02-23 14:52:09'),
(7, 5, '/20180223/4c109a1f7739df7233c8ade0c9f7b26c.png', '2018-02-23 14:52:09', '2018-02-23 14:52:09'),
(8, 5, '/20180223/26eba0c1345ceeeba81eee46997f23da.png', '2018-02-23 14:52:09', '2018-02-23 14:52:09'),
(9, 11, '/20180227/bbcda5d34992971dfd13f522be0bace9.png', '2018-02-27 12:09:51', '2018-02-27 12:09:51'),
(10, 11, '/20180227/5b1c984e826726c8136f75294ecd9df6.png', '2018-02-27 12:09:51', '2018-02-27 12:09:51'),
(11, 31, '/20180227/e3eac5897f9442472efd45a5ba4b65f8.jpg', '2018-02-27 13:07:49', '2018-02-27 13:07:49'),
(12, 34, '/20180227/5beab2942384b9f367ae30581eb631aa.jpg', '2018-02-27 13:33:47', '2018-02-27 13:33:47'),
(13, 34, '/20180227/16f3e0d994a16d00c2b1d899f0243c9b.jpg', '2018-02-27 13:33:47', '2018-02-27 13:33:47'),
(14, 35, '/20180227/361fe1d0522970626180fbb84666c526.jpg', '2018-02-27 13:35:07', '2018-02-27 13:35:07'),
(15, 35, '/20180227/56aba6a23241a6519fa68fd67c74b7f0.jpg', '2018-02-27 13:35:07', '2018-02-27 13:35:07'),
(16, 36, '/20180227/5d2483276087eac3685b7e9bca250ba7.jpg', '2018-02-27 17:07:35', '2018-02-27 17:07:35'),
(17, 36, '/20180227/a8e815379cf2fcaef332c9b0e907e91c.jpg', '2018-02-27 17:07:35', '2018-02-27 17:07:35');

-- --------------------------------------------------------

--
-- 表的结构 `tp_log`
--

CREATE TABLE IF NOT EXISTS `tp_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userphone` varchar(32) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ip` varchar(64) CHARACTER SET utf8mb4 DEFAULT NULL,
  `count` int(11) DEFAULT '0' COMMENT '本日访问次数',
  `platform` int(11) DEFAULT '2' COMMENT '平台来源:1、PC 2、手机 ',
  `create_time` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=451 ;

--
-- 转存表中的数据 `tp_log`
--

INSERT INTO `tp_log` (`id`, `userphone`, `ip`, `count`, `platform`, `create_time`) VALUES
(450, 'admin', '112.17.88.200', 0, 2, '1520488669');

-- --------------------------------------------------------

--
-- 表的结构 `tp_lookup`
--

CREATE TABLE IF NOT EXISTS `tp_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT '叫什么',
  `code` varchar(64) NOT NULL COMMENT '类里面的编号',
  `type` varchar(128) NOT NULL COMMENT '同一类的一个编码',
  `position` int(11) NOT NULL COMMENT '排序位置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='标注表' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `tp_lookup`
--

INSERT INTO `tp_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, '顶级', '1', 'menu-level', 1),
(2, '二级', '2', 'menu-level', 2),
(3, '三级', '3', 'menu-level', 3),
(4, '顶部', 'top', 'position', 1),
(5, '中间', 'middle', 'position', 2),
(6, '底部', 'bottom', 'position', 3),
(7, '正常', '1', 'status', 1),
(8, '锁定', '2', 'status', 2),
(9, '注销', '3', 'status', 3),
(10, '未支付', '0', 'order_status', 1),
(11, '已支付', '1', 'order_status', 2),
(12, '失效', '2', 'order_status', 3),
(13, '待支付', '0', 'banktmp-status', 1),
(14, '支付成功', '1', 'banktmp-status', 2),
(15, '交易结束', '2', 'banktmp-status', 3),
(16, '未付款', '3', 'banktmp-status', 4),
(17, '等待处理', '0', 'getmoney-status', 1),
(18, '已处理', '1', 'getmoney-status', 2),
(19, '拒绝', '2', 'getmoney-status', 3),
(20, '审核中', '0', 'good-status', 1),
(21, '审核通过', '1', 'good-status', 2),
(22, '审核失败', '2', 'good-status', 3);

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu`
--

CREATE TABLE IF NOT EXISTS `tp_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) NOT NULL COMMENT '名称',
  `icon` varchar(256) DEFAULT NULL COMMENT '渲染',
  `url` varchar(514) NOT NULL COMMENT '控制器',
  `pid` int(11) DEFAULT '0' COMMENT '父级id',
  `sort` int(11) DEFAULT '1' COMMENT '排序， 值越大，越靠前',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态 1：显示  -1：删除',
  `level` tinyint(4) DEFAULT '1' COMMENT '等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='菜单信息列表' AUTO_INCREMENT=139 ;

--
-- 转存表中的数据 `tp_menu`
--

INSERT INTO `tp_menu` (`id`, `label`, `icon`, `url`, `pid`, `sort`, `status`, `level`) VALUES
(1, '系统管理', 'glyphicon glyphicon-cog', '#', 0, 50, 1, 1),
(2, '导航栏管理', 'fa fa-circle', '/menu/menu/index', 1, 100, 1, 1),
(3, '参数设置', 'fa fa-circle', '/base/lookup/index', 1, 1, 1, 2),
(12, '权限配置', 'fa fa-circle', '/menu/menu-auth/index', 1, 50, 1, 2),
(91, '设置', '', '#', 98, NULL, 1, 2),
(116, '首页管理', 'glyphicon glyphicon-home', '/site/#', 0, 5000, 1, 1),
(117, '用户管理', 'glyphicon glyphicon-user', '#', 0, NULL, 1, 1),
(118, '后台用户信息管理', 'fa fa-circle', '/adminuser/adminuser/index', 117, NULL, 1, 2),
(119, '后台用户管理', '#', '/adminuser/adminuser/index', 117, NULL, 1, 2),
(120, '文章管理', 'glyphicon glyphicon-book', '#', 0, NULL, 1, 1),
(121, '分类管理 ', 'fa fa-circle', '/article/category/index', 120, NULL, 1, 2),
(122, '文章管理', 'fa fa-circle', '/article/article/index', 120, NULL, 1, 2),
(123, 'APP账户管理', 'glyphicon glyphicon-phone', '#', 0, 1, 1, 1),
(124, '用户信息管理', 'fa fa-circle', '/user/user/index', 123, 1, 1, 2),
(125, '订单管理', 'glyphicon glyphicon-barcode', '#', 0, 1, 1, 1),
(126, '订单管理', 'fa fa-circle', '/order/user-order/index', 125, NULL, 1, 2),
(127, '资金管理', 'glyphicon glyphicon-piggy-bank', '#', 0, 1, 1, 1),
(128, '充值管理', 'fa fa-circle', '/sale/sale-banktmp/index', 127, 1, 1, 2),
(129, '提现管理', 'fa fa-circle', '/sale/sale-getmoney/index', 127, 1, 1, 2),
(131, '流水管理', 'fa fa-circle', '/sale/sale-userpaylog/index', 127, 1, 1, 2),
(132, '商品管理', 'fa fa-qrcode', '#', 0, 1, 1, 1),
(133, '商品信息', 'fa fa-circle', '/good/good/index', 132, 1, 1, 2),
(134, '图片素材', 'fa fa-circle', '/good/good-imgs/index', 132, 1, 1, 2),
(135, '银行管理', 'fa fa-credit-card', '#', 0, 1, 1, 1),
(136, '银行列表', 'fa fa-circle', '/bank/bank/index', 135, 1, 1, 2),
(137, '银行卡管理', 'fa fa-circle', '/bank/card/index', 135, 1, 1, 2),
(138, '商品分类', 'fa fa-circle', '/good/good-category/index', 132, 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu_auth`
--

CREATE TABLE IF NOT EXISTS `tp_menu_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '名称',
  `rules` text COMMENT '规则',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='菜单权限分组表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `tp_menu_auth`
--

INSERT INTO `tp_menu_auth` (`id`, `name`, `rules`, `status`, `create_time`, `update_time`) VALUES
(1, '超级管理员', '1,2,116,117,120,123,125,127,132,135,3,12,91,118,121,122,124,126,128,129,131,133,136,137,138', 1, '2017-02-27 22:04:08', '2018-02-08 06:57:56');

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu_auth_user`
--

CREATE TABLE IF NOT EXISTS `tp_menu_auth_user` (
  `g_id` int(11) DEFAULT NULL COMMENT '组id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  KEY `g_id` (`g_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限与用户关系表';

--
-- 转存表中的数据 `tp_menu_auth_user`
--

INSERT INTO `tp_menu_auth_user` (`g_id`, `uid`) VALUES
(NULL, 10032),
(1, 10000);

-- --------------------------------------------------------

--
-- 表的结构 `tp_sale_banktmp`
--

CREATE TABLE IF NOT EXISTS `tp_sale_banktmp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `buit_id` tinyint(5) DEFAULT NULL COMMENT '充值交易类型（buit base_useriotype）',
  `buyer_id` varchar(50) DEFAULT NULL COMMENT '买家id',
  `buyer_logon_id` varchar(12) DEFAULT NULL COMMENT '买家帐号',
  `recharge_money` varchar(18) DEFAULT NULL COMMENT '充值金额',
  `service_money` varchar(18) DEFAULT '0.00' COMMENT '充值手续费',
  `receipt_amount` varchar(18) DEFAULT '0.00' COMMENT '实收金额',
  `order_no` varchar(40) DEFAULT NULL COMMENT '订单号',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '交易号',
  `subject` varchar(256) DEFAULT NULL COMMENT '订单标题',
  `body` varchar(400) DEFAULT NULL COMMENT '商品描述',
  `create_time` datetime DEFAULT NULL COMMENT '订单创建时间',
  `pay_time` datetime DEFAULT NULL COMMENT '付款时间',
  `notify_time` datetime DEFAULT NULL COMMENT '交易通知时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '充值状态(0 交易创建,等待支付;1 支付成功;2交易结束，不可退款,3未付款交易超时关闭)',
  `remarks` varchar(255) DEFAULT NULL COMMENT '充值描述',
  PRIMARY KEY (`id`),
  KEY `uid_idx` (`user_id`),
  KEY `payCode_idx` (`order_no`),
  KEY `status_idx` (`status`),
  KEY `user_id` (`user_id`),
  KEY `buit_id` (`buit_id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `buyer_logon_id` (`buyer_logon_id`),
  KEY `create_time` (`create_time`),
  KEY `pay_time` (`pay_time`),
  KEY `notify_time` (`notify_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='充值临时表-记录充值流水' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `tp_sale_banktmp`
--

INSERT INTO `tp_sale_banktmp` (`id`, `user_id`, `buit_id`, `buyer_id`, `buyer_logon_id`, `recharge_money`, `service_money`, `receipt_amount`, `order_no`, `trade_no`, `subject`, `body`, `create_time`, `pay_time`, `notify_time`, `status`, `remarks`) VALUES
(1, 16, 46, NULL, NULL, '10', '0.00', '0.00', 'CZ180547950334646', NULL, '会员充值', '会员充值', '2018-02-24 16:07:05', NULL, NULL, 0, NULL),
(2, 16, 46, NULL, NULL, '10', '0.00', '0.00', 'CZ180547398248361', NULL, '会员充值', '会员充值', '2018-02-24 16:07:45', NULL, NULL, 0, NULL),
(3, 16, 46, NULL, NULL, '10', '0.00', '0.00', 'CZ180548639082508', NULL, '会员充值', '会员充值', '2018-02-24 16:08:03', NULL, NULL, 0, NULL),
(8, 16, 47, NULL, NULL, '1', '0.00', '0.00', 'CZ180573748733453', NULL, NULL, '会员充值', '2018-02-27 16:16:05', NULL, NULL, 0, NULL),
(9, 16, 47, NULL, NULL, '1', '0.00', '0.00', 'CZ180571022446664', NULL, NULL, '会员充值', '2018-02-27 16:35:13', NULL, NULL, 0, NULL),
(10, 16, 47, NULL, NULL, '1', '0.00', '0.00', 'CZ180575952947079', NULL, NULL, '会员充值', '2018-02-27 16:46:51', NULL, NULL, 0, NULL),
(11, 16, 47, NULL, NULL, '1', '0.00', '0.00', 'CZ180572178928065', NULL, NULL, '会员充值', '2018-02-27 16:47:06', NULL, NULL, 0, NULL),
(12, 16, 47, NULL, NULL, '1', '0.00', '0.00', 'CZ180576694528400', NULL, NULL, '会员充值', '2018-02-27 16:47:58', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_sale_getmoney`
--

CREATE TABLE IF NOT EXISTS `tp_sale_getmoney` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '提款用户ID',
  `name` varchar(30) DEFAULT NULL COMMENT '提款用户名',
  `cash_no` varchar(30) DEFAULT NULL COMMENT '提款定单号',
  `cash_money` decimal(18,2) DEFAULT NULL COMMENT '提款金额',
  `case_service_money` decimal(18,2) DEFAULT '0.00' COMMENT '提款手续费',
  `cash_time` datetime DEFAULT NULL COMMENT '提款时间',
  `cash_type` tinyint(3) unsigned DEFAULT NULL COMMENT '提款类型  1银行卡  2支付宝',
  `cash_bank_id` tinyint(3) unsigned DEFAULT NULL,
  `cash_card` varchar(50) DEFAULT '' COMMENT '提款帐号 支付宝帐号 或者 银行卡号',
  `success_time` datetime DEFAULT NULL COMMENT '成功提款时间',
  `man_remarks` varchar(500) DEFAULT NULL COMMENT '管理员备注',
  `pay_username` varchar(50) NOT NULL COMMENT '打款人',
  `pay_type` tinyint(4) NOT NULL COMMENT '2 支付宝 1 银行卡',
  `pay_card` varchar(50) NOT NULL COMMENT '打款卡号',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='提现临时表-记录提现流水' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `tp_sale_getmoney`
--

INSERT INTO `tp_sale_getmoney` (`id`, `user_id`, `name`, `cash_no`, `cash_money`, `case_service_money`, `cash_time`, `cash_type`, `cash_bank_id`, `cash_card`, `success_time`, `man_remarks`, `pay_username`, `pay_type`, `pay_card`) VALUES
(1, 16, '周煜2', 'TX180438931896821', 111.00, 0.00, '2018-02-13 21:18:35', 1, 2, '12333081', NULL, NULL, '', 0, ''),
(4, 16, '周煜2', 'TX180439832078376', 111.00, 0.00, '2018-02-13 21:28:19', 2, 2, '12333081', NULL, NULL, '', 0, ''),
(6, 18, 'helloworld', 'TX180563243536810', 10.00, 0.00, '2018-02-26 15:22:10', 2, 7, '6214855741500975', NULL, NULL, '', 0, ''),
(7, 18, 'helloworld', 'TX180566055006250', 10.00, 0.00, '2018-02-26 15:23:25', 1, 1, 'dyc', NULL, NULL, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `tp_sale_userpaylog`
--

CREATE TABLE IF NOT EXISTS `tp_sale_userpaylog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户收入支出id',
  `type` int(10) NOT NULL COMMENT '0进帐 1出帐',
  `busisort` int(10) DEFAULT '0' COMMENT '大交易类型ID',
  `busino` int(10) DEFAULT NULL COMMENT '小交易类型ID',
  `pay_make_id` bigint(20) unsigned DEFAULT NULL COMMENT '触发该笔交易的ID',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `user_name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `order_id` varchar(50) DEFAULT NULL COMMENT '定单号',
  `pay_money` decimal(18,2) DEFAULT '0.00' COMMENT '定单金额',
  `pay_poundage` decimal(18,2) DEFAULT '0.00' COMMENT '定单手续费',
  `has_pay` decimal(18,2) DEFAULT NULL COMMENT '发生该笔定单后的帐户余额',
  `add_time` datetime DEFAULT NULL COMMENT '发生时间',
  `remarks` varchar(200) DEFAULT NULL COMMENT '定单说明',
  `admin_remarks` varchar(200) DEFAULT NULL COMMENT '管理员说明',
  `admin_name` varchar(30) DEFAULT NULL COMMENT '管理员名字',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 未成功 1已成功',
  PRIMARY KEY (`id`),
  KEY `inoutFlag_idx` (`type`),
  KEY `busisort_idx` (`busisort`),
  KEY `busIno_idx` (`busino`),
  KEY `payMarkId_idx` (`pay_make_id`),
  KEY `uid_idx` (`user_id`),
  KEY `userName_idx` (`user_name`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `remarks` (`remarks`),
  KEY `user_id_2` (`user_id`),
  KEY `type` (`type`),
  KEY `order_id_2` (`order_id`),
  KEY `user_id_3` (`user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户资金流水-记录用户收入,支出信息' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `tp_sale_userpaylog`
--

INSERT INTO `tp_sale_userpaylog` (`id`, `type`, `busisort`, `busino`, `pay_make_id`, `user_id`, `user_name`, `order_id`, `pay_money`, `pay_poundage`, `has_pay`, `add_time`, `remarks`, `admin_remarks`, `admin_name`, `status`) VALUES
(1, 1, 37, 39, 4, 16, '周煜2', 'TX180439832078376', 111.00, 0.00, 0.00, '2018-02-13 21:28:19', '', '', 'SYS', 1),
(2, 1, 19, 20, 2, 16, '周煜2', 'GC180530810605763', 299.00, 0.00, -299.00, '2018-02-23 16:44:04', 'GC180530810605763', '购彩订单编号：GC180530810605763', 'SYS', 0),
(3, 1, 19, 20, 3, 16, '周煜2', 'GC180537300978508', 299.00, 0.00, -299.00, '2018-02-23 16:52:46', 'GC180537300978508', '购彩订单编号：GC180537300978508', 'SYS', 0),
(4, 1, 19, 20, 4, 16, '周煜2', 'GC180538326036604', 299.00, 0.00, -299.00, '2018-02-23 16:52:59', 'GC180538326036604', '购彩订单编号：GC180538326036604', 'SYS', 0),
(5, 1, 19, 20, 5, 16, '周煜2', 'GC180535359972906', 299.00, 0.00, -299.00, '2018-02-23 16:53:28', 'GC180535359972906', '购彩订单编号：GC180535359972906', 'SYS', 0),
(6, 1, 19, 20, 6, 16, '周煜2', 'GC180535254315273', 299.00, 0.00, -298.99, '2018-02-23 16:54:04', 'GC180535254315273', '购彩订单编号：GC180535254315273', 'SYS', 0),
(7, 1, 19, 20, 7, 16, '周煜2', 'GC180533265675772', 299.00, 0.00, -298.99, '2018-02-23 16:58:54', 'GC180533265675772', '购彩订单编号：GC180533265675772', 'SYS', 0),
(8, 1, 19, 20, 8, 16, '周煜2', 'GC180530793807563', 299.00, 0.00, 1.00, '2018-02-23 16:59:03', 'GC180530793807563', '购彩订单编号：GC180530793807563', 'SYS', 0),
(9, 1, 19, 20, 9, 16, '周煜2', 'GC180539549966808', 299.00, 0.00, 1.00, '2018-02-23 16:59:12', 'GC180539549966808', '购彩订单编号：GC180539549966808', 'SYS', 1),
(10, 1, 19, 20, 10, 16, '周煜2', 'GC180534170347010', 299.00, 0.00, -298.00, '2018-02-23 17:09:33', 'GC180534170347010', '购彩订单编号：GC180534170347010', 'SYS', 0),
(11, 1, 19, 20, 11, 16, '周煜2', 'GC180536381023857', 299.00, 0.00, 1.00, '2018-02-23 17:09:55', 'GC180536381023857', '购彩订单编号：GC180536381023857', 'SYS', 1),
(12, 1, 19, 20, 12, 16, '周煜2', 'GC180534292641380', 299.00, 0.00, 2.00, '2018-02-23 17:36:34', 'GC180534292641380', '购彩订单编号：GC180534292641380', 'SYS', 1),
(13, 0, 23, 46, 23, 16, '周煜2', 'CZ180547950334646', 10.00, 0.00, 12.00, '2018-02-24 16:07:05', '', '', 'SYS', 0),
(14, 0, 23, 46, 23, 16, '周煜2', 'CZ180547398248361', 10.00, 0.00, 12.00, '2018-02-24 16:07:45', '', '', 'SYS', 0),
(15, 0, 23, 46, 23, 16, '周煜2', 'CZ180548639082508', 10.00, 0.00, 12.00, '2018-02-24 16:08:03', '', '', 'SYS', 0),
(16, 1, 37, 39, 6, 18, 'helloworld', 'TX180563243536810', 10.00, 0.00, 59989.00, '2018-02-26 15:22:10', '', '', 'SYS', 1),
(17, 1, 37, 39, 7, 18, 'helloworld', 'TX180566055006250', 10.00, 0.00, 59979.00, '2018-02-26 15:23:25', '', '', 'SYS', 1),
(18, 0, 23, 47, NULL, 16, '周煜2', 'CZ180575356250936', 1.00, 0.00, 3.00, '2018-02-27 16:06:04', '', '', 'SYS', 0),
(19, 0, 23, 47, NULL, 16, '周煜2', 'CZ180579254082366', 1.00, 0.00, 3.00, '2018-02-27 16:06:49', '', '', 'SYS', 0),
(20, 0, 23, 47, NULL, 16, '周煜2', 'CZ180577712776544', 1.00, 0.00, 3.00, '2018-02-27 16:07:03', '', '', 'SYS', 0),
(21, 0, 23, 47, NULL, 16, '周煜2', 'CZ180575310291992', 1.00, 0.00, 3.00, '2018-02-27 16:07:23', '', '', 'SYS', 0),
(22, 0, 23, 47, NULL, 16, '周煜2', 'CZ180573748733453', 1.00, 0.00, 3.00, '2018-02-27 16:16:05', '', '', 'SYS', 0),
(23, 0, 23, 47, NULL, 16, '周煜2', 'CZ180571022446664', 1.00, 0.00, 3.00, '2018-02-27 16:35:13', '', '', 'SYS', 0),
(24, 0, 23, 47, NULL, 16, '周煜2', 'CZ180575952947079', 1.00, 0.00, 3.00, '2018-02-27 16:46:51', '', '', 'SYS', 0),
(25, 0, 23, 47, NULL, 16, '周煜2', 'CZ180572178928065', 1.00, 0.00, 3.00, '2018-02-27 16:47:06', '', '', 'SYS', 0),
(26, 0, 23, 47, NULL, 16, '周煜2', 'CZ180576694528400', 1.00, 0.00, 3.00, '2018-02-27 16:47:58', '', '', 'SYS', 0),
(27, 1, 19, 20, 13, 18, '嘎嘎嘎', 'GC180596655265447', 299.00, 0.00, 59680.00, '2018-03-01 15:39:57', 'GC180596655265447', '购彩订单编号：GC180596655265447', 'SYS', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_token`
--

CREATE TABLE IF NOT EXISTS `tp_token` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'token主键',
  `token` varchar(48) NOT NULL COMMENT '用户凭证',
  `uid` int(11) NOT NULL COMMENT '用户编号',
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '登陆平台(0:未知,1:IOS,2:安卓,3:PC,4:手机)',
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='token表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `tp_token`
--

INSERT INTO `tp_token` (`id`, `token`, `uid`, `start_time`, `end_time`, `type`) VALUES
(6, 'cc7fefb1bee214e8086826756a878827', 3, '2017-07-03 01:49:18', '2017-07-04 01:49:18', 1),
(7, '2c76ae9c74c6b16dc82af316fd7521d1', 17, '2017-06-19 19:20:10', '2017-06-20 19:20:10', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE IF NOT EXISTS `tp_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL COMMENT '手机号，作为登录帐号',
  `name` varchar(15) NOT NULL COMMENT '用户名',
  `jpush` varchar(50) NOT NULL COMMENT '极光',
  `email` varchar(30) NOT NULL COMMENT '邮箱',
  `is_vest` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0普通用户 1内部用户',
  `head_img` varchar(250) NOT NULL COMMENT '头像连接',
  `passwd` varchar(100) NOT NULL COMMENT '登录密码',
  `pay_passwd` varchar(100) DEFAULT '' COMMENT '支付密码',
  `real_name` varchar(10) DEFAULT '' COMMENT '真实姓名',
  `card_code` varchar(25) DEFAULT '' COMMENT '身份证',
  `type` tinyint(3) unsigned NOT NULL COMMENT '1安卓 2苹果 3pc',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态:1 正常,2 锁定 3 注销',
  `use_money` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '可用资金(充值获得)',
  `cur_bonus` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '当前奖金(可体现)',
  `freez_money` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `token` varchar(255) DEFAULT '',
  `token_time` int(10) unsigned NOT NULL COMMENT '生成token时间，判断是否过期',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户主表' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `tp_user`
--

INSERT INTO `tp_user` (`id`, `phone`, `name`, `jpush`, `email`, `is_vest`, `head_img`, `passwd`, `pay_passwd`, `real_name`, `card_code`, `type`, `status`, `use_money`, `cur_bonus`, `freez_money`, `token`, `token_time`, `create_at`, `update_at`) VALUES
(16, '15726816329', '周煜2', '121', '22@11.com', 0, '/20180209/6b3b2e947a49a05800bca839bb743a33.png', '123123', '1', 'real_name', 'card_code', 0, 1, 0.00, 2.00, 111.00, 'PIVlcfGYbNxmVdpqbII3sannulDFZMlb', 1919868411, '2018-02-08 14:47:53', '2018-02-08 14:47:53'),
(18, '15755381833', '嘎嘎嘎', '', 'wwwaaa', 0, '/20180226/d9a117bbfa6524a95855060cba53f519.jpg', 'dc483e80a7a0bd9ef71d8cf973673924', '71b596cb42ee254f7416043d184fc970', 'dyc', '123456', 1, 1, 0.00, 59680.00, 20.00, 'm7N33wvJxSlCkWSfTvREDkMJxqopTWAv', 1520489050, '2018-02-24 15:00:09', '2018-02-24 15:00:09'),
(21, '17538507669', '王子', '', '', 0, '/20180228/e301a31101b33db488aee2d1b4b0fff8.png', '5abd06d6f6ef0e022e11b8a41f57ebda', '5abd06d6f6ef0e022e11b8a41f57ebda', 'wyq', '410381199208222537', 2, 1, 0.00, 2222.00, 0.00, 'n7RCMTQuRc72qvFpGX000fSmRWSns6cx', 1519869453, '2018-02-28 15:34:45', '2018-02-28 15:34:45');

-- --------------------------------------------------------

--
-- 表的结构 `tp_user_order`
--

CREATE TABLE IF NOT EXISTS `tp_user_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_code` varchar(50) DEFAULT NULL COMMENT '订单编号,供用户查找订单,如:DG201011261723520547',
  `order_status` tinyint(3) unsigned DEFAULT NULL COMMENT '0 订单未支付  1订单已支付 2订单已支付但超过订购时间，失效',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `amount_money` decimal(18,2) DEFAULT '0.00' COMMENT '订单总金额',
  `u_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户赚金额',
  `p_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台收取金额',
  `is_send` tinyint(4) NOT NULL COMMENT '是否发送商品信息(链接 密钥等)',
  `send_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid_index` (`user_id`),
  KEY `order_status` (`order_status`),
  KEY `order_code` (`order_code`),
  KEY `order_status_2` (`order_status`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `amount_money` (`amount_money`),
  KEY `amount_money_2` (`amount_money`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户订单表' AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `tp_user_order`
--

INSERT INTO `tp_user_order` (`id`, `order_code`, `order_status`, `user_id`, `good_id`, `amount_money`, `u_money`, `p_money`, `is_send`, `send_time`, `create_at`, `update_at`) VALUES
(1, 'GC180534054064299', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:24:48', '2018-02-23 16:24:48'),
(2, 'GC180530810605763', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:44:04', '2018-02-23 16:44:04'),
(3, 'GC180537300978508', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:52:46', '2018-02-23 16:52:46'),
(4, 'GC180538326036604', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:52:59', '2018-02-23 16:52:59'),
(5, 'GC180535359972906', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:53:28', '2018-02-23 16:53:28'),
(6, 'GC180535254315273', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:54:04', '2018-02-23 16:54:04'),
(7, 'GC180533265675772', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:58:54', '2018-02-23 16:58:54'),
(8, 'GC180530793807563', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:59:03', '2018-02-23 16:59:03'),
(9, 'GC180539549966808', 1, 16, 5, 299.00, 200.00, 99.00, 0, '2018-03-01 16:04:39', '2018-02-23 16:59:12', '2018-02-23 17:33:11'),
(10, 'GC180534170347010', 0, 16, 5, 299.00, 0.00, 0.00, 0, '2018-03-01 16:04:39', '2018-02-23 17:09:33', '2018-02-23 17:09:33'),
(11, 'GC180536381023857', 1, 16, 5, 299.00, 200.00, 99.00, 0, '2018-03-01 16:04:39', '2018-02-23 17:09:55', '2018-02-23 17:33:18'),
(12, 'GC180534292641380', 1, 16, 5, 299.00, 254.15, 44.85, 0, '2018-03-01 16:04:39', '2018-02-23 17:36:34', '2018-02-23 17:36:34'),
(13, 'GC180596655265447', 1, 18, 5, 299.00, 254.15, 44.85, 0, '2018-03-01 16:04:39', '2018-03-01 15:39:57', '2018-03-01 15:39:57');

--
-- 限制导出的表
--

--
-- 限制表 `tp_menu_auth_user`
--
ALTER TABLE `tp_menu_auth_user`
  ADD CONSTRAINT `tp_menu_auth_user_ibfk_2` FOREIGN KEY (`g_id`) REFERENCES `tp_menu_auth` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
