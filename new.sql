-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?02 �?23 �?06:07
-- 服务器版本: 5.5.53
-- PHP 版本: 5.5.38

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `new`
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
  `auth_key` char(32) DEFAULT NULL,
  `role` tinyint(2) DEFAULT NULL,
  `email` char(64) NOT NULL,
  `status` tinyint(2) DEFAULT '10',
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10026 ;

--
-- 转存表中的数据 `tp_adminuser`
--

INSERT INTO `tp_adminuser` (`id`, `username`, `password_hash`, `password_reset_token`, `auth_key`, `role`, `email`, `status`, `created_at`, `updated_at`) VALUES
(10000, 'admin', '$2y$13$gTnKxaJhPi6P6KBQ9NQCPe./aUiJ2Y7vboY1r9StRxft207My.ZAC', 'NYojJhDXGBJ5GXHNhUIWdc-swc6r-Wf__1488158311', 'rkHke3ruFO3TTGDA3QSY-eUYQlKU-QYQ', 10, 'admin@192.168.5.58', 10, 1518083148, 1518083148),
(10015, 'adminzwp', '$2y$13$ciRs7z3yvj80uMZvpQa0QexY7Imlf41Ve.wx33RPeXZlEXyKNtFNa', 'CFEyPKL2RfglClSrI3MDp687h0TgP4Vk_1518084062', 'Ao8sPXCSWkagT2OQ1eiup0si5O-QYrmN', 10, '747250175@qq.com', 10, 1518084152, 1518084152),
(10016, 'adminzwp112', '$2y$13$QtHgoqj5DaNWN1WMPCqPWuEhZ5bC3RKfvAUFUXDPpBTqxfPJeRJf6', 'khtHJW7g2tu-gQv0Q7rrZ7rojbfLYEfp_1518145160', '3xQ2wFf5wIL9Gate1KZhgAMJYZeUM675', 10, '747250175@qq.com', 0, 1518166937, 1518166937),
(10017, 'adminzwp113', '$2y$13$299D3lvDDHdAK1Hp.b7cheyrJvGNbAow1afxyVJdMDeKWSyxwPgFG', 'i0_ummi5Zn3Ba56jenAAB_3brjanxpc8_1518159427', 'f4XnjZtoyyMQeK64_kYJ8nGkCJzzbuuT', 10, '747250175@qq.com', 10, 1518159426, 1518159426),
(10022, 'adminzwp115', '$2y$13$0W4PmHxfqbfU7RUN1LTw..WpLyxS63yMGXOMmDXKxXI6yCkbjBtCe', '9wlRhk6VSE6w8VyKMg_8mVnKjFRLW6Mb_1518160356', 'CpOmt2CIjDM9-eO-OkeGMKriVplwJV9P', 10, '747250175@qq.com', 0, 1518407104, 1518407104),
(10023, 'adminzwp116', '$2y$13$oe34MsA.nO0Rf9lWATxQA.Z8CNsjMtNaILi2d1xvnnOPEqNarLz2G', 'F48iauSaNTAH2BMkjb9B_46y3K8vUFGR_1518166960', 'UTmGaBedmCeYzEl1FoWMjiQikFZo7Ie-', 10, '747250175@qq.com', 10, 1518166960, 1518166960),
(10024, 'adminzwp117', '$2y$13$QViOeEtMSdH9zxBpRNhZd.qpCtwJQvXZ1j6PiPjaNrVydjlG2GYLm', 'AWRAByN-spCfnnUFIDVMxJBQM7KZ3zTB_1518168237', 'Jyy8rVZz7HKUNt9RpbdyL8ZxEXELEmQy', 10, '747250175@qq.com', 10, 1518168236, 1518168236),
(10025, 'admin115', '$2y$13$QPP.zZmrpa.t8N20FVuiOeQqsWt.vCEYvgAHJvTrAaFZ9JMf9daAa', 'l006ae9yGJfuSa4_I-Mcwb4_6WWtruPP_1518170980', 'LE4p2iJ7MOrpVDxIvqsvtsCu5DqeV72A', 10, '747250175@qq.com', 10, 1518170979, 1518170979);

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
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `view` int(10) DEFAULT '1' COMMENT '查看量',
  `share` int(10) DEFAULT '1' COMMENT '分享数量',
  `art_img` varchar(255) DEFAULT NULL COMMENT '文章缩略图',
  `source` tinyint(1) DEFAULT '1' COMMENT '来源(0.外链，1.内部)',
  `type` tinyint(1) DEFAULT '1' COMMENT '是否可以分享(1.是,0.否)',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(1.开启，0.禁用)',
  `sort` tinyint(1) DEFAULT '1' COMMENT '排序',
  `cid` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '所属分类',
  `chani_url` varchar(255) DEFAULT '' COMMENT '外部链接(如果是转载，记录转载地址)',
  `con_url` varchar(255) DEFAULT '' COMMENT '生成的模板存储地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tp_article`
--

