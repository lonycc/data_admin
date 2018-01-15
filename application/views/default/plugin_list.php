<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li class="active">插件管理</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a class="btn btn-primary" href="/plugin/add">设计新插件</a></div>
          <div class="panel-body">
              <?php echo form_open('', array('id' => 'plugin_list_form')); ?>
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <tr>
                    <th><input type="checkbox" onclick="formCheck(this, /id/);" />&nbsp;选择</th>
                    <th>插件标识</th>
                    <th>插件名称</th>
                    <th>插件作者</th>
                    <th>是否启用</th>
                    <th>操作选项</th></tr>
                  <?php foreach($list as $v) : ?>
                    <tr>
                      <td><input type="checkbox" name="id[]" value="<?php echo $v->id;  ?>" /></td>
                      <td><?php echo $v->name; ?></td>
                     <td><?php echo $v->title; ?></td>
                     <td><?php echo $v->author; ?></td>
                     <td><?php echo $v->active ? '已启用' : '未启用' ; ?></td>
                     <td>
                      <?php if(file_exists(BASEPATH.'../plugins/'.$v->name).'/plugin_'.$v->name.'_install.xml'): ?>
                      <a href="<?php echo base_url().'plugins/'.$v->name.'/plugin_'.$v->name.'_install.xml'; ?>" target="_blank">下载</a>|
                        <?php endif; ?>
                      <a href="<?php echo backend_url('/plugin/edit/'.$v->id); ?>">修改</a>|
                        <a class="confirm_delete" href="<?php echo backend_url('/plugin/del').'?id='.$v->id; ?>">卸载</a>
                     </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
                <a class="btn btn-primary" onclick="operate_plugins('<?php echo backend_url('/plugin/active'); ?>');" href="javascript:void(0);"><span class="glyphicon glyphicon-ok" aria-hidden="true" href=""></span>启用</a>
                <a class="btn btn-primary" onclick="operate_plugins('<?php echo backend_url('/plugin/deactive'); ?>');" href="javascript:void(0);"><span class="glyphicon glyphicon-remove" aria-hidden="true" href=""></span>禁用</a>
                <a class="btn btn-primary" onclick="operate_plugins('<?php echo backend_url('/plugin/export'); ?>');" href="javascript:void(0);"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" href=""></span>导出</a>
                <a class="btn btn-primary" href="<?php echo backend_url('/plugin/import'); ?>"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true" href=""></span>导入</a>
              </div>
              <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->

<script>
  $('a.confirm_delete').click(function(){
    return confirm('是否要卸载所选插件？');
  });

  function selected_plugins() {
    if($(":checkbox[name='id[]']:checked").length  <= 0)  {
        alert('请先选择要操作的插件!');
        return false;
    }
    return true;
  }

  function operate_plugins(action) {
    if(selected_plugins()) {
        $('#plugin_list_form').attr('action',action).submit();
    }
    return false;
  }
</script>