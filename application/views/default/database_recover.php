<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><span class="glyphicon glyphicon-home"></span></li>
        <li><a href="/index/index">首页</a></li>
        <li>数据库管理</li>
        <li class="active">数据库还原</li>
      </ol>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">数据库还原</div>
          <div class="panel-body">
              <div class="canvas-wrapper">
                    <?php echo form_open('/database/files'); ?>
                        <div class="canvas-wrapper">
                            <table class="table table-striped table-hover table-bordered">
                                <tr><th><input type="checkbox" onclick="formCheck(this, /file/);" />&nbsp;选择</th><th>文件名</th><th>卷号</th><th>大小</th><th>类型</th><th>创建时间</th><th>操作</th></tr>
                                <?php foreach ($files as $file): ?>
                                <tr>
                                  <td><input type="checkbox" name="file[]" value="<?php echo $file['name']; ?>" /></td>
                                  <td><?php echo $file['name']; ?></td>
                                  <td><?php echo $file['volume']; ?></td>
                                  <td><?php echo $file['size']; ?> KB</td>
                                  <td><?php echo $file['extension']; ?></td>
                                  <td><?php echo $file['date']; ?></td>
                                  <td>
                                    <a href="javascript:void(0);"
                       onclick="if(confirm('是否确定要导入该文件到数据库？')){window.location='<?php echo site_url('/database/files/import/'.urlencode($file['name']));?>'}">导入</a>
                    | <a href="javascript:void(0);" onclick="if(confirm('是否确定要删除该文件？')){window.location='<?php echo site_url('/database/files/delete/'.urlencode($file['name']));?>'}">删除</a>
                    | <a href="javascript:void(0);" onclick="if(confirm('是否要下载该文件？')){window.location='<?php echo site_url('/database/files/download/'.urlencode($file['name']));?>'}">下载</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            <button type="button" id="btn_submit" class="btn btn-primary" onclick="multi_delete();"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>批量删除</button>
                        </div>
                        <?php echo form_close(); ?>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>  <!--/.main-->
  <script>
    function multi_delete() {
        if($(":checkbox[name='file[]']:checked").length  <= 0) {
            alert('未选中任何项目');
            return false;
        } else {
            if (confirm('是否确定要删除选中的文件?')) {
                $('form').submit();
            }
            return false;
        }
    }
</script>