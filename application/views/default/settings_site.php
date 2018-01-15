<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><span class="glyphicon glyphicon-home"></span></li>
                <li><a href="/index/index">首页</a></li>
                <li class="active">站点设置</li>
            </ol>
        </div><!--/.row-->
        <?php $current_tab =  $this->input->get('tab') ? $this->input->get('tab') : 'site_basic' ; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">站点设置</div>
                    <div class="panel-body">
                    <div class="canvas-wrapper">
                    <?php $this->form->show('tab','select',array('site_basic' => '基本设置', 'site_status' => '站点状态', 'site_attachment' => '附件设置', 'site_terms' => '注册协议', 'site_theme' => '主题设置'),$current_tab); ?>
                    </div>
                    <div style="margin-bottom:20px;"></div>
                    <?php echo form_open('/setting/site?tab=site_basic', array('style'=>$current_tab == 'site_basic' ? 'display:block;' : 'display:none;', 'class'=>'site_basic')); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>站点名称：</label>
                                <input type="text" name="site_name" class="form-control" value="<?php echo $site->site_name; ?>" />
                            </div>
                            <div class="form-group">
                                <label>站点网址：</label>
                                <input type="text" name="site_domain" class="form-control" value="<?php echo $site->site_domain; ?>" />
                            </div>
                            <div class="form-group">
                                <label>站点logo：</label>
                                <input type="text" name="site_logo" class="form-control" value="<?php echo $site->site_logo; ?>" />
                            </div>
                            <div class="form-group">
                                <label>备案号：</label>
                                <input type="text" name="site_icp" class="form-control" value="<?php echo $site->site_icp; ?>" />
                            </div>
                            <div class="form-group">
                                <label>统计代码：</label>
                                <textarea name='site_stats'  class="form-control"><?php echo $site->site_stats; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>站点底部：</label>
                                <textarea name='site_footer'  class="form-control"><?php echo $site->site_footer; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>站点关键字：</label>
                                <input type="text" name="site_keyword" class="form-control" value="<?php echo $site->site_keyword; ?>" />
                            </div>
                            <div class="form-group">
                                <label>站点描述：</label>
                                <input type="text" name="site_description" class="form-control" value="<?php echo $site->site_description; ?>" />
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                    <?php echo form_open('/setting/site?tab=site_status', array('style'=>$current_tab == 'site_status' ? 'display:block;' : 'display:none;', 'class'=>'site_status')); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>站点状态：</label>
                                <?php $this->form->show('site_status','radio',array('1'=>'开启','0'=>'关闭'),$site->site_status); ?>
                            </div>
                            <div class="form-group">
                                <label>站点关闭原因：</label>
                                <textarea class="form-control" name="site_close_reason"><?php echo $site->site_close_reason; ?></textarea>
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                     <?php echo form_open('/setting/site?tab=site_terms', array('style'=>$current_tab == 'site_terms' ? 'display:block;' : 'display:none;', 'class'=>'site_terms')); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>注册协议：</label>
                                <textarea name="site_terms" class="form-control"><?php echo $site->site_terms; ?></textarea>
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                     <?php echo form_open('/setting/site?tab=site_theme', array('style'=>$current_tab == 'site_theme' ? 'display:block;' : 'display:none;','class'=>'site_theme')); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>主题名称：</label>
                                <input type="text" name="site_theme" class="form-control" value="<?php echo $site->site_theme; ?>" />
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>

                     <?php echo form_open('/setting/site?tab=site_attachment', array('style'=>$current_tab == 'site_attachment' ? 'display:block;' : 'display:none;','class'=>'site_attachment')); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>访问路径：</label>
                                <input type="text" name="attachment_url" class="form-control" value="<?php echo $site->attachment_url; ?>" />
                            </div>
                            <div class="form-group">
                                <label>上传路径：</label>
                                <input type="text" name="attachment_dir" class="form-control" value="<?php echo $site->attachment_dir; ?>" />
                            </div>
                            <div class="form-group">
                                <label>上传类型：</label>
                                <input type="text" name="attachment_type" class="form-control" value="<?php echo $site->attachment_type; ?>" />
                            </div>
                            <div class="form-group">
                                <label>上传大小限制(KB)：</label>
                                <input type="text" name="attachment_maxupload" class="form-control" value="<?php echo $site->attachment_maxupload; ?>" />
                            </div>
                            <div class="form-group">
                                <label>缩略图尺寸预设：</label>
                                <ul id="thumbs-preferences" data-url="<?php echo site_url('setting/thumbs'); ?>"></ul>
                                <ul id="thumbs-preferences-form" style="display: none" data-enabled="<?php echo extension_loaded('imagick') ? 'true' : 'false' ?>">
                                    <li style="padding:4px 0;">
                                        <input type="text" class="small" value="" id="new-size">
                                        <select id="new-rule">
                                            <option value="crop">Crop策略</option>
                                            <option value="fit">Fit策略</option>
                                            <option value="fill">Fill策略</option>
                                            <option value="fitWidth">FitWidth策略</option>
                                        </select>
                                        <button class="submit"  id="add-new-preference" type='button'><span>添加</span></button>
                                    </li>
                                </ul>
                                <div class="red_box" style="display: none" id="thumb-warning">对不起，必须启用<a href="http://www.php.net/manual/zh/book.imagick.php" target="_blank"><b>php-imagick</b></a>扩展方可使用本功能!</div>
                            </div>
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>  <!--/.main-->

    <script>
    $('select#tab').change(function(){
        var tab = $(this).val();
        $('form').hide();
        $('form.'+tab).show();
    });
    </script>
    <script type="text/template" id="thumb-template">
    <%= size%> - <%= window.thumbRules[rule] %>
    <a class="submit" style="padding:2px 4px" type='button'><span>x</span></a>
