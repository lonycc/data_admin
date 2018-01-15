<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><span class="glyphicon glyphicon-home"></span></li>
				<li><a href="<?=backend_url('index/index')?>">首页</a></li>
				<li class="active">修改密码</li>
			</ol>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">修改用户</div>
					<div class="panel-body">
					<?php echo form_open('index/password'); ?>
						<input type='hidden' name='id' />
						<div class="canvas-wrapper">
							<div class="form-group">
								<label>原密码：</label><?php echo form_error('old_pass'); ?>
								<input type="password" name="old_pass" id="old_pass" class="form-control" />
							</div>
							<div class="form-group">
								<label>新密码：</label><?php echo form_error('new_pass'); ?>
								<input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="8~16位" />
							</div>
							<div class="form-group">
								<label>重复新密码：</label><?php echo form_error('new_pass_confirm'); ?>
								<input type="password" name="new_pass_confirm" id="new_pass_confirm"  class="form-control" placeholder="8~16位" />
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>	<!--/.main-->