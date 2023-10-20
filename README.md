## EvAdmin

>一鱼PHP框架CURD快速开发平台

### 功能简介

1. 后台菜单管理(增删改查)
2. 账户管理(增删改查)
3. 角色管理(RBAC)
4. 系统字典，用户字典，如配性别选顶
5. 图库管理，上传，删除(编辑器和单图上传的图片都存入图库)
6. 数据库表优化，修复，备份，还原
7. 模型管理，可生成数据表，生成控制器，模型类，视图模板，菜单
8. 字段字典，可预自定义字段让模型生成数据表时选择。

### 环境要求

- PHP7.4.3~PHP8.2.x
- MySQL

### 技术构架

- WillPHP框架v4.6
- PearAdmin最新版（Layui2.8.6）

### 安装说明

1. 导入数据库 data_sql.sql （使用phpmyadmin等工具）
2. 数据库设置 .env文件（或config/database.php）
3. 设置URL重写规则
4. 管理账户：admin admin （全部权限）
5. 测试账户：test test （部分权限）

### URL重写

Apache环境规则`public/.htaccess`文件：

```
<IfModule mod_rewrite.c>
  Options +FollowSymlinks -Multiviews
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php? [L,E=PATH_INFO:$1]
</IfModule>
```

Nginx环境规则`public/nginx.htaccess`文件：

```
location / {
	if (!-e $request_filename) {
		rewrite  ^(.*)$  /index.php/$1  last;
	}
}
```

### 更新日志

EvAdmin v1.1.0 beta 2023-10-20：

1. 更新WillPHPv4.6
2. 修复密码修改失败
3. 窗口界面优化调整
4. 修复若干了BUG^_^

### 交流Q群

>QQ群1：325825297 QQ群2：16008861

### 技术支持

官网：[113344.com](http://www.113344.com) 无念(24203741@qq.com) 
