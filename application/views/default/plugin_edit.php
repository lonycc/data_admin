<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><span class="glyphicon glyphicon-home"></span></li>
				<li><a href="/index/index">首页</a></li>
				<li><a href="/plugin/view">插件管理</a></li>
				<li class="active">插件修改</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">插件修改</div>
					<div class="panel-body">
					<?php echo form_open('/plugin/edit/'.$plugin->id); ?>
						<div class="canvas-wrapper">
							<div class="form-group">
								<label>插件标识：</label><?php echo form_error('name'); ?>
								<input value="<?php echo $plugin->name; ?>" type="text" name="name" class="form-control" placeholder="3~40位，唯一" />
							</div>
							<div class="form-group">
								<label>插件名称：</label><?php echo form_error('title'); ?>
								<input value="<?php echo $plugin->title; ?>" type="text" name="title" class="form-control" placeholder="有意义的名称" />
							</div>
							<div class="form-group">
								<label>插件版本：</label><?php echo form_error('version'); ?>
								<input value="<?php echo $plugin->version; ?>" type="text" name="version" class="form-control" placeholder="1~5位" value="1" />
							</div>
							<div class="form-group">
								<label>插件描述：</label><?php echo form_error('description'); ?>
								<textarea class="form-control" name="description"><?php echo $plugin->description; ?></textarea>
							</div>
							<div class="form-group">
								<label>插件网址：</label><?php echo form_error('link'); ?>
								<input value="<?php echo $plugin->link; ?>" type="text" name="link" class="form-control" placeholder="合法url地址" />
							</div>
							<div class="form-group">
								<label>插件版权：</label><?php echo form_error('copyrights'); ?>
								<input value="<?php echo $plugin->copyrights; ?>" type="text" name="copyrights" class="form-control" placeholder="1~100位" />
							</div>
							<div class="form-group">
								<label>插件作者：</label><?php echo form_error('author'); ?>
								<input value="<?php echo $plugin->author; ?>" type="text" name="author" class="form-control" placeholder="1~20位" />
							</div>
							<div class="form-group">
								<label>仅root可用：</label>
								<input type="radio" name="access" value="1" <?php if($plugin->access==1){echo 'checked';} ?> />是
								<input type="radio" name="access" value="0" <?php if($plugin->access==0){echo 'checked';} ?> />否
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>

	</div>	<!--/.main-->
