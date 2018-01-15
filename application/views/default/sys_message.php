<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">提示信息</div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                  <h1><?php echo $msg; ?></h1>
                  <?php if($auto): ?>
                        <script>
                            function redirect($url) {
                                location = $url;
                            }
                            setTimeout("redirect('<?php echo $goto; ?>');", <?php echo $pause; ?>);
                        </script>
                        <a href="<?php echo $goto; ?>"><?php echo "页面正在自动转向，你也可以点此直接跳转！"; ?></a>
                  <?php endif; ?>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>