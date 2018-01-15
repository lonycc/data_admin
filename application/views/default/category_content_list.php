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
          <div class="panel-heading">
            <a href="<?php echo backend_url('/category_content/form','model='.$model['name'].'&u_c_level='.$provider['where']['u_c_level']); ?>" class="btn btn-default">添加</a>&nbsp;
            <?php if($model['searchable']) : ?>
            <a href="javascript:void(0)" onclick="return $('#myModal').modal();"  class="btn btn-default">筛选</a>
            <?php endif; ?>&nbsp;
            <?php if($provider['next_level'] > 1): ?>
            <a class="btn btn-default" href="<?php echo backend_url('/category_content/view','model='.$model['name'].'&u_c_level='.($provider['parent'] ? $provider['parent']->parentid  : '0')); ?>">返回上一级</a>
            <?php endif; ?>
            <?php $this->plugin_manager->trigger('buttons'); ?>
          </div>
          <div class="panel-body">
            <?php echo form_open('/category_content/del?model='.$model['name'], array('id' => 'category_content_list_form')); ?>
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <tr><th><input type="checkbox" onclick="formCheck(this, /classid/);" />&nbsp;选择</th><?php foreach($model['listable'] as $v): ?>
              <th><?php echo $model['fields'][$v]['description']; ?></th>
            <?php endforeach; ?><th>操作选项</th></tr>

            <?php foreach($provider['list'] as $v) : ?>
                  <tr>
                    <td><input type="checkbox" name="classid[]" value="<?php echo $v->classid; ?>" /></td>
                    <?php foreach($model['listable'] as $vt): ?>
                    <td>
                    <?php $this->field_behavior->on_list($model['fields'][$vt],$v); ?>
                    </td>
                    <?php endforeach; ?>
                    <td>
                      <?php if( $provider['next_level'] < $model['level'] ): ?>
                          <a href="<?php echo backend_url('/category_content/view/','model='.$model['name'].'&u_c_level='.$v->classid); ?>">进入子分类</a>
                            <a href="<?php echo backend_url('/category_content/form/','model='.$model['name'].'&u_c_level='.$v->classid); ?>">添加</a>
                        <?php endif; ?>
                      <a href="<?php echo backend_url('category_content/form/','model='.$model['name'].'&id='.$v->classid); ?>">修改</a>
                        <a class="confirm_delete" href="<?php echo backend_url('/category_content/del','model='.$model['name'].'&classid='.$v->classid); ?>">删除</a>
                        <?php $this->plugin_manager->trigger('row_buttons', $v); ?>
                    </td>
                  </tr>
            <?php endforeach; ?>
                </table>
                <button type="button" id="btn_submit" class="btn btn-default" onclick="multi_delete();">批量删除</button>
              </div>
            <?php echo form_close(); ?>
            <?php echo $provider['pagination']; ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">内容筛选</h4>
        </div>
    <?php echo form_open('/category_content/view?model='.$model['name']); ?>
        <div class="modal-body">
      <?php foreach($model['searchable'] as $v): ?>
          <div class="form-group">
            <label><?php echo $model['fields'][$v]['description']; ?></label>
            <?php $this->field_behavior->on_search($model['fields'][$v],(isset($provider['where'][$model['fields'][$v]['name']]) ? $provider['where'][$model['fields'][$v]['name']] : '' )); ?>
          </div>
      <?php endforeach; ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭</button>
          <button type="submit" id="btn_submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>搜索</button>
        </div>
    <?php echo form_close(); ?>

      </div>
    </div>
</div>

  <script>
  var confirm_str = '是否要删除所选信息？\n此操作还会删除附件等关联信息!';
  $('a.confirm_delete').click(function(){
      return confirm(confirm_str);
  });
  function multi_delete()  {
      if($(":checkbox[name='classid[]']:checked").length  <= 0) {
          alert('请先选择要删除的信息!');
          return false;
      } else {
          if(confirm(confirm_str)) {
            $('#category_content_list_form').submit();
          } else {
            return false;
          }
      }
  }
  </script>
