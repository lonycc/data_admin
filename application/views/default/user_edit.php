<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><span class="glyphicon glyphicon-home"></span></li>
				<li><a href="/index/index">首页</a></li>
				<li><a href="/user/view">用户管理</a></li>
				<li class="active">修改用户</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">修改用户</div>
					<div class="panel-body">
					<?=form_open('/user/edit/'.$user->uid); ?>
						<input type='hidden' name='id' />
						<div class="canvas-wrapper">
							<div class="form-group">
								<label>用户名：</label><?=form_error('username'); ?>
								<input type="text" name="username" class="form-control" value="<?=$user->username; ?>" placeholder="3~16位" />
							</div>
							<div class="form-group">
								<label>邮箱：</label><?=form_error('email'); ?>
								<input type="text" name="email" class="form-control" value="<?=$user->email; ?>" placeholder="有效的邮箱地址" />
							</div>
							<div class="form-group">
								<label>备注：</label><?=form_error('realname'); ?>
								<input type="text" name="realname" class="form-control" placeholder="用户备注" value="<?=$user->realname; ?>" />
							</div>
							<div class="form-group">
								<label>用户密码：</label><?=form_error('password'); ?>
								<input type="password" name="password" class="form-control" placeholder="8~16位，留空则不改" />
							</div>
							<div class="form-group">
								<label>重复密码：</label><?=form_error('confirm_password'); ?>
								<input type="password" name="confirm_password" class="form-control" placeholder="8~16位，留空则不改" />
							</div>
							<div class="form-group">
								<label>用户组：</label><?=form_error('role'); ?>
								<?php $this->form->show('role', 'select', $roles, $user->role); ?>
							</div>
							<div class="form-group">
								<label>状态：</label>
								<?php $this->form->show('status','select',array(1 => '正常', 2 => '冻结'), $user->status); echo " ".form_error('status'); ?>
							</div>
							<div class="form-group">
								<label>是否固定ip：</label>
								<?php $this->form->show('lock_ip','select',array(0 => '否', 1 => '是'), $user->lock_ip); echo " ".form_error('lock_ip'); ?>
							</div>
							<div class="form-group">
								<label>常用ip：</label>
								<input type="text" name="ip" class="form-control" placeholder="常用ip" value="<?=$user->ip; ?>" />
							</div>
							<button type="submit" id="btn_submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
						</div>
						<?=form_close(); ?>
					</div>
				</div>
			</div>
		</div>

	</div>	<!--/.main-->
