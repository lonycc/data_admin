<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li><a href="/role/view">用户组管理</a></li>
        <li class="active">用户组编辑</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">用户组编辑</div>
          <div class="panel-body">
            <?php echo form_open('/role/edit/'.$role->id); ?>
            <div class="canvas-wrapper">
              <div class="form-group">
                <label>用户组名：</label><?php echo form_error('name'); ?>
                <input type="text" name="name" class="form-control" placeholder="3~20位标识" value="<?php echo $role->name; ?>" />
              </div>
              <div class="form-group">
                <label>允许的权限：</label>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /right/);" />&nbsp;选择</th><th>权限名称</th></tr>
                  <?php
                  $role->rights = explode(',',$role->rights);
                  foreach($rights as $key=>$v): ?>
                  <tr><td><input type="checkbox" value="<?php echo $key; ?>" name="right[]" <?php echo in_array($key,$role->rights) ? 'checked="checked"' : ''; ?> /></td><td><?php echo $v; ?></td></tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的内容模型：</label>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /model/);" />&nbsp;选择</th><th>内容名称</th></tr>
                  <?php
                  $role->models = explode(',',$role->models);
                  foreach($models as $key=>$v): ?>
                  <tr><td><input type="checkbox" value="<?php echo $key; ?>" name="model[]" <?php echo in_array($key,$role->models) ? 'checked="checked"' : ''; ?> /></td><td><?php echo $v; ?></td></tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的分类模型：</label>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th><input type="checkbox" onclick="formCheck(this, /category/);" />&nbsp;选择</th><th>分类名称</th></tr>
                  <?php
                  $role->category_models = explode(',',$role->category_models);
                  foreach($category_models as $key=>$v): ?>
                  <tr><td><input type="checkbox" value="<?php echo $key; ?>" name="category[]" <?php echo in_array($key,$role->category_models) ? 'checked="checked"' : ''; ?> /></td><td><?php echo $v; ?></td></tr>
                  <?php endforeach; ?>
                  </table>
              </div>
              <div class="form-group">
                <label>允许的插件：</label>
                  <?php
                  $role->plugins = explode(',',$role->plugins);
                  foreach($plugins as $key=>$v): ?>
                  <input type="checkbox" value="<?php echo $key; ?>" name="right[]" <?php echo in_array($key,$role->plugins) ? 'checked="checked"' : ''; ?> /><?php echo $v; ?>&nbsp;&nbsp;
                  <?php endforeach; ?>
              </div>
              <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button><?php echo form_error('name', '<span>', '</span>'); ?>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->