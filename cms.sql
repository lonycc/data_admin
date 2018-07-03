-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `app_admins`;
CREATE TABLE `app_admins` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `realname` varchar(10) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(100) NOT NULL,
  `role` smallint(5) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=正常，2=冻结',
  `ip` varchar(100) DEFAULT NULL COMMENT '用户常用ip',
  `lock_ip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定ip',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `group` (`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_admins` (`uid`, `username`, `password`, `salt`, `realname`, `email`, `role`, `status`, `ip`, `lock_ip`) VALUES
(1,	'dataAdmin',	'12fda425f0j24wlfj204 ru024r fsdfqw4r2qf',	'5c734978df',	'超级管理员',	'admin@admin.com',	1,	1,	NULL,	0);

DROP TABLE IF EXISTS `app_attach`;
CREATE TABLE `app_attach` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `uid` smallint(3) NOT NULL COMMENT '上传者id',
  `ext` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '附件后缀名',
  `origin_name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '附件原名',
  `new_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '附件新名',
  `size` int(11) NOT NULL COMMENT '附件大小',
  `postdate` int(11) NOT NULL COMMENT '上传日期',
  `uri` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '路径',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='附件管理表';


DROP TABLE IF EXISTS `app_attachments`;
CREATE TABLE `app_attachments` (
  `aid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` smallint(10) NOT NULL DEFAULT '0',
  `model` mediumint(10) DEFAULT '0',
  `from` tinyint(1) DEFAULT '0' COMMENT '0:content model,1:cate model',
  `content` int(10) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `folder` varchar(15) DEFAULT NULL,
  `realname` varchar(50) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `image` tinyint(1) DEFAULT '0',
  `posttime` int(11) DEFAULT '0',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_backend_settings`;
