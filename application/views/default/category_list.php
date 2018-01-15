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
          <div class="panel-heading"><a class="btn btn-primary" href="/category/add">新增分类模型</a></div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <tr><th>分类模型标识</th><th>分类模型名称</th><th>层级</th><th>操作选项</th></tr>
                  <?php foreach($list as $v) : ?>
                  <tr><td><?php echo $v->name; ?></td><td><?php echo $v->description; ?></td><td><?php echo $v->level; ?></td><td>                     <a href="<?php echo backend_url('category/edit/'.$v->id); ?>">修改</a>|
                        <a class="confirm_delete" href="<?php echo backend_url('category/del/'.$v->id); ?>">删除</a>|
                        <a href="<?php echo backend_url('category/fields/'.$v->id); ?>">字段管理</a>|
                        <a href="<?php echo backend_url('category_content/view/','model='.$v->name); ?>">列表</a></td></tr>
                  <?php endforeach; ?>
                </table>
                <?php echo $pagination; ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->

  <script>
  $('a.confirm_delete').click(function(){
    return confirm('是否要删除所选分类模型？');
  });
</script>