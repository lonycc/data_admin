<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attach extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_check_permit();
        $this->load->model('attach_model');
    }

    public function view()
    {
        $offset = intval($this->input->get('offset', TRUE));
        $data['list'] = $this->attach_model->get_attach_list(10, $offset, $this->session->uid);

        //加载分页
        $this->load->library('pagination');
        $config['base_url'] = backend_url('/attach/view');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';

        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';

        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        //自定义数字
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //当前页
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a><li>';
        //前一页
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        //后一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '<li>';

        $config['total_rows'] = $this->attach_model->get_attach_nums_by_uid($this->session->uid);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->_template('attach_list', $data);
    }

    public function del($id=0)
    {
        $this->_del_post($id);
    }

    public function _del_post($id=0)
    {
        if ( ! preg_match_all('/^[1-9]\d*$/', $id) )
        {
            $this->_message('非法参数', '/attach/view');
        }

        $file = $this->attach_model->get_attach_by_aid_uid($id, $this->session->uid);
        if ( $file )
        {
            if ( $this->attach_model->delete_attach($id) )
            {
                @unlink(APPPATH.'../' . $file->uri);
                $this->_message('删除成功', '/attach/view');
            } else {
                $this->_message('删除失败', '/attach/view');
            }
        } else {
            $this->_message('不存在的附件', '/attach/view');
        }
    }

    public function add()
    {
        $this->_check_permit();
        $this->_add_post();
    }

    public function _add_post()
    {
        $config['upload_path'] = APPPATH . '../attachments/'.date('Ymd').'/';
        $config['allowed_types'] = 'doc|xls|jpg|png|gif|jpeg|apk';
        $config['max_size'] = 10240;
        $config['detect_mime'] = TRUE;
        $config['file_name'] = date('YmdHis');
        $this->load->library('upload', $config);

        if ( ! @file_exists($config['upload_path']) )
        {
            @mkdir($config['upload_path'], 0777, TRUE);
            @chmod($config['upload_path'], 0777);
        }

        if ( ! $this->upload->do_upload('attach') )
        {
            $data['error'] = $this->upload->display_errors();
            $this->_template('attach_add', $data);
        } else {
            $data['info'] = $this->upload->data();
            $file['uid'] = $this->session->uid;
            $file['ext'] = $data['info']['file_ext'];
            $file['origin_name'] = $data['info']['client_name'];
            $file['new_name'] = $data['info']['file_name'];
            $file['size'] = $data['info']['file_size'];
            $file['postdate'] = time();
            $file['uri'] = 'attachments/'.date('Ymd').'/'. $file['new_name'];
            $this->attach_model->add_attach($file);
            $this->_message('附件上传成功', '/attach/view');
        }
    }

}
