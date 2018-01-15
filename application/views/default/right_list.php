<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">权限管理</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a class="btn btn-primary" href="/right/add">新增</a></div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <thead><tr><th>权限名称</th><th>控制器名</th><th>方法名</th><th>附加方法名</th><th>操作选项</th></tr></thead>
                  <tbody>
                    <?php foreach($list as $v): ?>
                    <tr>
                      <td><?=$v->right_name?></td>
                      <td><?=$v->right_class?></td>
                      <td><?=$v->right_method?></td>
                      <td><?=$v->right_detail?></td>
                      <td>
                        <a title="修改" href="<?php echo '/right/edit/'.$v->right_id; ?>"><span class="glyphicon glyphicon-edit"></span></a>
                        <a title="删除" class="confirm_delete" href="<?php echo '/right/del/'.$v->right_id; ?>"><span class="glyphicon glyphicon-trash" ></span></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?php echo $pagination; ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->

<script language="javascript">
	$('a.confirm_delete').click(function(){
		return confirm('是否要删除所选权限？');
	});
</script>