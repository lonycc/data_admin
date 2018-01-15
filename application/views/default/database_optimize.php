<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li>数据库管理</li>
        <li class="active">数据库优化</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">数据库优化</div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                    <?php echo form_open('/database/optimize'); ?>
                        <div class="canvas-wrapper">
                            <table class="table table-striped table-hover table-bordered">
                                <tr><th>数据表</th><th>类型</th><th>记录数</th><th>数据</th><th>索引</th><th>碎片</th></tr>
                                <?php foreach ($tables as $table): ?>
                                  <tr>
                                      <?php foreach($table as $v): ?>
                                          <td><?php echo $v; ?></td>
                                      <?php endforeach; ?>
                                  </tr>
                                <?php endforeach; ?>
                                <tr><td colspan="6">碎片数据： <?php echo $total_size;?> KB（~<?php echo round($total_size / 1024, 2);?> MB）</td></tr>
                            </table>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>立即优化</button>
                        </div>
                        <?php echo form_close(); ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->