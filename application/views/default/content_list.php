<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script src="/static/js/My97DatePicker/WdatePicker.js"></script>

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
            <a href="<?php echo backend_url('/content/form','model='.$model['name']); ?>" class="btn btn-default">录入</a>&nbsp;
            <a href="<?php echo backend_url('/content/import','model='.$model['name']); ?>" class="btn btn-default">导入</a>&nbsp;
            <a href="<?php echo backend_url('/content/export','model='.$model['name']); ?>" class="btn btn-default">导出</a>&nbsp;
            <?php if($model['searchable']) : ?>
            <a href="javascript:void(0)" onclick="return $('#myModal').modal();"  class="btn btn-default">筛选</a>
          <?php endif; ?>
          </div>
          <div class="panel-body">
            <?php echo form_open('/content/del?model='.$model['name'], array('id'=>'content_list_form')); ?>
              <div class="canvas-wrapper">
                <table class="table table-striped table-hover table-bordered">
                  <tr><th><input type="checkbox" onclick="formCheck(this, /id/);" />&nbsp;选择</th><th>添加时间</th><?php foreach($model['listable'] as $v): ?>
              <th><?php echo $model['fields'][$v]['description']; ?></th>
            <?php endforeach; ?><th>操作选项</th></tr>
            <?php foreach($provider['list'] as $v) : ?>
                  <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v->id; ?>" /></td>
                    <td><?php echo date('Y-m-d', $v->create_time); ?></td>
                    <?php foreach($model['listable'] as $vt): ?>
                    <td>
                    <?php $this->field_behavior->on_list($model['fields'][$vt], $v); ?>
                    </td>
                    <?php endforeach; ?>
                    <td>
                      <a href="<?php echo backend_url('/content/form/','model='.$model['name'].'&id='.$v->id); ?>">修改</a>
                        <a class="confirm_delete" href="<?php echo backend_url('/content/del','model='.$model['name'].'&id='.$v->id); ?>">删除</a>
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
    <?php echo form_open('/content/view?model='.$model['name']); ?>
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
          <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>搜索</button>
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
      if($(":checkbox[name='id[]']:checked").length  <= 0) {
          alert('请先选择要删除的信息!');
          return false;
      } else {
          if(confirm(confirm_str)) {
            $('#content_list_form').submit();
          } else {
            return false;
          }
      }
  }
  </script>