INSERT INTO `tp_article` (`id`, `title`, `abstract`, `content`, `auth`, `add_time`, `view`, `share`, `art_img`, `source`, `type`, `status`, `sort`, `cid`, `chani_url`, `con_url`) VALUES
(3, '看电视的快捷键爱上骷髅带 ', 'sdfsd', '<p>fsdfsdf</p><p><br/></p><p><br/></p><p><img src="http://www.order.com/image/frontend_15193553109690.jpg"/></p>', 'sdfsd', '2018-02-14 16:00:00', 1, 1, 'http://www.order.com/static/upload/image/20180222/1519292135.jpg', 1, 1, 1, 1, 1, '', ''),
(2, 'sdfs', 'sdfsddg', '<p>seefsdfs</p>', 'gjghj', '2018-02-07 16:00:00', 1, 1, 'http://www.order.com/static/upload/image/20180222/1519290800.jpg', 1, 1, 0, 1, 2, '', ''),
(4, '看的哈卡到静安寺', '啊实打实', '<p><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">阿萨德骄傲还是多看书看</span><br/></p>', '啊实打实', '2018-02-23 05:33:57', 1, 1, 'http://www.order.com/static/upload/image/20180223/1519364021.jpg', 1, 1, 1, 1, 1, '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `tp_category`
--

INSERT INTO `tp_category` (`id`, `name`, `sort`, `status`, `pid`, `position`, `model_sn`) VALUES
(1, '平台', 1, 1, 0, 'top', 1),
(2, '平台公告', 10, 0, 1, 'middle', 1),
(3, '平台新闻', 11, 1, 1, 'middle', 1),
(4, '支付', 2, 0, 0, 'middle', 1),
(5, '支付帮助', 20, 1, 4, 'middle', 1),
(6, '支付须知', 21, 1, 4, 'middle', 1),
(7, '注册', 3, 1, 0, 'top', 1),
(8, '注册协议', 30, 1, 7, 'middle', 1),
(9, '用户须知', 31, 1, 7, 'middle', 1),
(10, '购彩须知', 1, 1, 7, 'middle', 1),
(15, 'zddfsadfs', 1, 1, 1, 'top', 1);

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
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=431 ;

--
-- 转存表中的数据 `tp_log`
--

INSERT INTO `tp_log` (`id`, `userphone`, `ip`, `count`, `platform`, `create_time`) VALUES
(92, '15168230440', '100.97.54.4', 5, 2, '2017-07-07 09:05:09'),
(93, '13750846797', '100.97.168.64', 2, 2, '2017-07-07 09:49:11');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='标注表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `tp_lookup`
--

INSERT INTO `tp_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, '顶级', '1', 'menu-level', 1),
(2, '二级', '2', 'menu-level', 2),
(3, '三级', '3', 'menu-level', 3),
(4, '顶部', 'top', 'position', 1),
(5, '中间', 'middle', 'position', 2),
(6, '底部', 'bottom', 'position', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='菜单信息列表' AUTO_INCREMENT=123 ;

--
-- 转存表中的数据 `tp_menu`
--

INSERT INTO `tp_menu` (`id`, `label`, `icon`, `url`, `pid`, `sort`, `status`, `level`) VALUES
(1, '系统管理', 'glyphicon glyphicon-cog', '#', 0, 50, 1, 1),
(2, '导航栏管理', 'glyphicon glyphicon-menu-hamburger', '/menu/menu/index', 1, 100, 1, 1),
(3, '系统设置', 'glyphicon glyphicon-wrench', '/base/lookup/index', 1, 1, 1, 2),
(12, '权限配置', 'glyphicon glyphicon-lock', '/menu/menu-auth/index', 1, 50, 1, 2),
(91, '设置', '', '#', 98, NULL, 1, 2),
(116, '首页管理', 'glyphicon glyphicon-home', '/site/#', 0, 5000, 1, 1),
(117, '后台用户管理', 'glyphicon glyphicon-user', '#', 0, NULL, 1, 1),
(118, '后台用户信息管理', 'fa fa-circle', '/adminuser/adminuser/index', 117, NULL, 1, 2),
(120, '文章管理', 'glyphicon glyphicon-book', '#', 0, NULL, 1, 1),
(121, '分类管理 ', 'fa fa-circle', '/article/category/index', 120, NULL, 1, 2),
(122, '文章管理', 'fa fa-circle', '/article/article/index', 120, NULL, 1, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='菜单权限分组表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tp_menu_auth`
--

INSERT INTO `tp_menu_auth` (`id`, `name`, `rules`, `status`, `create_time`, `update_time`) VALUES
(1, '超级管理员', '1,2,116,117,120,3,12,91,118,121,122', 1, '2017-02-27 22:04:08', '2018-02-22 06:17:32');

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu_auth_user`
--

CREATE TABLE IF NOT EXISTS `tp_menu_auth_user` (
  `g_id` int(11) DEFAULT NULL COMMENT '组id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  UNIQUE KEY `uid_2` (`uid`),
  KEY `g_id` (`g_id`),
  KEY `uid` (`uid`),
  KEY `g_id_2` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限与用户关系表';

--
-- 转存表中的数据 `tp_menu_auth_user`
--

INSERT INTO `tp_menu_auth_user` (`g_id`, `uid`) VALUES
(1, 10000);

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
