<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><span class="glyphicon glyphicon-home"></span></li>
				<li><a href="/index/index">首页</a></li>
				<li><a href="/plugin/view">插件管理</a></li>
				<li class="active">插件导入</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">插件导入</div>
					<div class="panel-body">
					<?php echo form_open('/plugin/import'); ?>
						<div class="canvas-wrapper">
							<div class="form-group">
								<label>安装文件URL：</label>
								<input type="text" name="plugin" class="form-control" placeholder="xml安装文件地址" />
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>

	</div>	<!--/.main-->
