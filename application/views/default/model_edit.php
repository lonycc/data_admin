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
                    <div class="panel-heading">新增内容模型</div>
                    <div class="panel-body">
                    <?php echo form_open('/model/edit/'.$model->id); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>内容模型标识：</label><?php echo form_error('name'); ?>
                                <input type="text" name="name" value="<?php echo $model->name; ?>" class="form-control" placeholder="3~20位字母数字或下划线" />
                            </div>
                            <div class="form-group">
                                <label>内容模型名称：</label><?php echo form_error('description'); ?>
                                <input type="text" name="description" value="<?php echo $model->description; ?>" class="form-control" placeholder="有意义的名称，不超过40位" />
                            </div>
                            <div class="form-group">
                                <label>每页显示条数：</label><?php echo form_error('perpage'); ?>
                                <input type="text" name="perpage" value="<?php echo $model->perpage; ?>" class="form-control" placeholder="每页列表显示的条数" />
                            </div>
                            <div class="form-group">
                                <label>是否使用上传控件：</label>
                                <input type="radio" name="hasattach" value="1" onclick="$('#customtable').show();" />是
                                <input type="radio" name="hasattach" value="0" onclick="$('#customtable').hide();" checked />否
                                <table class="table table-striped table-hover table-bordered" id="customtable" <?php echo $model->hasattach ? '' : 'style="display: none"' ?>>
                                    <?php $preferences = json_decode(setting('thumbs_preferences')); ?>
                                    <?php if ($preferences and is_array($preferences) and count($preferences) > 1): ?>
                                    <tr>
                                        <th>启用</th>
                                        <th>尺寸</th>
                                        <th>默认</th>
                                    </tr>
                                    <?php foreach($preferences as $pref): ?>
                                    <tr>
                                        <td><input type="checkbox" name="thumbnail[<?php echo $pref->size; ?>]" value="1" <?php echo ($model->thumb_preferences and in_array($pref->size, $model->thumb_preferences->enabled)) ? 'checked' : '' ?>></td>
                                        <td><?php echo $pref->size; ?></td>
                                        <td><input type="radio" value="<?php echo $pref->size; ?>" name="thumb_default" <?php echo ($model->thumb_preferences and $pref->size == $model->thumb_preferences->default) ? 'checked' : '' ?>></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3">还没有缩略图预设设置，<a href="<?php echo site_url('/setting/site?tab=site_attachment'); ?>">立即去设置</a></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>  <!--/.main-->