-- 表的数据: wp_auth_rule(1/1) 每页: 1000 --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('1', '0', '=根目录=', 'layui-icon-tree', 'root', '', '_iframe', '0', '0', ',', '0', '0', '1', '0', '0', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('2', '1', '首页', 'layui-icon-home', 'index/home', 'index/home', '_iframe', '1', '1', ',1,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('3', '1', '权限', 'layui-icon-share', 'auth', '', '_iframe', '0', '1', ',1,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('4', '3', '菜单管理', 'layui-icon-face-smile-fine', 'auth/index', 'auth/index', '_iframe', '1', '2', ',1,3,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('5', '3', '账户管理', 'layui-icon-face-smile-fine', 'admin/index', 'admin/index', '_iframe', '1', '2', ',1,3,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('6', '3', '角色管理', 'layui-icon-face-smile-fine', 'group/index', 'group/index', '_iframe', '1', '2', ',1,3,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('7', '1', '字典', 'layui-icon-website', 'dict', '', '_iframe', '0', '1', ',1,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('8', '7', '用户字典', 'layui-icon-face-smile-fine', 'dict/index', 'dict/index', '_iframe', '1', '2', ',1,7,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('9', '7', '系统字典', 'layui-icon-face-smile-fine', 'dict/index', 'dict/index?type=1', '_iframe', '1', '2', ',1,7,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('10', '1', '模型', 'layui-icon-template-1', 'model', '', '_iframe', '0', '1', ',1,', '0', '0', '1', '0', '2', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('11', '10', '模型管理', 'layui-icon-face-smile-fine', 'model/index', 'model/index', '_iframe', '1', '2', ',1,10,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('12', '10', '字段字典', 'layui-icon-face-smile-fine', 'field/index', 'field/index', '_iframe', '1', '2', ',1,10,', '0', '0', '1', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('13', '1', '数据', 'layui-icon-component', '', '', '_iframe', '0', '1', ',1,', '0', '0', '0', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('14', '13', '图片附件', 'layui-icon-face-smile-fine', 'image/index', 'image/index', '_iframe', '1', '2', ',1,13,', '0', '0', '0', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('16', '13', '数据备份', 'layui-icon-face-smile-fine', 'database/index', 'database/index', '_iframe', '1', '2', ',1,13,', '0', '0', '0', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('17', '13', '数据恢复', 'layui-icon-face-smile-fine', 'database/restore', 'database/restore', '_iframe', '1', '2', ',1,13,', '0', '0', '0', '0', '1', '1');-- <fen> --
INSERT INTO `wp_auth_rule` (`id`, `pid`, `title`, `icon`, `auth`, `href`, `target`, `type`, `level`, `path`, `sub_count`, `tree_count`, `is_system`, `model_id`, `sort`, `status`) VALUES ('18', '1', '博客', 'layui-icon-face-smile-fine', 'blog/index', 'blog/index', '_iframe', '1', '1', ',1,', '0', '0', '0', '2', '50', '1');-- <fen> --
