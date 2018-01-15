<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><span class="glyphicon glyphicon-home"></span></li>
                <?=$bread?>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="<?=backend_url('content/view','model='.$model['name']);?>" class="btn btn-default">返回列表</a></div>
                    <div class="panel-body">
                    <?=form_open_multipart('content/import?model='.$model['name']);?>
                        <div class="canvas-wrapper">
                            <div class="form-group">
                                <label>选择要上传的文件：</label><?php if(is_array($info)){ ?>
            <span style="font-size:14px;color:green;">导入完成！其中成功<?=$success;?>条，失败<?=$fail;?>条。</span>
        <?php }else{ ?>
            <span style="font-size:14px;color:red;display:inline;"><?php echo $info; ?></span>
        <?php } ?>
                                <input type="file" name="userfile" class="form-control" />
                            </div>
                            <button type="submit" id="btn_submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span><?php echo $button_name; ?></button>
                        </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>

    </div>  <!--/.main-->