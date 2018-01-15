<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">附件管理</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a class="btn btn-default" href="/attach/add">上传附件</a></div>
              <div class="panel-body">
                  <div class="canvas-wrapper">
                      <table class="table table-striped table-hover table-bordered">
                                <tr><th>附件名</th><th>原名</th><th>大小</th><th>类型</th><th>创建时间</th><th>操作</th></tr>
                                <?php foreach ($list as $file): ?>
                                <tr>
                                  <td><a href="<?=site_url().$file->uri?>"><?=$file->new_name?></a></td>
                                  <td><?=$file->origin_name?></td>
                                  <td><?=$file->size?> KB</td>
                                  <td><?=$file->ext?></td>
                                  <td><?=date('Y-m-d H:i', $file->postdate)?></td>
                                  <td>
                                      <a href="javascript:void(0);" onclick="return confirm_delete(<?=$file->aid?>)">删除</a>
                                </tr>
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
  function confirm_delete(id)
  {
     if ( confirm('确定要删除吗？') )
     {
        window.location.href = "<?=site_url().'attach/del/'?>"+id;
     }
  }
  </script>