</script>
<script src="/static/js/underscore-min.js"></script>
<script src="/static/js/backbone-min.js"></script>
<script>
    (function() {

        "use strict"

        var thumbApp = {};

        window.thumbRules = thumbApp.rules = {
            fill: 'Fill策略',
            fit: 'Fit策略',
            fitWidth: 'FitWidth策略',
            crop: 'Crop策略'
        };

        thumbApp.url = $('#thumbs-preferences').data('url');

        thumbApp.Model = Backbone.Model.extend({
            defaults: {
                size: '',
                rule: ''
            },
            urlRoot: thumbApp.url+'/',
            validate: function(attrs) {
                if (! /^[1-9]\d*(x[1-9]\d*)?$/.test(attrs.size)) {
                    return '不合法的尺寸设置\n尺寸需要设置为形如100x100或者100的值.';
                }
                if (typeof thumbApp.rules[attrs.rule] == 'undefined') {
                    return '不合法的缩略策略参数';
                }
                if (/^\d+$/.test(attrs.size) && attrs.rule != 'fitWidth') {
                    return '该尺寸只能设置为FitWidth策略';
                }
                var isExisted = false;
                _.each(thumbApp.view.$el.children('li'), function(li) {
                    var $li = $(li);
                    if (attrs.size == $li.data('size')) {
                        isExisted = true;
                        return false;
                    }
                });
                if (isExisted) {
                    return '该尺寸的预设已经存在了';
                }
            }
        });

        thumbApp.Collection = Backbone.Collection.extend({
            model: thumbApp.Model,
            url : thumbApp.url,
            urlRoot : thumbApp.url
        });

        thumbApp.preferences = new thumbApp.Collection();

        thumbApp.thumbView = Backbone.View.extend({
            tagName: 'li',
            template: _.template($('#thumb-template').html()),
            events: {
                "click a.submit": "destroy"
            },
            initialize: function() {
                this.listenTo(this.model, 'destroy', this.remove);
            },
            render: function() {
                this.$el.css('padding', '4px 0')
                    .data('size', this.model.get('size'))
                    .data('rule', this.model.get('rule'));
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            destroy: function() {
                this.model.destroy();
            }
        });

        thumbApp.FormView = Backbone.View.extend({
            el: '#thumbs-preferences-form',
            events: {
                "click #add-new-preference": "addNew"
            },
            initialize: function() {
                this.$newSize = $('#new-size');
                if (this.$el.data('enabled') == true) {
                    this.$el.show();
                    $('#thumb-warning').hide();
                } else {
                    this.$el.hide();
                    $('#thumb-warning').show();
                }
            },
            addNew: function() {
                var newSize = this.$('#new-size').val();
                var newRule = this.$('#new-rule').val();

                var model = new thumbApp.Model({
                    size: newSize,
                    rule: newRule
                });
                if (! model.isValid()) {
                    alert(model.validationError);
                } else {
                    model.save({id: newSize});
                    thumbApp.view.addOne(model);
                }
            }
        });

        thumbApp.formView = new thumbApp.FormView();

        thumbApp.View = Backbone.View.extend({
            el: '#thumbs-preferences',
            initialize: function() {
                this.listenTo(thumbApp.preferences, 'sync', this.render);
                thumbApp.preferences.fetch({reset: true});
            },
            render: function() {
                this.$el.html('');
                if (thumbApp.preferences.length > 0) {
                    thumbApp.preferences.each(this.addOne, this);
                }
            },
            addOne: function(thumb) {
                var view = new thumbApp.thumbView({model: thumb});
                this.$el.append(view.render().el);
            }
        });

        thumbApp.view = new thumbApp.View();
    })();
</script>