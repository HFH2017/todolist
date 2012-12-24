-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 24 日 18:24
-- 服务器版本: 5.0.90
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `2010wwll_todolist`
--

-- --------------------------------------------------------

--
-- 表的结构 `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `lid` int(11) NOT NULL auto_increment COMMENT '列表ID',
  `list_name` varchar(255) NOT NULL COMMENT '列表名称',
  `list_uid` int(11) NOT NULL COMMENT '列表所属用户id',
  `list_tasks_count` int(11) default '0' COMMENT '列表里任务数量',
  PRIMARY KEY  (`lid`),
  KEY `list_uid` (`list_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='列表信息' AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `tid` int(11) NOT NULL auto_increment COMMENT '任务id',
  `task_name` varchar(255) NOT NULL COMMENT '任务名称',
  `task_stared` tinyint(1) default '0' COMMENT '任务是否加星标',
  `task_finished` tinyint(1) default '0' COMMENT '任务是否已完成',
  `task_deadline` date default NULL COMMENT '任务截止时间',
  `task_ctime` datetime NOT NULL COMMENT '任务创建时间',
  `task_note` text COMMENT '任务附注',
  `task_lid` int(11) NOT NULL COMMENT '任务所属列表ID',
  `task_uid` int(11) NOT NULL COMMENT '任务所属用户id',
  PRIMARY KEY  (`tid`),
  KEY `task_uid` (`task_uid`),
  KEY `task_status` (`task_stared`,`task_finished`,`task_deadline`),
  KEY `task_lid` (`task_lid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='任务节点信息表' AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL auto_increment COMMENT '用户ID',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `user_password` varchar(50) NOT NULL COMMENT '用户密码（存放Hash值）',
  `user_email` varchar(100) NOT NULL COMMENT '用户邮件地址',
  `user_register_time` datetime NOT NULL COMMENT '用户注册时间',
  `user_default_lid` int(11) default NULL COMMENT '用户的默认列表的ID',
  `user_last_login` datetime default NULL COMMENT '最后登录时间',
  `user_status` int(11) default '10' COMMENT '用户状态值',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_mail` (`user_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息' AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
