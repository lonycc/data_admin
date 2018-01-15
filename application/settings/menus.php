<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$setting['menus']=array (
  0 => 
  array (
    'menu_id' => '1',
    'class_name' => 'index',
    'method_name' => 'index',
    'menu_name' => '系统',
    'sub_menus' => 
    array (
      0 => 
      array (
        'menu_id' => '2',
        'class_name' => 'index',
        'method_name' => 'index',
        'menu_name' => '首页',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '3',
            'class_name' => 'index',
            'method_name' => 'index',
            'menu_name' => '后台首页',
          ),
          1 => 
          array (
            'menu_id' => '4',
            'class_name' => 'index',
            'method_name' => 'cache',
            'menu_name' => '更新缓存',
          ),
          2 => 
          array (
            'menu_id' => '5',
            'class_name' => 'index',
            'method_name' => 'password',
            'menu_name' => '修改密码',
          ),
          3 => 
          array (
            'menu_id' => '6',
            'class_name' => 'index',
            'method_name' => 'log',
            'menu_name' => '操作日志',
          ),
          4 => 
          array (
            'menu_id' => '32',
            'class_name' => 'attach',
            'method_name' => 'view',
            'menu_name' => '附件管理',
          ),
        ),
      ),
      1 => 
      array (
        'menu_id' => '7',
        'class_name' => 'setting',
        'method_name' => 'site',
        'menu_name' => '系统设置',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '8',
            'class_name' => 'setting',
            'method_name' => 'site',
            'menu_name' => '站点设置',
          ),
          1 => 
          array (
            'menu_id' => '9',
            'class_name' => 'setting',
            'method_name' => 'backend',
            'menu_name' => '后台设置',
          ),
        ),
      ),
      2 => 
      array (
        'menu_id' => '15',
        'class_name' => 'model',
        'method_name' => 'view',
        'menu_name' => '模型管理',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '16',
            'class_name' => 'model',
            'method_name' => 'view',
            'menu_name' => '内容模型管理',
          ),
          1 => 
          array (
            'menu_id' => '17',
            'class_name' => 'category',
            'method_name' => 'view',
            'menu_name' => '分类模型管理',
          ),
        ),
      ),
      3 => 
      array (
        'menu_id' => '18',
        'class_name' => 'plugin',
        'method_name' => 'view',
        'menu_name' => '扩展管理',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '19',
            'class_name' => 'plugin',
            'method_name' => 'view',
            'menu_name' => '插件管理',
          ),
        ),
      ),
      4 => 
      array (
        'menu_id' => '20',
        'class_name' => 'role',
        'method_name' => 'view',
        'menu_name' => '权限管理',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '21',
            'class_name' => 'role',
            'method_name' => 'view',
            'menu_name' => '用户组管理',
          ),
          1 => 
          array (
            'menu_id' => '22',
            'class_name' => 'user',
            'method_name' => 'view',
            'menu_name' => '用户管理',
          ),
        ),
      ),
      5 => 
      array (
        'menu_id' => '27',
        'class_name' => 'database',
        'method_name' => 'index',
        'menu_name' => '数据库管理',
        'sub_menus' => 
        array (
          0 => 
          array (
            'menu_id' => '28',
            'class_name' => 'database',
            'method_name' => 'index',
            'menu_name' => '数据库备份',
          ),
          1 => 
          array (
            'menu_id' => '29',
            'class_name' => 'database',
            'method_name' => 'recover',
            'menu_name' => '数据库还原',
          ),
          2 => 
          array (
            'menu_id' => '30',
            'class_name' => 'database',
            'method_name' => 'optimize',
            'menu_name' => '数据库优化',
          ),
        ),
      ),
    ),
  ),
  1 => 
  array (
    'menu_id' => '23',
    'class_name' => 'content',
    'method_name' => 'view',
    'menu_name' => '内容管理',
    'sub_menus' => 
    array (
      0 => 
      array (
        'menu_id' => '24',
        'class_name' => 'content',
        'method_name' => 'view',
        'menu_name' => '内容管理',
        'sub_menus' => 
        array (
          0 => 
          array (
            'class_name' => 'content',
            'method_name' => 'view',
            'extra' => 'news',
            'menu_name' => '双创汇-新闻详情表',
          ),
          1 => 
          array (
            'class_name' => 'content',
            'method_name' => 'view',
            'extra' => 'authorization',
            'menu_name' => '接口授权信息表',
          ),
        ),
      ),
      1 => 
      array (
        'menu_id' => '25',
        'class_name' => 'category_content',
        'method_name' => 'view',
        'menu_name' => '分类管理',
        'sub_menus' => 
        array (
        ),
      ),
    ),
  ),
  2 => 
  array (
    'menu_id' => '26',
    'class_name' => 'module',
    'method_name' => 'run',
    'menu_name' => '插件',
    'sub_menus' => 
    array (
    ),
  ),
);