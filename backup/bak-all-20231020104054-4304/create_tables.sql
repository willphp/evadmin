-- 表的结构: wp_admin --
CREATE TABLE `wp_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '账户角色ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '账户',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `about` varchar(120) NOT NULL DEFAULT '' COMMENT '简介',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `qq` varchar(16) NOT NULL DEFAULT '' COMMENT 'QQ',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '登录IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';
-- <fen> --
-- 表的结构: wp_auth_group --
CREATE TABLE `wp_auth_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `about` varchar(120) NOT NULL DEFAULT '' COMMENT '描述',
  `auth` text NOT NULL COMMENT '权限规则',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';
-- <fen> --
-- 表的结构: wp_auth_rule --
CREATE TABLE `wp_auth_rule` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `auth` varchar(50) NOT NULL DEFAULT '' COMMENT '验证规则',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `target` varchar(20) NOT NULL DEFAULT '_iframe' COMMENT '打开方式',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0目录1菜单2节点',
  `level` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '层次',
  `path` varchar(250) NOT NULL DEFAULT '' COMMENT '路径',
  `sub_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '子计数',
  `tree_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '树计数',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁删',
  `model_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='节点菜单';
-- <fen> --
-- 表的结构: wp_dict --
CREATE TABLE `wp_dict` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '中文描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0用户1系统',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='数据字典';
-- <fen> --
-- 表的结构: wp_dict_data --
CREATE TABLE `wp_dict_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `dict_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '字典ID',
  `dict_name` varchar(50) NOT NULL DEFAULT '' COMMENT '字典名称',
  `label` varchar(50) NOT NULL DEFAULT '' COMMENT '标签',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '对应值',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `dict_id` (`dict_id`),
  KEY `dict_name` (`dict_name`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COMMENT='字典对应值';
-- <fen> --
-- 表的结构: wp_field --
CREATE TABLE `wp_field` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `dict_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字典名称',
  `field_title` varchar(20) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_type` varchar(20) NOT NULL DEFAULT 'varchar' COMMENT '字段类型',
  `field_length` varchar(10) NOT NULL DEFAULT '0' COMMENT '字段长度',
  `field_default` varchar(50) NOT NULL DEFAULT 'null' COMMENT '默认值',
  `field_comment` varchar(20) NOT NULL DEFAULT '' COMMENT '字段注释',
  `is_unsigned` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否正数',
  `is_required` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `is_autoinc` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自增',
  `is_primary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否主键',
  `at_list` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '列表显示',
  `at_add` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '添加显示',
  `at_edit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '修改显示',
  `is_search` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '字段查询',
  `search_exp` char(10) NOT NULL DEFAULT '=' COMMENT '查询方式',
  `list_tpl` varchar(250) NOT NULL DEFAULT '' COMMENT '列表模板',
  `form_type` varchar(20) NOT NULL DEFAULT 'text' COMMENT '表单类型',
  `input_title` varchar(20) NOT NULL DEFAULT '' COMMENT '表单标题',
  `input_default` varchar(50) NOT NULL DEFAULT '' COMMENT '表单默认',
  `input_verify` varchar(50) NOT NULL DEFAULT 'required' COMMENT '表单验证',
  `input_tip` varchar(100) NOT NULL DEFAULT '' COMMENT '表单提示(设置)',
  `bind_dict_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '绑定字典ID',
  `verify_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动验证',
  `verify_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `verify_msg` varchar(200) NOT NULL DEFAULT '' COMMENT '验证提示',
  `verify_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '验证条件',
  `verify_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '验证时机',
  `auto_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动处理',
  `auto_way` char(16) NOT NULL DEFAULT 'string' COMMENT '处理方式',
  `auto_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '处理规则',
  `auto_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '处理条件',
  `auto_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '处理时机',
  `filter_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动过滤',
  `filter_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '过滤条件',
  `filter_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '过滤时机',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1必须字段2ID字段',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='字段字典';
-- <fen> --
-- 表的结构: wp_image --
CREATE TABLE `wp_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属管理ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '上传者',
  `filename` varchar(50) NOT NULL DEFAULT '' COMMENT '文件名',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `mime` varchar(50) NOT NULL DEFAULT '' COMMENT 'mime类型',
  `ext` char(6) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COMMENT='图片附件';
