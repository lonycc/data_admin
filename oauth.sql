-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL COMMENT '获取资源的access_token',
  `client_id` varchar(80) NOT NULL COMMENT '开发者Appid',
  `user_id` varchar(255) DEFAULT NULL COMMENT '开发者用户id',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '认证的时间date("Y-m-d H:i:s")',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限容器',
  PRIMARY KEY (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `oauth_access_tokens` (`access_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('52c837c320ad59f0d1b61d192ab64ca9630216a6',	'testclient',	'xiaocao',	'2017-01-19 09:22:26',	'userinfo cloud file node'),
('62694614a5e89e49a8369170534de2e9aa7a881a',	'testclient',	'user',	'2017-01-19 09:01:44',	'userinfo cloud file node'),
('770da83679c7155994267b3bc850e46b0aeb2422',	'testclient',	'user',	'2017-01-19 08:53:39',	'userinfo'),
('7e4595fc9fb3cd44d14320b226957dd8b7b7e330',	'testclient',	'user',	'2017-01-19 08:54:06',	'userinfo');

DROP TABLE IF EXISTS `oauth_authorization_codes`;
CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL COMMENT '通过Authorization 获取到的code，用于获取access_token',
  `client_id` varchar(80) NOT NULL COMMENT '开发者Appid',
  `user_id` varchar(255) DEFAULT NULL COMMENT '开发者用户id',
  `redirect_uri` varchar(2000) DEFAULT NULL COMMENT '认证后跳转的url',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '认证的时间date("Y-m-d H:i:s")',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限容器',
  PRIMARY KEY (`authorization_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) NOT NULL COMMENT '开发者AppId',
  `client_secret` varchar(80) NOT NULL COMMENT '开发者AppSecret',
  `redirect_uri` varchar(2000) NOT NULL COMMENT '认证后跳转的url',
  `grant_types` varchar(80) DEFAULT NULL COMMENT '认证的方式，client_credentials、password、refresh_token、authorization_code、authorization_access_token',
  `scope` varchar(100) DEFAULT NULL COMMENT '权限容器',
  `user_id` varchar(80) DEFAULT NULL COMMENT '开发者用户id',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='开发者注册信息表';

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('client2',	'pass2',	'http://php/',	'authorization_code',	'file node userinfo cloud',	'xiaocao'),
('testclient',	'testpass',	'http://php/',	'client_credentials password authorization_code refresh_token',	'file node userinfo cloud',	'xiaocao');

DROP TABLE IF EXISTS `oauth_jwt`;
CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) NOT NULL COMMENT '开发者用户id',
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL COMMENT '更新access_token的token',
  `client_id` varchar(80) NOT NULL COMMENT '开发者AppId',
  `user_id` varchar(255) DEFAULT NULL COMMENT '开发者用户id',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '认证的时间date("Y-m-d H:i:s")',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限容器',
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='密码认证时候refresh_token表';

INSERT INTO `oauth_refresh_tokens` (`refresh_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('63fcf03c7f1ab7e85b4a78d70316cc3c236d120a',	'testclient',	'user',	'2017-02-02 07:53:40',	'userinfo'),
('9fbfec727ff793a0f1df95c7bea75bd9b7f6efae',	'testclient',	'user',	'2017-02-02 07:54:06',	'userinfo'),
('e1337078452996c7db24a1779864e2ac72001095',	'testclient',	'user',	'2017-02-02 08:01:44',	'userinfo cloud file node');

DROP TABLE IF EXISTS `oauth_scopes`;
CREATE TABLE `oauth_scopes` (
  `scope` text COMMENT '容器名字',
  `is_default` tinyint(1) DEFAULT NULL COMMENT '是否默认拥有，1=>是，0=>否'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='权限表';

INSERT INTO `oauth_scopes` (`scope`, `is_default`) VALUES
('userinfo',	1),
('file',	0),
('node',	0),
('cloud',	0),
('share',	0);

DROP TABLE IF EXISTS `oauth_users`;
CREATE TABLE `oauth_users` (
  `username` varchar(255) NOT NULL COMMENT '内部时候使用的认证用户名',
  `password` varchar(2000) DEFAULT NULL COMMENT '内部时候使用的认证用户密码',
  `first_name` varchar(255) DEFAULT NULL COMMENT '内部时候使用',
  `last_name` varchar(255) DEFAULT NULL COMMENT '内部时候使用',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='密码认证时候的用户表';

INSERT INTO `oauth_users` (`username`, `password`, `first_name`, `last_name`) VALUES
('user',	'pass',	'xiaocao',	'grasses'),
('username',	'password',	'xiaocao',	'grasses');

-- 2017-11-10 06:59:47
