<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">更新缓存</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">更新缓存</div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                    <?php echo form_open('/index/cache', array('id' => 'cache_form', 'name' => 'cache_form')); ?>
                        <div class="canvas-wrapper">
                            <table class="table table-striped table-hover table-bordered">
                                <tr><th><input type="checkbox" onclick="formCheck(this, /cache/);" />&nbsp;选择</th><th>缓存名称</th></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="model" /></td><td>内容模型缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="category" /></td><td>分类模型缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="menu" /></td><td>菜单缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="role" /></td><td>权限数据缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="site" /></td><td>站点设置缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="backend" /></td><td>后台设置缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="plugin" /></td><td>插件缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="fieldtypes" /></td><td>字段类型缓存</td></tr>
                                <tr><td><input type="checkbox" name="cache[]" value="data" /></td><td>数据库缓存</td></tr>
                            </table>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->