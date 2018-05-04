**该应用基于 Codeigniter 3.0.6 框架开发, 是一个数据管理类后台, 支持内容模型和分类模型的自定义和扩展.**

支持后台建数据表(内容模型/分类模型), 表的字段配置对应mysql数据库字段, 表现形式上对应html各种标签; 基于RBAC权限管理, 可在最细颗粒度上对模型操作权限做控制;

在php7下运行的一个bug, session不会自动启动, 修改入口文件index.php, 加上session_start();

> 注意：在`application/core/MY_Model.php`, 用户定义的模型类不要继承`MY_Model`, 而是直接继承`CI_Model`, 因为`MY_Model`中, `$this->db->conn_id`尚未初始化;
