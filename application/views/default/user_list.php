<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">用户管理</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a class="btn btn-primary" href="/user/add">新增</a></div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <thead><tr><th>用户名</th><th>用户组</th><th>备注</th><th>状态</th><th>是否固定ip</th><th>常用ip</th><th>操作选项</th></tr></thead>
                  <tbody>
                    <?php foreach($list as $v): ?>
                    <tr>
                      <td><?=$v->username; ?></td>
                      <td><?=$v->name; ?></td>
                      <td><?=$v->realname; ?></td>
                      <td><?=$v->status == 1 ? '正常' : '冻结'; ?></td>
                      <td><?=$v->lock_ip == 1 ? '是' : '否'; ?></td>
                      <td><?=$v->ip; ?></td>
                      <td>
                        <a title="修改" href="<?='/user/edit/'.$v->uid; ?>"><span class="glyphicon glyphicon-edit"></span></a>
                        <a title="删除" class="confirm_delete" href="<?='/user/del/'.$v->uid; ?>"><span class="glyphicon glyphicon-trash" ></span></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?=$pagination; ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->

<script language="javascript">
	$('a.confirm_delete').click(function(){
		return confirm('是否要删除所选用户？');
	});
</script>