CREATE TABLE `app_backend_settings` (
  `backend_theme` varchar(15) DEFAULT NULL,
  `backend_lang` varchar(10) DEFAULT NULL,
  `backend_root_access` tinyint(1) unsigned DEFAULT '1',
  `backend_access_point` varchar(20) DEFAULT 'admin',
  `backend_title` varchar(100) DEFAULT 'DiliCMS后台管理',
  `backend_logo` varchar(100) DEFAULT 'images/logo.gif',
  `plugin_dev_mode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `backend_http_auth_on` tinyint(1) DEFAULT '0',
  `backend_http_auth_user` varchar(40) DEFAULT NULL,
  `backend_http_auth_password` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_backend_settings` (`backend_theme`, `backend_lang`, `backend_root_access`, `backend_access_point`, `backend_title`, `backend_logo`, `plugin_dev_mode`, `backend_http_auth_on`, `backend_http_auth_user`, `backend_http_auth_password`) VALUES
('default',	'zh-cn',	1,	'',	'数据管理后台',	'images/logo.png',	0,	0,	'tony',	'meiyou');

DROP TABLE IF EXISTS `app_cate_fields`;
CREATE TABLE `app_cate_fields` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `model` smallint(10) unsigned DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `length` smallint(10) unsigned DEFAULT NULL,
  `values` tinytext,
  `width` smallint(10) DEFAULT NULL,
  `height` smallint(10) DEFAULT NULL,
  `rules` tinytext,
  `ruledescription` tinytext,
  `searchable` tinyint(1) unsigned DEFAULT NULL,
  `listable` tinyint(1) unsigned DEFAULT NULL,
  `order` int(5) unsigned DEFAULT NULL,
  `editable` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`model`),
  KEY `model` (`model`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_cate_models`;
CREATE TABLE `app_cate_models` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(40) NOT NULL,
  `perpage` varchar(2) NOT NULL,
  `level` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `hasattach` tinyint(1) NOT NULL DEFAULT '0',
  `built_in` tinyint(1) DEFAULT '0',
  `auto_update` tinyint(1) DEFAULT '0',
  `thumb_preferences` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_fieldtypes`;
CREATE TABLE `app_fieldtypes` (
  `k` varchar(20) NOT NULL,
  `v` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_fieldtypes` (`k`, `v`) VALUES
('int',	'整形(INT)'),
('float',	'浮点型(FLOAT)'),
('input',	'单行文本框(VARCHAR)'),
('textarea',	'文本区域(VARCHAR)'),
('select',	'下拉菜单(VARCHAR)'),
('select_from_model',	'下拉菜单(模型数据)(INT)'),
('linked_menu',	'联动下拉菜单(VARCHAR)'),
('radio',	'单选按钮(VARCHAR)'),
('radio_from_model',	'单选按钮(模型数据)(INT)'),
('checkbox',	'复选框(VARCHAR)'),
('checkbox_from_model',	'复选框(模型数据)(VARCHAR)'),
('wysiwyg',	'编辑器(TEXT)'),
('wysiwyg_basic',	'编辑器(简)(TEXT)'),
('datetime',	'日期时间(VARCHAR)'),
('content',	'内容模型调用(INT)'),
('colorpicker',	'颜色选择器(VARCHAR)'),
('thumbnail',	'缩略图(VARCHAR)'),
('file', '文件(VARCHAR)');

DROP TABLE IF EXISTS `app_log`;
CREATE TABLE `app_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `pdate` int(11) NOT NULL COMMENT '记录时间戳',
  `user` varchar(16) COLLATE utf8_bin NOT NULL COMMENT '用户',
  `what` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '操作内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户操作日志';


DROP TABLE IF EXISTS `app_menus`;
CREATE TABLE `app_menus` (
  `menu_id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(20) NOT NULL,
  `method_name` varchar(30) NOT NULL,
  `menu_name` varchar(20) NOT NULL,
  `menu_level` tinyint(2) unsigned DEFAULT '0',
  `menu_parent` tinyint(10) unsigned DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_menus` (`menu_id`, `class_name`, `method_name`, `menu_name`, `menu_level`, `menu_parent`) VALUES
(1,	'index',	'index',	'系统',	0,	0),
(2,	'',	'',	'首页',	1,	1),
(3,	'index',	'index',	'开始',	2,	2),
(4,	'index',	'cache',	'更新缓存',	2,	2),
(5,	'index',	'password',	'修改密码',	2,	2),
(6,	'index',	'log',	'操作日志',	2,	2),
(7,	'',	'',	'系统设置',	1,	1),
(8,	'setting',	'site',	'站点设置',	2,	7),
(9,	'setting',	'backend',	'后台设置',	2,	7),
(15,	'',	'',	'模型管理',	1,	1),
(16,	'model',	'view',	'内容模型管理',	2,	15),
(17,	'category',	'view',	'分类模型管理',	2,	15),
(18,	'plugin',	'view',	'扩展管理',	1,	1),
(19,	'plugin',	'view',	'插件管理',	2,	18),
(20,	'',	'',	'权限管理',	1,	1),
(21,	'role',	'view',	'用户组管理',	2,	20),
(22,	'user',	'view',	'用户管理',	2,	20),
(23,	'content',	'view',	'内容管理',	0,	0),
(24,	'content',	'view',	'内容管理',	1,	23),
(25,	'category_content',	'view',	'分类管理',	1,	23),
(26,	'module',	'run',	'插件',	0,	0),
(27,	'',	'',	'数据库管理',	1,	1),
(28,	'database',	'index',	'数据库备份',	2,	27),
(29,	'database',	'recover',	'数据库还原',	2,	27),
(30,	'database',	'optimize',	'数据库优化',	2,	27),
(32,	'attach',	'view',	'附件管理',	2,	2),
(33,	'right',	'view',	'权限管理',	2,	2),
(34,	'menu',	'view',	'菜单管理',	2,	2);

DROP TABLE IF EXISTS `app_models`;
CREATE TABLE `app_models` (
  `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `perpage` varchar(2) NOT NULL DEFAULT '10',
  `hasattach` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `built_in` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thumb_preferences` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_model_fields`;
CREATE TABLE `app_model_fields` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(40) NOT NULL,
  `model` smallint(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(20) DEFAULT NULL,
  `length` smallint(10) unsigned DEFAULT NULL,
  `values` tinytext NOT NULL,
  `width` smallint(10) unsigned NOT NULL,
  `height` smallint(10) unsigned NOT NULL,
  `rules` tinytext NOT NULL,
  `ruledescription` tinytext NOT NULL,
  `searchable` tinyint(1) unsigned NOT NULL,
  `listable` tinyint(1) unsigned NOT NULL,
  `order` int(5) unsigned DEFAULT NULL,
  `editable` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`model`),
  KEY `model` (`model`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_plugins`;
CREATE TABLE `app_plugins` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `version` varchar(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `author` varchar(20) NOT NULL,
  `link` varchar(100) NOT NULL,
  `copyrights` varchar(100) NOT NULL,
  `access` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_rights`;
CREATE TABLE `app_rights` (
  `right_id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `right_name` varchar(30) DEFAULT NULL,
  `right_class` varchar(30) DEFAULT NULL,
  `right_method` varchar(30) DEFAULT NULL,
  `right_detail` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_rights` (`right_id`, `right_name`, `right_class`, `right_method`, `right_detail`) VALUES
(1,	'密码修改',	'index',	'password',	NULL),
(2,	'更新缓存',	'index',	'cache',	NULL),
(3,	' 站点设置',	'setting',	'site',	NULL),
(4,	'后台设置',	'setting',	'backend',	NULL),
(5,	'插件管理[列表]',	'plugin',	'view',	NULL),
(6,	'添加插件',	'plugin',	'add',	NULL),
(7,	'修改插件',	'plugin',	'edit',	NULL),
(8,	'卸载插件',	'plugin',	'del',	NULL),
(9,	'导出插件',	'plugin',	'export',	NULL),
(10,	'导入插件',	'plugin',	'import',	NULL),
(11,	'激活插件',	'plugin',	'active',	NULL),
(12,	'禁用插件',	'plugin',	'deactive',	NULL),
(13,	'运行插件',	'module',	'run',	NULL),
(14,	'内容模型管理[列表]',	'model',	'view',	NULL),
(15,	'添加内容模型',	'model',	'add',	NULL),
(16,	'修改内容模型',	'model',	'edit',	NULL),
(17,	'删除内容模型',	'model',	'del',	NULL),
(18,	'内容模型字段管理[列表]',	'model',	'fields',	NULL),
(19,	'添加内容模型字段',	'model',	'add_filed',	''),
(20,	'修改内容模型字段',	'model',	'edit_field',	NULL),
(21,	'删除内容模型字段',	'model',	'del_field',	NULL),
(22,	'分类模型管理[列表]',	'category',	'view',	NULL),
(23,	'添加分类模型',	'category',	'add',	NULL),
(24,	'修改分类模型',	'category',	'edit',	NULL),
(25,	'删除分类模型',	'category',	'del',	NULL),
(26,	'分类模型字段管理[列表]',	'category',	'fields',	NULL),
(27,	'添加分类模型字段',	'category',	'add_filed',	NULL),
(28,	'修改分类模型字段',	'category',	'edit_field',	NULL),
(29,	'删除分类模型字段',	'category',	'del_field',	NULL),
(30,	'内容管理[列表]',	'content',	'view',	NULL),
(31,	'添加内容[表单]',	'content',	'form',	'add'),
(32,	'修改内容[表单]',	'content',	'form',	'edit'),
(33,	'添加内容[动作]',	'content',	'save',	'add'),
(34,	'修改内容[动作]',	'content',	'save',	'edit'),
(35,	'删除内容',	'content',	'del',	NULL),
(36,	'分类管理[列表]',	'category_content',	'view',	NULL),
(37,	'添加分类[表单]',	'category_content',	'form',	'add'),
(38,	'修改分类[表单]',	'category_content',	'form',	'edit'),
(39,	'添加分类[动作]',	'category_content',	'save',	'add'),
(40,	'修改分类[动作]',	'category_content',	'save',	'edit'),
(41,	'删除分类',	'category_content',	'del',	NULL),
(42,	'用户组管理[列表]',	'role',	'view',	NULL),
(43,	'添加用户组',	'role',	'add',	NULL),
(44,	'修改用户组',	'role',	'edit',	NULL),
(45,	'删除用户组',	'role',	'del',	NULL),
(46,	'用户管理[列表]',	'user',	'view',	NULL),
(47,	'添加用户',	'user',	'add',	NULL),
(48,	'修改用户',	'user',	'edit',	NULL),
(49,	'删除用户',	'user',	'del',	NULL),
(50,	'数据库备份',	'database',	'index',	NULL),
(51,	'数据库还原',	'database',	'recover',	NULL),
(52,	'数据库优化',	'database',	'optimize',	NULL),
(53,	'操作日志[查看]',	'log',	'view',	NULL),
(59,	'批量导入[表单]',	'content',	'import',	NULL),
(60,	'批量导入',	'content',	'importing',	NULL),
(61,	'表格下载[表单]',	'content',	'export',	NULL),
(62,	'后台首页',	'index',	'index',	NULL),
(63,	'表格下载[动作]',	'content',	'export',	'add'),
(64,	'批量导入[动作]',	'content',	'import',	'add'),
(66,	'附件列表',	'attach',	'view',	NULL),
(67,	'新增附件',	'attach',	'add',	NULL),
(68,	'删除附件',	'attach',	'del',	NULL);

DROP TABLE IF EXISTS `app_roles`;
CREATE TABLE `app_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `rights` varchar(255) NOT NULL,
  `models` varchar(255) NOT NULL,
  `category_models` varchar(255) NOT NULL,
  `plugins` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_roles` (`id`, `name`, `rights`, `models`, `category_models`, `plugins`) VALUES
(1,	'root',	'',	'',	'',	'');

DROP TABLE IF EXISTS `app_sessions`;
CREATE TABLE `app_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `app_site_settings`;
CREATE TABLE `app_site_settings` (
  `site_name` varchar(50) DEFAULT NULL,
  `site_domain` varchar(50) DEFAULT NULL,
  `site_logo` varchar(50) DEFAULT NULL,
  `site_icp` varchar(50) DEFAULT NULL,
  `site_terms` text,
  `site_stats` varchar(200) DEFAULT NULL,
  `site_footer` varchar(500) DEFAULT NULL,
  `site_status` tinyint(1) DEFAULT '1',
  `site_close_reason` varchar(200) DEFAULT NULL,
  `site_keyword` varchar(200) DEFAULT NULL,
  `site_description` varchar(200) DEFAULT NULL,
  `site_theme` varchar(20) DEFAULT NULL,
  `attachment_url` varchar(50) DEFAULT NULL,
  `attachment_dir` varchar(20) DEFAULT NULL,
  `attachment_type` varchar(50) DEFAULT NULL,
  `attachment_maxupload` varchar(20) DEFAULT NULL,
  `thumbs_preferences` varchar(500) DEFAULT '[]'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_site_settings` (`site_name`, `site_domain`, `site_logo`, `site_icp`, `site_terms`, `site_stats`, `site_footer`, `site_status`, `site_close_reason`, `site_keyword`, `site_description`, `site_theme`, `attachment_url`, `attachment_dir`, `attachment_type`, `attachment_maxupload`, `thumbs_preferences`) VALUES
('数据管理后台',	'http://domain.com/',	'',	'暂时不备案',	'欢迎使用该cms后台系统。',	'暂无统计代码',	'',	1,	'网站维护升级中......',	'后台, cms',	'数据管理后台系统',	'default',	'http://domain.com/attachments/',	'attachments',	'*.jpg;*.gif;*.png;*.doc;*.xls',	'4096',	'[]');

DROP TABLE IF EXISTS `app_throttles`;
CREATE TABLE `app_throttles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `app_validations`;
CREATE TABLE `app_validations` (
  `k` varchar(20) DEFAULT NULL,
  `v` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `app_validations` (`k`, `v`) VALUES
('required',	'必填'),
('valid_email',	'E-mail格式');

-- 2018-01-15 04:23:33
