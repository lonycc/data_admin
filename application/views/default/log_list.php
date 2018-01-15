<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">操作日志</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">操作日志</div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <thead><tr><th>id</th><th>操作人</th><th>操作日期</th><th>操作内容</th></tr></thead>
                  <tbody>
                    <?php foreach($list as $v): ?>
                    <tr>
                      <td><?php echo $v->id; ?></td>
                      <td><?php echo $v->user; ?></td>
                      <td><?php echo date('Y-m-d H:i:s', $v->pdate); ?></td>
                      <td><?php echo $v->what; ?></td>
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