<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model('dept_model');
    }
    public function index() {
        $this->_template('sys_default');
    }
    public function password() {
        $this->_check_permit();
        $this->_password_post();
    }
    public function _password_post() {
        $this->_check_permit();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_pass', "原密码", 'required');
        $this->form_validation->set_rules('new_pass', "新密码", 'required|min_length[8]|max_length[16]|matches[new_pass_confirm]');
        $this->form_validation->set_rules('new_pass_confirm', "确认新密码", 'required|min_length[8]|max_length[16]');
        if ($this->form_validation->run() == FALSE) {
            $this->_template('sys_password');
        } else {
            $old_pass = sha1(trim($this->input->post('old_pass', TRUE)) . $this->_admin->salt);
            $stored = $this->user_model->get_user_by_uid($this->session->uid);
            if ($stored AND $old_pass == $stored->password) {
                $this->user_model->update_user_password();
                $this->user_model->writeLog($this->session->user, "修改了密码");
                $this->_message("密码更新成功!", '');
            } else {
                $this->_message("密码验证失败!", '');
            }
        }
    }
    public function cache() {
        $this->_check_permit();
        $this->_template('sys_cache');
    }
    // ------------------------------------------------------------------------
    
    /**
     * 更新缓存处理函数
     *
     * @access  public
     * @return  void
     */
    public function _cache_post() {
        $this->_check_permit();
        $cache = $this->input->post('cache');
        if ($cache AND is_array($cache)) {
            update_cache($cache);
            $this->user_model->writeLog($this->session->user, "更新了缓存");
        }
        $this->_message("缓存更新成功！", '');
    }
    public function log() {
        $offset = preg_match_all('/^[1-9]\d*$/', $this->input->get('offset', TRUE)) ? $this->input->get('offset', TRUE) : 0;
        $data['list'] = $this->log_model->get_logs(10, $offset);
        //加载分页
        $this->load->library('pagination');
        $config['base_url'] = backend_url('/index/log');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_link'] = '<';
        $config['next_link'] = '>';
        //$config['use_page_numbers'] = TRUE;
        //把结果包在ul标签里
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
        $config['total_rows'] = $this->log_model->get_log_nums();
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $this->_template('log_list', $data);
    }
    public function getDepartment($deptId = 1) {
        echo $deptId;
        $demo = $this->input->get('demo');
        echo $demo;
    }
}
