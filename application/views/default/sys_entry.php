<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
      <head>
            <meta charset="utf-8" />
            <title><?php echo setting('backend_title');  ?></title>
            <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=2,user-scalable=no" />
            <meta content="yes" name="apple-mobile-web-app-capable" />
            <meta content="black" name="apple-mobile-web-app-status-bar-style" />
            <meta name="format-detection" content="telephone=no,email=no,adress=no" />
            <link rel="shortcut icon" href="/static/ci-icon.ico" />
            <link href="/static/css/bootstrap.min.css" rel="stylesheet" />
            <link href="/static/css/styles.css" rel="stylesheet" />
            <script src="/static/js/jquery-1.10.2.min.js"></script>
      </head>
      <body>
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                  <div class="container-fluid">
                        <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                              </button>
                              <?php $this->acl->show_top_menus(); ?>
                               <ul class="user-menu">
                                     <li class="dropdown pull-right">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo $this->session->user; ?><span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                  <li><a href="/index/password"><span class="glyphicon glyphicon-cog"></span>设置</a></li>
                                                  <li><a href="/login/quit"><span class="glyphicon glyphicon-log-out"></span>注销</a></li>
                                            </ul>
                                     </li>
                               </ul>
                        </div>
                  </div><!-- /.container-fluid -->
            </nav><!-- /.nav -->

            <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
                  <ul class="nav menu">
                          <?php $this->acl->show_left_menus(); ?>
                  </ul>
            </div><!--/.sidebar-->

            <!-- main container begin-->
            <?php if($this->uri->rsegment(1) != 'module'): ?>
            <?php $this->load->view(isset($tpl) && $tpl ? $tpl : 'sys_default'); ?>
            <?php else: ?>
            <?php if(!isset($msg)){echo $content;}else{$this->load->view($tpl);} ?>
            <?php endif; ?>
            <!-- main container end -->

            <script src="/static/js/bootstrap.min.js"></script>
            <script src="/static/js/admin.js"></script>
            <script>
              !function ($) {
                  $(document).on("click","ul.nav li.parent > a > span.icon", function(){
                      $(this).find('em:first').toggleClass("glyphicon-minus");
                  });
                  $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
              }(window.jQuery);

              $(window).on('resize', function () {
                if ($(window).width() > 768) $('#sidebar-collapse').collapse('show');
              });
              $(window).on('resize', function () {
                if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide');
              });
            </script>
      </body>
</html>