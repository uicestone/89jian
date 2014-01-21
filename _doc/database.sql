-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-01-21 01:28:57
-- 服务器版本： 5.5.30-log
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `89jian`
--
CREATE DATABASE IF NOT EXISTS `89jian` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `89jian`;

-- --------------------------------------------------------

--
-- 表的结构 `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- 表的结构 `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `syscode` varchar(255) NOT NULL,
  `sysname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `company`
--

INSERT INTO `company` (`id`, `name`, `type`, `host`, `syscode`, `sysname`) VALUES
(1, '鲁班锁', '', 'sys.sh', 'LubanLock', '鲁班锁'),
(2, '八九间', '', 'www.89jian.com', '89jian', '八九间');

-- --------------------------------------------------------

--
-- 表的结构 `company_config`
--

CREATE TABLE IF NOT EXISTS `company_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company-key` (`company`,`key`),
  KEY `name` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `get` text NOT NULL,
  `post` text NOT NULL,
  `client` varchar(255) NOT NULL,
  `duration` float NOT NULL,
  `ip` char(15) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `nav`
--

CREATE TABLE IF NOT EXISTS `nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `params` text,
  `parent` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `order` (`order`),
  KEY `user` (`user`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `nav`
--

INSERT INTO `nav` (`id`, `user`, `name`, `params`, `parent`, `order`) VALUES
(1, NULL, 'HOME / 首页', '{"href":"/"}', NULL, 0),
(2, NULL, 'ABOUT US / 关于我们', '{"href":"/article/about-us"}', NULL, 0),
(3, NULL, 'INGREDIENT / 食材', '{"href":"/type/food"}', NULL, 0),
(4, NULL, 'SET MEAL / 套餐', '{"href":"/type/package"}', NULL, 0),
(5, NULL, 'LOGISTICS / 配送', '{"href":"/article/logistic"}', NULL, 0),
(6, NULL, 'MEMBER / 会员专区', '{"href":"/user"}', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `object`
--

CREATE TABLE IF NOT EXISTS `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `num` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `company` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_insert` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `company` (`company`),
  KEY `user` (`user`),
  KEY `time` (`time`),
  KEY `time_insert` (`time_insert`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `object`
--

INSERT INTO `object` (`id`, `type`, `num`, `name`, `company`, `user`, `time`, `time_insert`) VALUES
(1, '', '', 'root', 2, 1, '2014-01-20 13:10:30', '0000-00-00 00:00:00'),
(2, 'user', '', 'test', 2, 1, '2014-01-21 01:28:12', '0000-00-00 00:00:00'),
(3, 'package', '', 'A', 2, 1, '2014-01-20 08:13:31', '2014-01-19 16:00:00'),
(4, 'product', '', '赤谷米', 2, 1, '2014-01-20 08:29:49', '0000-00-00 00:00:00'),
(5, 'product', '', '稻田鱼米', 2, 1, '2014-01-20 08:30:27', '0000-00-00 00:00:00'),
(6, 'product', '', '木耳', 2, 1, '2014-01-20 08:31:02', '0000-00-00 00:00:00'),
(7, 'product', '', '花菇', 2, 1, '2014-01-20 08:31:02', '0000-00-00 00:00:00'),
(8, 'article', 'logistic', '物流配送', 2, 1, '2014-01-20 08:55:33', '0000-00-00 00:00:00'),
(9, 'order', '', 'A 4次', 2, 2, '2014-01-20 13:08:27', '0000-00-00 00:00:00'),
(11, 'meal', '', 'A', 2, 1, '2014-01-20 13:23:11', '0000-00-00 00:00:00'),
(12, 'meal', '', 'A', 2, 1, '2014-01-20 13:23:11', '0000-00-00 00:00:00'),
(13, 'meal', '', 'A', 2, 1, '2014-01-20 13:23:11', '0000-00-00 00:00:00'),
(14, 'meal', '', 'A', 2, 1, '2014-01-20 13:23:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `object_meta`
--

CREATE TABLE IF NOT EXISTS `object_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `comment` text,
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object-key-value` (`object`,`key`,`value`(255)),
  KEY `user` (`user`),
  KEY `time` (`time`),
  KEY `object` (`object`),
  KEY `value` (`value`(255)),
  KEY `key-value` (`key`,`value`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `object_meta`
--

INSERT INTO `object_meta` (`id`, `object`, `key`, `value`, `comment`, `user`, `time`) VALUES
(2, 3, '有效', '1', NULL, 1, '2014-01-20 08:37:46'),
(3, 3, '价格', '368', NULL, 1, '2014-01-20 08:37:49'),
(6, 6, '英文名称', 'FUNGUS', NULL, 1, '2014-01-20 08:32:04'),
(7, 5, '英文名称', 'FISH IN RICE FIELDS', NULL, 1, '2014-01-20 08:32:04'),
(8, 4, '英文名称', 'RED RICE', NULL, 1, '2014-01-20 08:32:49'),
(9, 7, '英文名称', 'MUSHROOM', NULL, 1, '2014-01-20 08:32:49'),
(10, 4, '缩略图', 'product1.jpg', NULL, 1, '2014-01-20 08:35:34'),
(11, 5, '缩略图', 'product2.jpg', NULL, 1, '2014-01-20 08:35:34'),
(12, 6, '缩略图', 'product3.jpg', NULL, 1, '2014-01-20 08:35:34'),
(13, 7, '缩略图', 'product4.jpg', NULL, 1, '2014-01-20 08:35:34'),
(14, 4, '首页推荐', '1', NULL, 1, '2014-01-20 08:37:24'),
(15, 5, '首页推荐', '1', NULL, 1, '2014-01-20 08:37:24'),
(16, 6, '首页推荐', '1', NULL, 1, '2014-01-20 08:37:24'),
(17, 7, '首页推荐', '1', NULL, 1, '2014-01-20 08:37:24'),
(21, 8, '内容', '我们的物流', NULL, 1, '2014-01-20 08:59:38'),
(22, 9, '次数', '4', NULL, 2, '2014-01-20 13:30:11'),
(23, 9, '是否卡片', '', NULL, 2, '2014-01-20 13:30:15'),
(24, 9, '首次送货日期', '2014-1-31', NULL, 2, '2014-01-20 13:30:19'),
(25, 9, '收货人', '陆秋石', NULL, 2, '2014-01-20 13:09:04'),
(26, 9, '联系电话', '13641926334', NULL, 2, '2014-01-20 13:09:04'),
(27, 9, '收货地址', '上海市宝山区韶山路348弄28号602室', NULL, 2, '2014-01-20 13:09:04'),
(28, 9, '邮编', '201907', NULL, 2, '2014-01-20 13:09:04'),
(29, 2, '收货人', '陆秋石', NULL, 2, '2014-01-20 13:09:04'),
(30, 2, '联系电话', '13641926334', NULL, 2, '2014-01-20 13:09:04'),
(31, 2, '收货地址', '上海市宝山区韶山路348弄28号602室', NULL, 2, '2014-01-20 13:09:04'),
(32, 2, '邮编', '201907', NULL, 2, '2014-01-20 13:09:04'),
(34, 11, '送货日期', '2014-01-31', NULL, 1, '2014-01-20 13:32:06'),
(35, 12, '送货日期', '2014-02-07', NULL, 1, '2014-01-20 13:32:06'),
(36, 13, '送货日期', '2014-02-14', NULL, 1, '2014-01-20 13:32:06'),
(37, 14, '送货日期', '2014-02-21', NULL, 1, '2014-01-20 13:32:06');

-- --------------------------------------------------------

--
-- 表的结构 `object_relationship`
--

CREATE TABLE IF NOT EXISTS `object_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `relative` int(11) NOT NULL,
  `relation` varchar(255) DEFAULT '',
  `is_on` tinyint(1) DEFAULT NULL,
  `num` varchar(255) NOT NULL DEFAULT '',
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `people-relative-relation-is_on` (`object`,`relative`,`relation`,`is_on`),
  KEY `user` (`user`),
  KEY `time` (`time`),
  KEY `relative` (`relative`),
  KEY `relation` (`relation`),
  KEY `num` (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `object_relationship`
--

INSERT INTO `object_relationship` (`id`, `object`, `relative`, `relation`, `is_on`, `num`, `user`, `time`) VALUES
(1, 9, 3, 'package', NULL, '', 2, '2014-01-20 13:08:27'),
(3, 11, 3, 'package', NULL, '', 1, '2014-01-20 13:23:11'),
(4, 11, 2, 'user', NULL, '', 1, '2014-01-20 13:23:11'),
(5, 11, 9, 'order', NULL, '', 1, '2014-01-20 13:23:11'),
(6, 12, 3, 'package', NULL, '', 1, '2014-01-20 13:23:11'),
(7, 12, 2, 'user', NULL, '', 1, '2014-01-20 13:23:11'),
(8, 12, 9, 'order', NULL, '', 1, '2014-01-20 13:23:11'),
(9, 13, 3, 'package', NULL, '', 1, '2014-01-20 13:23:11'),
(10, 13, 2, 'user', NULL, '', 1, '2014-01-20 13:23:11'),
(11, 13, 9, 'order', NULL, '', 1, '2014-01-20 13:23:11'),
(12, 14, 3, 'package', NULL, '', 1, '2014-01-20 13:23:11'),
(13, 14, 2, 'user', NULL, '', 1, '2014-01-20 13:23:11'),
(14, 14, 9, 'order', NULL, '', 1, '2014-01-20 13:23:11');

-- --------------------------------------------------------

--
-- 表的结构 `object_relationship_meta`
--

CREATE TABLE IF NOT EXISTS `object_relationship_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relationship` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relationship` (`relationship`,`key`),
  KEY `user` (`user`),
  KEY `time` (`time`),
  KEY `key-value` (`key`,`value`(255)),
  KEY `value` (`value`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `object_status`
--

CREATE TABLE IF NOT EXISTS `object_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `content` text,
  `comment` text,
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student` (`object`),
  KEY `date` (`date`),
  KEY `user` (`user`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `object_status`
--

INSERT INTO `object_status` (`id`, `object`, `name`, `date`, `content`, `comment`, `user`, `time`) VALUES
(1, 9, '下单', '2014-01-20 21:09:04', NULL, NULL, 2, '2014-01-20 13:09:04'),
(2, 9, '已确认', '2014-01-20 21:22:57', NULL, NULL, 1, '2014-01-20 13:22:57'),
(3, 9, '已确认', '2014-01-20 21:23:11', NULL, NULL, 1, '2014-01-20 13:23:11'),
(4, 9, '已确认', '2014-01-20 22:55:24', NULL, NULL, 1, '2014-01-20 14:55:24');

-- --------------------------------------------------------

--
-- 表的结构 `object_tag`
--

CREATE TABLE IF NOT EXISTS `object_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `tag_taxonomy` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object-tag_taxonomy` (`object`,`tag_taxonomy`),
  KEY `user` (`user`),
  KEY `time` (`time`),
  KEY `tag_taxonomy` (`tag_taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` char(32) NOT NULL,
  `ip_address` char(15) NOT NULL,
  `user_agent` char(255) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` char(255) NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tag_taxonomy`
--

CREATE TABLE IF NOT EXISTS `tag_taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` int(11) NOT NULL,
  `taxonomy` varchar(255) NOT NULL,
  `discription` text,
  `parent` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag-taxonomy` (`tag`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT '',
  `last_ip` char(15) NOT NULL DEFAULT '',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company`),
  UNIQUE KEY `email` (`email`),
  KEY `company` (`company`),
  KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `alias`, `password`, `group`, `last_ip`, `last_login`, `company`) VALUES
(1, 'root', NULL, NULL, '123', 'admin', '', '2014-01-20 13:10:06', 2),
(2, 'test', 'test@89jian.com', NULL, '123', '', '', '2014-01-21 01:28:07', 2);

-- --------------------------------------------------------

--
-- 表的结构 `user_config`
--

CREATE TABLE IF NOT EXISTS `user_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user-key` (`user`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user_config`
--

INSERT INTO `user_config` (`id`, `user`, `key`, `value`) VALUES
(1, 2, 'incompleted_order', '0');

--
-- 限制导出的表
--

--
-- 限制表 `company_config`
--
ALTER TABLE `company_config`
  ADD CONSTRAINT `company_config_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `nav`
--
ALTER TABLE `nav`
  ADD CONSTRAINT `nav_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `nav` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object`
--
ALTER TABLE `object`
  ADD CONSTRAINT `object_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `object_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object_meta`
--
ALTER TABLE `object_meta`
  ADD CONSTRAINT `object_meta_ibfk_1` FOREIGN KEY (`object`) REFERENCES `object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `object_meta_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object_relationship`
--
ALTER TABLE `object_relationship`
  ADD CONSTRAINT `object_relationship_ibfk_1` FOREIGN KEY (`object`) REFERENCES `object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `object_relationship_ibfk_2` FOREIGN KEY (`relative`) REFERENCES `object` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `object_relationship_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object_relationship_meta`
--
ALTER TABLE `object_relationship_meta`
  ADD CONSTRAINT `object_relationship_meta_ibfk_1` FOREIGN KEY (`relationship`) REFERENCES `object_relationship` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `object_relationship_meta_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object_status`
--
ALTER TABLE `object_status`
  ADD CONSTRAINT `object_status_ibfk_1` FOREIGN KEY (`object`) REFERENCES `object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `object_status_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `object_tag`
--
ALTER TABLE `object_tag`
  ADD CONSTRAINT `object_tag_ibfk_1` FOREIGN KEY (`object`) REFERENCES `object` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `object_tag_ibfk_2` FOREIGN KEY (`tag_taxonomy`) REFERENCES `tag_taxonomy` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `object_tag_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `tag_taxonomy`
--
ALTER TABLE `tag_taxonomy`
  ADD CONSTRAINT `tag_taxonomy_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id`) REFERENCES `object` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `user_config`
--
ALTER TABLE `user_config`
  ADD CONSTRAINT `user_config_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
