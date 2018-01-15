<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li>数据库管理</li>
        <li class="active">数据库备份</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">数据库备份</div>
          <div class="panel-body">
            <?php echo form_open('/database/export',  array('method' => 'get')); ?>
            <div class="canvas-wrapper">
              <div class="form-group">
                <label>备份类型：</label>
                <input type="radio" name="export_type" value="all" onclick="$('#customtable').hide();" checked> 备份全部表
                <input type="radio" name="export_type" value="custom" onclick="$('#customtable').show();"> 自定义备份
                <table class="table table-striped table-hover table-bordered" id="customtable" style="display:none;">
                <tr><th><input type="checkbox" onclick="formCheck(this, /tables/);" />&nbsp;选择</th><th>数据表名</th></tr>
                <?php if($tables): ?>
                <?php foreach($tables as $table): ?>
                <tr><td><input class="checkbox" type="checkbox" name="tables[]" value="<?php echo $table; ?>" ></td><td><?php echo $table; ?></td></tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </table>
              </div>
              <div class="form-group">
                    <label>备份文件名(.sql)：</label><?php echo form_error('filename'); ?>
                    <input class="form-control" placeholder="有意义的标识" type="text" name="filename" value="<?php echo date('YmdHis'); ?>" />
              </div>
              <div class="form-group">
                    <label>备份文件名：</label>
                    <input type="radio" name="is_compress" value="1"> zip压缩
                    <input type="radio" name="is_compress" value="0" checked> 不压缩
              </div>
              <div class="form-group">
                    <label>扩展方式插入：</label>
                    <input type="radio" name="is_extend_insert" value="1"> 是
                    <input type="radio" name="is_extend_insert" value="0" checked> 否
              </div>
              <div class="form-group">
                    <label>分卷大小(KB)：</label><?php echo form_error('filename'); ?>
                    <input class="form-control" placeholder="整数" type="text" name="volume_size" value="2048" />
              </div>
              <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->