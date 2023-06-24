-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-06-24 22:32:47
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `www_yiyuadmin_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `wp_admin`
--

CREATE TABLE `wp_admin` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `group_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '账户角色ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '账户',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `about` varchar(120) NOT NULL DEFAULT '' COMMENT '简介',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `qq` varchar(16) NOT NULL DEFAULT '' COMMENT 'QQ',
  `login_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '登录IP',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

--
-- 转存表中的数据 `wp_admin`
--

INSERT INTO `wp_admin` (`id`, `group_id`, `username`, `password`, `nickname`, `about`, `avatar`, `email`, `mobile`, `qq`, `login_count`, `login_time`, `login_ip`, `create_time`, `status`) VALUES
(1, 1, 'admin', 'a24676a269f6bfa53827470c4ea8cf24', '无念', 'PHP是世界上最好的语言', '/uploads/avatar/uid_1.png', '24203741@qq.com', '15877778888', '24203741', 15, 1687614077, 2130706433, 1686839079, 1),
(2, 2, 'test', '87ae5694eb98e31fb40af6e5d5cb2d64', '测试', '用于测试', '/uploads/avatar/uid_2.png', '', '', '', 1, 1687166169, 2130706433, 1687133115, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_auth_group`
--

CREATE TABLE `wp_auth_group` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `about` varchar(120) NOT NULL DEFAULT '' COMMENT '描述',
  `auth` text NOT NULL COMMENT '权限规则',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

--
-- 转存表中的数据 `wp_auth_group`
--

