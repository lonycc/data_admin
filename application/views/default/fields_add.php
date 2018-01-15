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
          <div class="panel-heading">新增字段</div>
          <div class="panel-body">
              <?php echo form_open($this->uri->rsegment(1).'/add_field/'.$model->id); ?>
              <div class="canvas-wrapper">
                   <div class="form-group">
                     <label>字段标识：</label><?php echo form_error('name'); ?>
                     <input type="text" name="name" class="form-control" placeholder="3~20位字母数字或下划线" />
                   </div>
                   <div class="form-group">
                     <label>字段名称：</label><?php echo form_error('description'); ?>
                     <input type="text" name="description" class="form-control" placeholder="有意义的名称,最多40个字符" />
                   </div>
                   <div class="form-group">
                     <label>字段类型：</label>
                     <?php $this->form->show('type','select',array_merge(setting('fieldtypes'),setting('extra_fieldtypes'))); echo form_error('type'); ?>
                   </div>
                   <div class="form-group">
                     <label>字段长度：</label><?php echo form_error('length'); ?>
                     <input type="text" name="length" class="form-control" placeholder="设置一个适当的字段长度" />
                   </div>
                   <div class="form-group">
                     <label>数据源：</label><?php echo form_error('values'); ?>
                     <input type="text" name="values" class="form-control" placeholder="为某些字段类型提供数据源" />
                   </div>
                   <div class="form-group">
                     <label>显示宽度：</label><?php echo form_error('width'); ?>
                     <input type="text" name="width" class="form-control" placeholder="为某些字段类型提供数据源" />
                   </div>
                   <div class="form-group">
                     <label>显示高度：</label><?php echo form_error('height'); ?>
                     <input type="text" name="height" class="form-control" placeholder="表单控件的显示的高度,单位为px" />
                   </div>
                  <div class="form-group">
                     <label>验证规则：</label>
                     <?php $this->form->show('rules','checkbox',setting('validation')); echo form_error('rules'); ?>
                   </div>
                   <div class="form-group">
                     <label>规则说明：</label><?php echo form_error('ruledescription'); ?>
                     <input type="text" name="ruledescription" class="form-control" placeholder="规则说明" />
                   </div>
                   <div class="form-group">
                     <label>管理选项：</label>
                     <?php $this->form->show('searchable','checkbox','能否搜索'); ?>
                     <?php $this->form->show('listable','checkbox','是否显示'); ?>
                     <?php $this->form->show('editable','checkbox','能否编辑'); ?>
                   </div>
                   <div class="form-group">
                     <label>显示顺序：</label><?php echo form_error('order'); ?>
                     <input type="text" name="order" class="form-control" placeholder="数字小的排前面" />
                   </div>

                   <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
              </div>
              <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->