-- <fen> --
-- 表的结构: wp_model --
CREATE TABLE `wp_model` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `model_title` varchar(20) NOT NULL DEFAULT '' COMMENT '模型标题',
  `table_name` varchar(20) NOT NULL DEFAULT '' COMMENT '表名',
  `table_prefix` varchar(10) NOT NULL DEFAULT '' COMMENT '表前缀',
  `table_comment` varchar(50) NOT NULL DEFAULT '' COMMENT '表注释',
  `table_engine` varchar(10) NOT NULL DEFAULT 'InnoDB' COMMENT '存储引擎',
  `table_charset` varchar(20) NOT NULL DEFAULT 'utf8mb4' COMMENT '字符集',
  `table_collate` varchar(50) NOT NULL DEFAULT 'utf8mb4_general_ci' COMMENT '排序规则',
  `table_primary` varchar(20) NOT NULL DEFAULT 'id' COMMENT '表主键',
  `list_order` varchar(50) NOT NULL DEFAULT 'id DESC' COMMENT '列表排序',
  `list_limit` smallint(5) unsigned NOT NULL DEFAULT '10' COMMENT '每页条数',
  `list_except` varchar(100) NOT NULL DEFAULT 'content' COMMENT '列表排除',
  `is_recycle` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启回收站',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='模型表';
-- <fen> --
-- 表的结构: wp_model_field --
CREATE TABLE `wp_model_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `model_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型ID',
  `field_title` varchar(20) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field_name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_type` varchar(20) NOT NULL DEFAULT 'varchar' COMMENT '字段类型',
  `field_length` varchar(10) NOT NULL DEFAULT '0' COMMENT '字段长度',
  `field_default` varchar(50) NOT NULL DEFAULT 'null' COMMENT '默认值',
  `field_comment` varchar(20) NOT NULL DEFAULT '' COMMENT '字段注释',
  `is_unsigned` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否正数',
  `is_required` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `is_autoinc` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自增',
  `is_primary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否主键',
  `at_list` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '列表显示',
  `at_add` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '添加显示',
  `at_edit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '修改显示',
  `is_search` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '字段查询',
  `search_exp` char(10) NOT NULL DEFAULT '=' COMMENT '查询方式',
  `list_tpl` varchar(250) NOT NULL DEFAULT '' COMMENT '列表模板',
  `form_type` varchar(20) NOT NULL DEFAULT 'text' COMMENT '表单类型',
  `input_title` varchar(20) NOT NULL DEFAULT '' COMMENT '表单标题',
  `input_default` varchar(50) NOT NULL DEFAULT '' COMMENT '表单默认',
  `input_verify` varchar(50) NOT NULL DEFAULT 'required' COMMENT '表单验证',
  `input_tip` varchar(100) NOT NULL DEFAULT '' COMMENT '表单提示(设置)',
  `bind_dict_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '绑定字典ID',
  `verify_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动验证',
  `verify_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `verify_msg` varchar(200) NOT NULL DEFAULT '' COMMENT '验证提示',
  `verify_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '验证条件',
  `verify_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '验证时机',
  `auto_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动处理',
  `auto_way` char(16) NOT NULL DEFAULT 'string' COMMENT '处理方式',
  `auto_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '处理规则',
  `auto_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '处理条件',
  `auto_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '处理时机',
  `filter_on` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自动过滤',
  `filter_at` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '过滤条件',
  `filter_in` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '过滤时机',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1必须字段2ID字段',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='模型字段';
-- <fen> --