INSERT INTO `wp_auth_group` (`id`, `name`, `about`, `auth`, `update_time`, `create_time`, `status`) VALUES
(1, '管理组', '系统管理', '2,3,4,5,6,7,8,9,13,14,16,17,10,11,12,18', 1687617067, 1686976240, 1),
(2, '测试组', '用户测试', '2,7,8,13,14,10,11,12,18', 1687617049, 1687073634, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_auth_rule`
--

CREATE TABLE `wp_auth_rule` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `pid` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `auth` varchar(50) NOT NULL DEFAULT '' COMMENT '验证规则',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `target` varchar(20) NOT NULL DEFAULT '_iframe' COMMENT '打开方式',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0目录1菜单2节点',
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '层次',
  `path` varchar(250) NOT NULL DEFAULT '' COMMENT '路径',
  `sub_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '子计数',
  `tree_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '树计数',
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否禁删',
  `model_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属模型ID',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='节点菜单';

--
-- 转存表中的数据 `wp_auth_rule`
--

INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES
(1, 0, '=根目录=', 'layui-icon-tree', 'root', '', '_iframe', 0, 0, ',', 0, 0, 1, 0, 0, 1),
(2, 1, '首页', 'layui-icon-home', 'index/home', 'index/home', '_iframe', 1, 1, ',1,', 0, 0, 1, 0, 1, 1),
(3, 1, '权限', 'layui-icon-share', 'auth', '', '_iframe', 0, 1, ',1,', 0, 0, 1, 0, 1, 1),
(4, 3, '菜单管理', 'layui-icon-face-smile-fine', 'auth/index', 'auth/index', '_iframe', 1, 2, ',1,3,', 0, 0, 1, 0, 1, 1),
(5, 3, '账户管理', 'layui-icon-face-smile-fine', 'admin/index', 'admin/index', '_iframe', 1, 2, ',1,3,', 0, 0, 1, 0, 1, 1),
(6, 3, '角色管理', 'layui-icon-face-smile-fine', 'group/index', 'group/index', '_iframe', 1, 2, ',1,3,', 0, 0, 1, 0, 1, 1),
(7, 1, '字典', 'layui-icon-website', 'dict', '', '_iframe', 0, 1, ',1,', 0, 0, 1, 0, 1, 1),
(8, 7, '用户字典', 'layui-icon-face-smile-fine', 'dict/index', 'dict/index', '_iframe', 1, 2, ',1,7,', 0, 0, 1, 0, 1, 1),
(9, 7, '系统字典', 'layui-icon-face-smile-fine', 'dict/index', 'dict/index?type=1', '_iframe', 1, 2, ',1,7,', 0, 0, 1, 0, 1, 1),
(10, 1, '模型', 'layui-icon-template-1', 'model', '', '_iframe', 0, 1, ',1,', 0, 0, 1, 0, 2, 1),
(11, 10, '模型管理', 'layui-icon-face-smile-fine', 'model/index', 'model/index', '_iframe', 1, 2, ',1,10,', 0, 0, 1, 0, 1, 1),
(12, 10, '字段字典', 'layui-icon-face-smile-fine', 'field/index', 'field/index', '_iframe', 1, 2, ',1,10,', 0, 0, 1, 0, 1, 1),
(13, 1, '数据', 'layui-icon-component', '', '', '_iframe', 0, 1, ',1,', 0, 0, 0, 0, 1, 1),
(14, 13, '图片附件', 'layui-icon-face-smile-fine', 'image/index', 'image/index', '_iframe', 1, 2, ',1,13,', 0, 0, 0, 0, 1, 1),
(16, 13, '数据备份', 'layui-icon-face-smile-fine', 'database/index', 'database/index', '_iframe', 1, 2, ',1,13,', 0, 0, 0, 0, 1, 1),
(17, 13, '数据恢复', 'layui-icon-face-smile-fine', 'database/restore', 'database/restore', '_iframe', 1, 2, ',1,13,', 0, 0, 0, 0, 1, 1),
(18, 1, '博客', 'layui-icon-face-smile-fine', 'blog/index', 'blog/index', '_iframe', 1, 1, ',1,', 0, 0, 0, 2, 50, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_blog`
--

CREATE TABLE `wp_blog` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '封面图',
  `tag_ids` varchar(200) NOT NULL DEFAULT '' COMMENT '标签',
  `content` text NOT NULL COMMENT '内容',
  `is_top` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '置顶',
  `post_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发布时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='博客表';

-- --------------------------------------------------------

--
-- 表的结构 `wp_dict`
--

CREATE TABLE `wp_dict` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '中文描述',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0用户1系统',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='数据字典';

--
-- 转存表中的数据 `wp_dict`
--

INSERT INTO `wp_dict` (`id`, `name`, `title`, `type`, `sort`, `status`) VALUES
(1, 'field_type', '字段类型', 1, 1, 1),
(2, 'form_type', '表单类型', 1, 1, 1),
(3, 'form_verify', '表单验证', 1, 1, 1),
(4, 'user_sex', '性别', 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_dict_data`
--

CREATE TABLE `wp_dict_data` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `dict_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '字典ID',
  `dict_name` varchar(50) NOT NULL DEFAULT '' COMMENT '字典名称',
  `label` varchar(50) NOT NULL DEFAULT '' COMMENT '标签',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '对应值',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='字典对应值';

--
-- 转存表中的数据 `wp_dict_data`
--

INSERT INTO `wp_dict_data` (`id`, `dict_id`, `dict_name`, `label`, `value`, `sort`, `status`) VALUES
(1, 1, 'field_type', 'varchar', 'varchar', 1, 1),
(2, 1, 'field_type', 'int', 'int', 1, 1),
(3, 1, 'field_type', 'tinyint', 'tinyint', 1, 1),
(4, 1, 'field_type', 'smallint', 'smallint', 1, 1),
(5, 1, 'field_type', 'mediumint', 'mediumint', 1, 1),
(6, 1, 'field_type', 'bigint', 'bigint', 1, 1),
(7, 1, 'field_type', 'decimal', 'decimal', 1, 1),
(8, 1, 'field_type', 'char', 'char', 1, 1),
(9, 1, 'field_type', 'text', 'text', 1, 1),
(10, 1, 'field_type', 'tinytext', 'tinytext', 1, 1),
(11, 1, 'field_type', 'mediumtext', 'mediumtext', 1, 1),
(12, 1, 'field_type', 'longtext', 'longtext', 1, 1),
(13, 2, 'form_type', '文本框', 'text', 1, 1),
(14, 2, 'form_type', '文本域', 'textarea', 1, 1),
(15, 2, 'form_type', '下拉框', 'select', 1, 1),
(16, 2, 'form_type', '单选框', 'radio', 1, 1),
(17, 2, 'form_type', '开关', 'switch', 1, 1),
(18, 2, 'form_type', '编辑器', 'editor', 1, 1),
(19, 2, 'form_type', '日期', 'date', 1, 1),
(20, 2, 'form_type', '日期时间', 'datetime', 1, 1),
(21, 2, 'form_type', '单图上传', 'image', 1, 1),
(22, 2, 'form_type', '多选框', 'selects', 1, 1),
(23, 3, 'form_verify', '可空', 'nullable', 1, 1),
(24, 3, 'form_verify', '必填', 'required', 1, 1),
(25, 3, 'form_verify', '手机号', 'phone', 1, 1),
(26, 3, 'form_verify', '邮箱', 'email', 1, 1),
(27, 3, 'form_verify', '网址', 'url', 1, 1),
(28, 3, 'form_verify', '数字', 'number', 1, 1),
(29, 3, 'form_verify', '日期', 'date', 1, 1),
(30, 3, 'form_verify', '身份证', 'identity', 1, 1),
(31, 4, 'user_sex', '男', '1', 1, 1),
(32, 4, 'user_sex', '女', '2', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_field`
--

CREATE TABLE `wp_field` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `dict_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字典名称',
  `field_title` varchar(20) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_type` varchar(20) NOT NULL DEFAULT 'varchar' COMMENT '字段类型',
  `field_length` varchar(10) NOT NULL DEFAULT '0' COMMENT '字段长度',
  `field_default` varchar(50) NOT NULL DEFAULT 'null' COMMENT '默认值',
  `field_comment` varchar(20) NOT NULL DEFAULT '' COMMENT '字段注释',
  `is_unsigned` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否正数',
  `is_required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否必填',
  `is_autoinc` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否自增',
  `is_primary` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否主键',
  `at_list` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '列表显示',
  `at_add` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '添加显示',
  `at_edit` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '修改显示',
  `is_search` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '字段查询',
  `search_exp` char(10) NOT NULL DEFAULT '=' COMMENT '查询方式',
  `list_tpl` varchar(250) NOT NULL DEFAULT '' COMMENT '列表模板',
  `form_type` varchar(20) NOT NULL DEFAULT 'text' COMMENT '表单类型',
  `input_title` varchar(20) NOT NULL DEFAULT '' COMMENT '表单标题',
  `input_default` varchar(50) NOT NULL DEFAULT '' COMMENT '表单默认',
  `input_verify` varchar(50) NOT NULL DEFAULT 'required' COMMENT '表单验证',
  `input_tip` varchar(100) NOT NULL DEFAULT '' COMMENT '表单提示(设置)',
  `bind_dict_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '绑定字典ID',
  `verify_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动验证',
  `verify_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `verify_msg` varchar(200) NOT NULL DEFAULT '' COMMENT '验证提示',
  `verify_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '验证条件',
  `verify_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '验证时机',
  `auto_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动处理',
  `auto_way` char(16) NOT NULL DEFAULT 'string' COMMENT '处理方式',
  `auto_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '处理规则',
  `auto_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '处理条件',
  `auto_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '处理时机',
  `filter_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动过滤',
  `filter_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '过滤条件',
  `filter_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '过滤时机',
  `level` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1必须字段2ID字段',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='字段字典';

--
-- 转存表中的数据 `wp_field`
--

INSERT INTO `wp_field` (`id`, `dict_name`, `field_title`, `field_name`, `field_type`, `field_length`, `field_default`, `field_comment`, `is_unsigned`, `is_required`, `is_autoinc`, `is_primary`, `at_list`, `at_add`, `at_edit`, `is_search`, `search_exp`, `list_tpl`, `form_type`, `input_title`, `input_default`, `input_verify`, `input_tip`, `bind_dict_id`, `verify_on`, `verify_rule`, `verify_msg`, `verify_at`, `verify_in`, `auto_on`, `auto_way`, `auto_rule`, `auto_at`, `auto_in`, `filter_on`, `filter_at`, `filter_in`, `level`, `sort`, `status`) VALUES
(1, 'ID11位', 'ID', 'id', 'int', '11', 'null', 'ID', 1, 1, 1, 1, 1, 0, 0, 0, '=', '', 'text', '', '', 'nullable', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 2, 1, 1),
(2, 'ID8位', 'ID', 'id', 'mediumint', '8', 'null', 'ID', 1, 1, 1, 1, 1, 0, 0, 0, '=', '', 'text', '', '', 'nullable', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 2, 2, 1),
(3, 'ID5位', 'ID', 'id', 'smallint', '5', 'null', 'ID', 1, 1, 1, 1, 1, 0, 0, 0, '=', '', 'text', '', '', 'nullable', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 2, 3, 1),
(4, '更新时间', '更新时间', 'update_time', 'int', '10', '0', '更新时间', 1, 1, 0, 0, 1, 0, 0, 0, '=', '{{layui.util.toDateString(d.update_time*1000, \'yyyy-MM-dd\')}}', 'datetime', '', '', 'required', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 900, 1),
(5, '创建时间', '创建时间', 'create_time', 'int', '10', '0', '创建时间', 1, 1, 0, 0, 1, 0, 0, 0, '=', '{{layui.util.toDateString(d.create_time*1000, \'yyyy-MM-dd\')}}', 'datetime', '', '', 'required', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 901, 1),
(6, '删除时间', '删除时间', 'delete_time', 'int', '10', '0', '删除时间', 1, 1, 0, 0, 0, 0, 0, 0, '=', '', 'datetime', '', '', 'required', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 1, 902, 1),
(7, '状态', '状态', 'status', 'tinyint', '1', '0', '状态', 1, 1, 0, 0, 1, 0, 0, 1, '=', '', 'switch', '状态', '', 'required', '停用|启用', 0, 0, '', '', 1, 1, 1, 'string', '1', 1, 2, 0, 1, 1, 1, 999, 1),
(8, '标题', '标题', 'title', 'varchar', '100', '', '标题', 0, 1, 0, 0, 1, 1, 1, 1, 'like', '', 'text', '标题', '', 'required', '请输入标题', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(9, '分类', '分类', 'category_id', 'smallint', '5', '0', '分类', 1, 1, 0, 0, 1, 1, 1, 1, '=', '', 'select', '分类', '1', 'required', '1=分类1|2=分类2|3=分类3', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(10, '内容', '内容', 'content', 'text', '0', 'null', '内容', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'editor', '内容', '', 'required', '请输入内容', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 51, 1),
(11, '发布时间', '发布时间', 'post_time', 'int', '10', '0', '发布时间', 1, 1, 0, 0, 1, 1, 1, 0, '=', '{{layui.util.toDateString(d.post_time*1000, \'yyyy-MM-dd HH:mm:ss\')}}', 'datetime', '发布', '', 'date', 'yyyy-MM-dd  HH:mm:ss', 0, 0, '', '', 1, 1, 1, 'function', 'strtotime', 1, 1, 0, 1, 1, 0, 899, 1),
(12, '封面', '封面', 'thumb', 'varchar', '100', '', '封面图', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'image', '封面', '', 'required', '请输入封面', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(13, '标签', '标签', 'tag_ids', 'varchar', '200', '', '标签', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'selects', '标签', '', 'required', '1=标签1|2=标签2|3=标签3|4=标签4|5=标签5', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(14, '置顶', '置顶', 'is_top', 'tinyint', '1', '0', '置顶', 1, 1, 0, 0, 1, 1, 1, 0, '=', '{{- d.is_top == 1 ? \'<span style=\"color:red\">是</span>\' : \'否\' }}', 'switch', '置顶', '', 'required', '否|是', 0, 0, '', '', 1, 1, 1, 'string', '0', 5, 1, 0, 1, 1, 0, 52, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_image`
--

CREATE TABLE `wp_image` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `admin_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属管理ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '上传者',
  `filename` varchar(50) NOT NULL DEFAULT '' COMMENT '文件名',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `mime` varchar(50) NOT NULL DEFAULT '' COMMENT 'mime类型',
  `ext` char(6) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `filesize` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='图片附件';

-- --------------------------------------------------------

--
-- 表的结构 `wp_model`
--

CREATE TABLE `wp_model` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `model_title` varchar(20) NOT NULL DEFAULT '' COMMENT '模型标题',
  `table_name` varchar(20) NOT NULL DEFAULT '' COMMENT '表名',
  `table_prefix` varchar(10) NOT NULL DEFAULT '' COMMENT '表前缀',
  `table_comment` varchar(50) NOT NULL DEFAULT '' COMMENT '表注释',
  `table_engine` varchar(10) NOT NULL DEFAULT 'InnoDB' COMMENT '存储引擎',
  `table_charset` varchar(20) NOT NULL DEFAULT 'utf8mb4' COMMENT '字符集',
  `table_collate` varchar(50) NOT NULL DEFAULT 'utf8mb4_general_ci' COMMENT '排序规则',
  `table_primary` varchar(20) NOT NULL DEFAULT 'id' COMMENT '表主键',
  `list_order` varchar(50) NOT NULL DEFAULT 'id DESC' COMMENT '列表排序',
  `list_limit` smallint(5) UNSIGNED NOT NULL DEFAULT '10' COMMENT '每页条数',
  `list_except` varchar(100) NOT NULL DEFAULT 'content' COMMENT '列表排除',
  `is_recycle` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '开启回收站',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模型表';

--
-- 转存表中的数据 `wp_model`
--

INSERT INTO `wp_model` (`id`, `model_title`, `table_name`, `table_prefix`, `table_comment`, `table_engine`, `table_charset`, `table_collate`, `table_primary`, `list_order`, `list_limit`, `list_except`, `is_recycle`, `update_time`, `create_time`, `status`) VALUES
(2, '博客', 'blog', 'wp_', '博客表', 'InnoDB', 'utf8mb4', 'utf8mb4_general_ci', 'id', 'id DESC', 10, 'content', 0, 1687614913, 1687614913, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wp_model_field`
--

CREATE TABLE `wp_model_field` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `model_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属模型ID',
  `field_title` varchar(20) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_type` varchar(20) NOT NULL DEFAULT 'varchar' COMMENT '字段类型',
  `field_length` varchar(10) NOT NULL DEFAULT '0' COMMENT '字段长度',
  `field_default` varchar(50) NOT NULL DEFAULT 'null' COMMENT '默认值',
  `field_comment` varchar(20) NOT NULL DEFAULT '' COMMENT '字段注释',
  `is_unsigned` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否正数',
  `is_required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否必填',
  `is_autoinc` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否自增',
  `is_primary` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否主键',
  `at_list` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '列表显示',
  `at_add` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '添加显示',
  `at_edit` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '修改显示',
  `is_search` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '字段查询',
  `search_exp` char(10) NOT NULL DEFAULT '=' COMMENT '查询方式',
  `list_tpl` varchar(250) NOT NULL DEFAULT '' COMMENT '列表模板',
  `form_type` varchar(20) NOT NULL DEFAULT 'text' COMMENT '表单类型',
  `input_title` varchar(20) NOT NULL DEFAULT '' COMMENT '表单标题',
  `input_default` varchar(50) NOT NULL DEFAULT '' COMMENT '表单默认',
  `input_verify` varchar(50) NOT NULL DEFAULT 'required' COMMENT '表单验证',
  `input_tip` varchar(100) NOT NULL DEFAULT '' COMMENT '表单提示(设置)',
  `bind_dict_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '绑定字典ID',
  `verify_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动验证',
  `verify_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `verify_msg` varchar(200) NOT NULL DEFAULT '' COMMENT '验证提示',
  `verify_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '验证条件',
  `verify_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '验证时机',
  `auto_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动处理',
  `auto_way` char(16) NOT NULL DEFAULT 'string' COMMENT '处理方式',
  `auto_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '处理规则',
  `auto_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '处理条件',
  `auto_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '处理时机',
  `filter_on` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '自动过滤',
  `filter_at` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '过滤条件',
  `filter_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '过滤时机',
  `level` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1必须字段2ID字段',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模型字段';

--
-- 转存表中的数据 `wp_model_field`
--

INSERT INTO `wp_model_field` (`id`, `model_id`, `field_title`, `field_name`, `field_type`, `field_length`, `field_default`, `field_comment`, `is_unsigned`, `is_required`, `is_autoinc`, `is_primary`, `at_list`, `at_add`, `at_edit`, `is_search`, `search_exp`, `list_tpl`, `form_type`, `input_title`, `input_default`, `input_verify`, `input_tip`, `bind_dict_id`, `verify_on`, `verify_rule`, `verify_msg`, `verify_at`, `verify_in`, `auto_on`, `auto_way`, `auto_rule`, `auto_at`, `auto_in`, `filter_on`, `filter_at`, `filter_in`, `level`, `sort`, `status`) VALUES
(11, 2, 'ID', 'id', 'int', '11', 'null', 'ID', 1, 1, 1, 1, 1, 0, 0, 0, '=', '', 'text', '', '', 'nullable', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 2, 1, 1),
(12, 2, '标题', 'title', 'varchar', '100', '', '标题', 0, 1, 0, 0, 1, 1, 1, 1, 'like', '', 'text', '标题', '', 'required', '请输入标题', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(13, 2, '分类', 'category_id', 'smallint', '5', '0', '分类', 1, 1, 0, 0, 1, 1, 1, 1, '=', '', 'select', '分类', '1', 'required', '1=分类1|2=分类2|3=分类3', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(14, 2, '封面', 'thumb', 'varchar', '100', '', '封面图', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'image', '封面', '', 'required', '请输入封面', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(15, 2, '标签', 'tag_ids', 'varchar', '200', '', '标签', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'selects', '标签', '', 'required', '1=标签1|2=标签2|3=标签3|4=标签4|5=标签5', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 50, 1),
(16, 2, '内容', 'content', 'text', '0', 'null', '内容', 0, 1, 0, 0, 0, 1, 1, 0, '=', '', 'editor', '内容', '', 'required', '请输入内容', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 51, 1),
(17, 2, '置顶', 'is_top', 'tinyint', '1', '0', '置顶', 1, 1, 0, 0, 1, 1, 1, 0, '=', '{{- d.is_top == 1 ? \'<span style=\"color:red\">是</span>\' : \'否\' }}', 'switch', '置顶', '', 'required', '否|是', 0, 0, '', '', 1, 1, 1, 'string', '0', 5, 1, 0, 1, 1, 0, 52, 1),
(18, 2, '发布时间', 'post_time', 'int', '10', '0', '发布时间', 1, 1, 0, 0, 1, 1, 1, 0, '=', '{{layui.util.toDateString(d.post_time*1000, \'yyyy-MM-dd HH:mm:ss\')}}', 'datetime', '发布', '', 'date', 'yyyy-MM-dd  HH:mm:ss', 0, 0, '', '', 1, 1, 1, 'function', 'strtotime', 1, 1, 0, 1, 1, 0, 899, 1),
(19, 2, '创建时间', 'create_time', 'int', '10', '0', '创建时间', 1, 1, 0, 0, 1, 0, 0, 0, '=', '{{layui.util.toDateString(d.create_time*1000, \'yyyy-MM-dd\')}}', 'datetime', '', '', 'required', '', 0, 0, '', '', 1, 1, 0, 'string', '', 1, 1, 0, 1, 1, 0, 901, 1),
(20, 2, '状态', 'status', 'tinyint', '1', '0', '状态', 1, 1, 0, 0, 1, 0, 0, 1, '=', '', 'switch', '状态', '', 'required', '停用|启用', 0, 0, '', '', 1, 1, 1, 'string', '1', 1, 2, 0, 1, 1, 1, 999, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `wp_admin`
--
ALTER TABLE `wp_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_auth_group`
--
ALTER TABLE `wp_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_auth_rule`
--
ALTER TABLE `wp_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- 表的索引 `wp_blog`
--
ALTER TABLE `wp_blog`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_dict`
--
ALTER TABLE `wp_dict`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_dict_data`
--
ALTER TABLE `wp_dict_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dict_id` (`dict_id`),
  ADD KEY `dict_name` (`dict_name`);

--
-- 表的索引 `wp_field`
--
ALTER TABLE `wp_field`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_image`
--
ALTER TABLE `wp_image`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_model`
--
ALTER TABLE `wp_model`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wp_model_field`
--
ALTER TABLE `wp_model_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id` (`model_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `wp_admin`
--
ALTER TABLE `wp_admin`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `wp_auth_group`
--
ALTER TABLE `wp_auth_group`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `wp_auth_rule`
--
ALTER TABLE `wp_auth_rule`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `wp_blog`
--
ALTER TABLE `wp_blog`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `wp_dict`
--
ALTER TABLE `wp_dict`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `wp_dict_data`
--
ALTER TABLE `wp_dict_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=33;

--
-- 使用表AUTO_INCREMENT `wp_field`
--
ALTER TABLE `wp_field`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `wp_image`
--
ALTER TABLE `wp_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `wp_model`
--
ALTER TABLE `wp_model`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `wp_model_field`
--
ALTER TABLE `wp_model_field`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
