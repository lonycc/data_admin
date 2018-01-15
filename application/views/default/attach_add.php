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
          <div class="panel-heading">上传附件</div>
          <div class="panel-body">
            <?=form_open_multipart('attach/add')?>
              <div class="canvas-wrapper">
                  <div class="form-group">
                      <label>选择要上传的文件：</label><?php if ( isset($info) ): ?>
                      <span style="font-size:14px;color:green;">上传成功！</span>
                      <?php else: ?>
                      <span style="font-size:14px;color:red;display:inline;"><?=$error?></span>
                      <?php endif; ?>
                      <input type="file" name="attach" class="form-control" />
                  </div>
                  <div class="from-group">
                    说明：附件支持的格式doc|xls|jpg|png|gif|jpeg|apk。
                  </div>
                  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>提交</button>
              </div>
            <?=form_close()?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->
