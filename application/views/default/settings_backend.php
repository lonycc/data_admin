<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><span class="glyphicon glyphicon-home"></span></li>
                <li><a href="/index/index">首页</a></li>
                <li class="active">后台设置</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">后台设置</div>
                    <div class="panel-body">
                    <?php echo form_open('/setting/backend'); ?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>后台主题：</label>
                                <input type="text" disabled name="backend_theme" class="form-control" value="<?php echo $backend->backend_theme; ?>" />
                            </div>
                            <div class="form-group">
                                <label>后台语言：</label>
                                <input type="text" disabled name="backend_lang" class="form-control" value="<?php echo $backend->backend_lang; ?>" />
                            </div>
                            <div class="form-group">
                                <label>后台入口：</label>
                                <input type="text" name="backend_access_point" class="form-control" value="<?php echo $backend->backend_access_point; ?>" disabled />
                            </div>
                            <div class="form-group">
                                <label>后台网页标题：</label>
                                <input type="text" name="backend_title" class="form-control" value="<?php echo $backend->backend_title; ?>" placeholder="用于显示网页标题" />
                            </div>
                            <div class="form-group">
                                <label>后台LOGO：</label>
                                <input type="text" name="backend_logo" class="form-control" value="<?php echo $backend->backend_logo; ?>" placeholder="LOGO自定义路径" />
                            </div>
                            <div class="form-group">
                                <label>插件开发模式：</label>
                                <input type="radio" name="plugin_dev_mode" <?php echo $backend->plugin_dev_mode ? 'checked="checked"' :''; ?> value="1" >开启
                                <input type="radio" name="plugin_dev_mode" value="0" <?php echo !$backend->plugin_dev_mode ? 'checked="checked"' :''; ?> >关闭
                            </div>
                            <div class="form-group">
                                <label>是否允许root用户登录：</label>
                                <input type="radio" name="backend_root_access" <?php echo $backend->backend_root_access ? 'checked="checked"' :''; ?> value="1" >开启
                                <input type="radio" name="backend_root_access" value="0" <?php echo !$backend->backend_root_access ? 'checked="checked"' :''; ?> >关闭
                            </div>
                            <div class="form-group">
                                <label>HTTP BASIC AUTH：</label>
                                <input type="radio" name="backend_http_auth_on" <?php echo $backend->backend_http_auth_on ? 'checked="checked"' :''; ?> value="1" >开启
                                <input type="radio" name="backend_http_auth_on" value="0" <?php echo !$backend->backend_http_auth_on ? 'checked="checked"' :''; ?> >关闭
                            </div>
                            <div class="form-group">
                                <label>BASIC AUTH 用户名：</label>
                                <input type="text" class="form-control" name="backend_http_auth_user" value="<?php echo $backend->backend_http_auth_user; ?>" />
                            </div>
                            <div class="form-group">
                                <label>BASIC AUTH 密码：</label>
                                <input type="text" class="form-control" name="backend_http_auth_password" value="<?php echo $backend->backend_http_auth_password; ?>" />
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>  <!--/.main-->