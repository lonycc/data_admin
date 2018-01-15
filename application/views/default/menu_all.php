<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <script src="/static/js/menu.js"></script>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li><a href="/menu/view">菜单管理</a></li>
        <li class="active">新增菜单</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><a href="javascript:void(0);" class="btn btn-default">新增顶级菜单</a></div>
          <div class="panel-body">
            <div class="canvas-wrapper">
              <table class="table table-striped table-hover table-bordered">
                  <tr class="channel_title">
                      <th><input type="checkbox" name="checkbox" /> </th>
                      <th class="typeid">id</th>
                      <th>菜单名称 - 控制器名/方法名</th>
                      <!--<th class="model">绑定内容模型</th>-->
                      <th class="typeoperate">操作</th>
                  </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->
