<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><span class="glyphicon glyphicon-home"></span></li>
				<li><a href="/index/index">首页</a></li>
				<li><a href="/user/view">权限管理</a></li>
				<li class="active">新增权限</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">新增权限</div>
					<div class="panel-body">
					<?php echo form_open('/right/add'); ?>
						<input type='hidden' name='id' />
						<div class="canvas-wrapper">
							<div class="form-group">
								<label>权限名称：</label><?php echo form_error('right_name'); ?>
								<input type="text" name="right_name" class="form-control" placeholder="3~20位" />
							</div>
							<div class="form-group">
								<label>控制器名：</label><?php echo form_error('right_class'); ?>
								<input type="text" name="right_class" class="form-control" placeholder="有效的控制器名" />
							</div>
							<div class="form-group">
								<label>方法名：</label><?php echo form_error('right_method'); ?>
								<input type="text" name="right_method" class="form-control" placeholder="有效的方法名" />
							</div>
							<div class="form-group">
								<label>附加方法名：</label>
								<input type="text" name="right_detail" class="form-control" placeholder="附加的方法名" />
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>

	</div>	<!--/.main-->
