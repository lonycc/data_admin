<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script src="/static/js/kindeditor/kindeditor-min.js"></script>
<script src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="/static/js/colorPicker/colorpicker.js"></script>
<script src="/static/js/jquery.ld.js"></script>
<script src="/static/js/content_form.js"></script>

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
                    <div class="panel-heading"><a href="<?php echo backend_url('content/view','model='.$model['name']); ?>" class="btn btn-default">返回列表</a>
                    </div>
                    <div class="panel-body">
                    <?php echo form_open_multipart('/content/save?model='.$model['name'].'&id='.(isset($content['id']) ? $content['id'] : '')); ?>
                        <div class="canvas-wrapper">
                            <?php foreach( $model['fields'] as $v) :  ?>
                            <?php if($v['editable']): ?>
                                <div class="form-group">
                                    <label><?php echo $v['description'];?>：</label><?php echo form_error($v['name']); ?>
                                    <?php $this->field_behavior->on_form($v , isset($content[$v['name']]) ? $content[$v['name']] : '', TRUE, $model['hasattach']); ?>
                                </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php $this->plugin_manager->trigger('rendered', $content); ?>
                            <?php if($model['hasattach']): ?>
                            <?php $this->form->show_hidden('uploadedfile','0',true); ?>
                            <?php endif; ?>

                            <button type="submit" id="btn_submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span><?php echo $button_name; ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>  <!--/.main-->