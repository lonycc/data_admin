<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>登录页面</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=2,user-scalable=no" />
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="black" name="apple-mobile-web-app-status-bar-style" />
		<link rel="shortcut icon" href="/static/ci-icon.ico" />
		<link href="/static/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/static/css/login.css" rel="stylesheet" />
	</head>

	<body>
		<div class="container">
		   <?=form_open('/login/login', 'class="form-signin" role="form"')?>
			<h2 class="form-signin-heading">数据管理后台</h2>
			<input type="text" class="form-control" id="username" placeholder="您的账号或邮箱" name="username"  value="" autocomplete="off" />
			<input type="password" class="form-control" id="password" placeholder="您的密码" name="password" autocomplete="off" />

			<div style="margin-bottom:30px;">
			<input type="text" class="form-control" id="captcha" placeholder="验证码" name="verify" autocomplete="off" />
			<img style="float:right;margin:-42px 0px;min-width:100px;" src="<?=site_url('login/get_code').'/'.time()?>" id="verify" />
			</div>
			<button class="btn btn-info" type="button" id="login_submit">登入</button>
			<span><?=$this->session->flashdata('error')?></span>
		  <?=form_close()?>
		</div>

		<!--页脚-->
		<div class="page-footer text-center">
			<p>建议：使用Chrome、FireFox、Safari、Opera等现代浏览器打开。</p>
			<p>南方网 &copy; <?php echo date('Y', time()); ?></p>
		</div>
		<!--页脚-->
		<script color="255,3,3" opacity='0.9' zIndex="-2" count="100" src="/static/js/canvas-nest.min.js"></script>
		<script>
			function trim(e){return e.replace(/^(\s|\u00A0)+/, "").replace(/(\s|\u00A0)+$/, "")}document.getElementById('verify').onclick=function(){this.setAttribute('src', "<?php echo site_url('login/get_code').'/'; ?>"+Math.random());};document.getElementById('login_submit').onclick=function(){var u=document.getElementById('username');var p=document.getElementById('password');var c=document.getElementById('captcha');var msg='';if(''===trim(u.value)){msg+='请输入用户名或邮箱;';}if(''===trim(p.value)){msg+='请输入密码;'}if(''===trim(c.value)){msg+='请输入验证码'}if(''===msg){document.getElementsByTagName('form')[0].submit();}else{document.getElementsByTagName('span')[0].innerHTML=msg;return false;}};document.onkeydown=function(e){var ev=document.all?window.event:e;if(ev.keyCode==13){document.getElementById('login_submit').click();}}
		</script>
	</body>
</html>
