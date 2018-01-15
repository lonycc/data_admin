<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li><a href="/role/view">用户组管理</a></li>
        <li class="active">新增用户组</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">新增用户组</div>
          <div class="panel-body">
            <?php echo form_open('/role/add'); ?>
            <div class="canvas-wrapper">
              <div class="form-group">
                <label>用户组名：</label><?php echo form_error('name'); ?>
                <input type="text" name="name" class="form-control" placeholder="3~20位标识" />
              </div>
              <div class="form-group">
                <label>允许的权限：</label>
                  <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /right/);" />&nbsp;选择</th><th>权限名称</th></tr>
                  <?php  foreach($rights as $key=>$v): ?>
                  <tr><td>
                  <input type="checkbox" value="<?php echo $key; ?>" name="right[]" /></td><td><?php echo $v; ?></td>
                  </tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的内容模型：</label>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /model/);" />&nbsp;选择</th><th>内容名称</th></tr>
                  <?php  foreach($models as $key=>$v): ?>
                  <tr><td>
                  <input type="checkbox" value="<?php echo $key; ?>" name="model[]" /></td><td><?php echo $v; ?></td></tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的分类模型：</label>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /category/);" />&nbsp;选择</th><th>分类名称</th></tr>
                  <?php  foreach($category_models as $key=>$v): ?>
                  <tr><td><input type="checkbox" value="<?php echo $key; ?>" name="category[]" /></td><td><?php echo $v; ?></td></tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的插件：</label>
                  <?php  foreach($plugins as $key=>$v): ?>
                  <input type="checkbox" value="<?php echo $key; ?>" name="right[]" /><?php echo $v; ?>
                  <?php endforeach; ?>
              </div>
              <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->