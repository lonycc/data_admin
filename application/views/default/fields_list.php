<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <?=$bread?>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a class="btn btn-primary" href="<?php echo backend_url($this->uri->rsegment(1).'/add_field/'.$model->id); ?>">新增字段</a></div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <tr><th>顺序</th><th>标识</th><th>字段名</th><th>类型</th><th>管理</th></tr>
                  <?php $fieldtypes = array_merge(setting('fieldtypes'),setting('extra_fieldtypes')); ?>
                  <?php foreach($list as $v) : ?>
                  <tr><td><?php echo $v->order; ?></td><td><?php echo $v->name; ?></td><td><?php echo $v->description; ?></td><td><?php echo isset($fieldtypes[$v->type]) ? $fieldtypes[$v->type] : '未知'; ?></td><td><a href="<?php echo backend_url($this->uri->rsegment(1).'/edit_field/'.$v->id); ?>">修改</a>
                        <a class="confirm_delete" href="<?php echo backend_url($this->uri->rsegment(1).'/del_field/'.$v->id); ?>">删除</a></td></tr>
                  <?php endforeach; ?>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->
<script>
	$('a.confirm_delete').click(function(){
		return confirm('是否要删除所选字段？');
	});
</script>