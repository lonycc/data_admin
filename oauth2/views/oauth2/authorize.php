<?php
$action = "/Authorize?response_type=".$response_type."&client_id=".$client_id."&redirect_uri=".$redirect_uri."&state=".$state."&scope=".$scope;
?>
<html>
    <head>
        <title>授权认证</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <div style="text-align:center;">
         	<form method="post">
                <div class="oauth_content" node-type="commonlogin">
                    <p class="oauth_main_info"> 授权  <a href="http://php/"  target="_blank" class="app_name">http://php/</a> 访问你的xxx帐号，并同时登录</p>
        	       <input name="authorized" value="yes" hidden>
        	       <button>submit</button>
        	       <!--这里做登陆检查：未登录要求登陆，已登陆直接授权-->
        	   </div>
            </form>
            <p>提示：为保障帐号安全，请认准本页URL地址必须以 https://php 开头</p>
        </div>
    </body>
</html>

