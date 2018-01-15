<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_check_permit();
    }

    // ------------------------------------------------------------------------

    /**
     * 默认入口
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function view($role = 0)
    {
        $offset = $this->input->get('offset', TRUE) ? $this->input->get('offset', TRUE) : 0;
        $data['list'] = $this->user_model->get_users($role, 10, $offset);
        $data['role'] = $role;
        $data['roles'] = $this->user_model->get_roles();
        //加载分页
        $this->load->library('pagination');
        $config['base_url'] = backend_url('user/view');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';

        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';

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

        $config['total_rows'] = $this->user_model->get_users_num($role);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->_template('user_list', $data);
    }

    // ------------------------------------------------------------------------

    /**
     * 添加用户表单页
     *
     * @access  public
     * @return  void
     */
    public function add()
    {
        $this->_add_post();
    }

    // ------------------------------------------------------------------------

    /**
     * 添加用户表单生成/处理函数
     *
     * @access  public
     * @return  void
     */
    public function _add_post()
    {
        $data['roles'] = $this->user_model->get_roles();
        if ( ! $this->_validate_user_form()) {
            $this->_template('user_add', $data);
        } else {
            $role_id = $this->user_model->add_user($this->_get_form_data());
            $this->user_model->writeLog($this->session->user, "创建了用户".$this->_get_form_data()['username']);
            $this->_message('用户添加成功!', '/user/view');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * 修改用户表单入口
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function edit($id = 0)
    {
        $this->_edit_post($id);
    }

    // ------------------------------------------------------------------------

    /**
     * 修改用户表单生成/处理函数
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function _edit_post($id = 0)
    {
        if ( ! preg_match_all('/^[1-9]\d*$/', $id) ) {
            $this->_message('不存在的用户', '/user/view');
        }
        if ( $id == 1) {
            $this->_message('内置用户不容修改', '/user/view');
        }
        $data['user'] = $this->user_model->get_user_by_uid($id);
        $data['roles'] = $this->user_model->get_roles();
        if ( ! $data['user']) {
            $this->_message('不存在的用户', '', FALSE);
        }
        if ( ! $this->_validate_user_form($data['user']->username, TRUE)) {
            $this->_template('user_edit', $data);
        } else {
            $this->user_model->edit_user($id, $this->_get_form_data(TRUE));
            $this->user_model->writeLog($this->session->user, "用户".$this->session->user."编辑了".$data['user']->username."的账户信息");
            $this->_message('用户修改成功!', '/user/edit/' . $id);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * 删除用户
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function del($id)
    {
        if ( ! (preg_match_all('/^[1-9]\d*$/', $id) && $id > 1) ) {
            $this->_message('不存在的用户!', '/user/view');
        }
        if( $id == $this->session->uid ) {
            $this->_message('不要删除当前登录用户!', '/user/view');
        }
        $user = $this->user_model->get_user_by_uid($id);
        if ( ! $user) {
            $this->_message('不存在的用户!', '/user/view');
        }
        $this->user_model->del_user($id);
        $this->user_model->writeLog($this->session->user, "用户".$this->session->user."删除了用户".$user->username);
        $this->_message('用户删除成功!', '/user/view');
    }

    // ------------------------------------------------------------------------

    /**
     * 检查用户名称是否存在
     */
    public function _check_user_name($name = '')
    {
        if ($this->user_model->get_user_by_name($name)) {
            $this->form_validation->set_message('_check_user_name', '已经存在的用户名称！');
            return FALSE;
        }
        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * 检查表单数据合法性
     */
    private function _validate_user_form($name = '', $edit = FALSE)
    {
        $this->load->library('form_validation');
        $callback = '|callback__check_user_name';
        if ($name AND $name == trim($this->input->post('username', TRUE))) {
            $callback = '';
        }
        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[3]|max_length[16]' . $callback);
        if ( ! ($edit AND ! $this->input->post('password', TRUE) AND ! $this->input->post('confirm_password', TRUE))) {
            $this->form_validation->set_rules('password', '用户密码', 'trim|required|min_length[8]|max_length[16]');
            $this->form_validation->set_rules('confirm_password', '重复密码', 'trim|required|min_length[8]|max_length[16]|matches[password]');
        }
        $this->form_validation->set_rules('email', '用户邮箱', 'trim|required|valid_email');
        $this->form_validation->set_rules('role', '用户组', 'trim|required');
        $this->form_validation->set_rules('status', '用户状态', 'trim|required');
        $this->form_validation->set_rules('realname', '用户备注', 'trim|required');
        $this->form_validation->set_rules('lock_ip', '是否固定ip', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->library('form');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // ------------------------------------------------------------------------

    /**
     * 获取表单数据
     *
     * @access  private
     * @param   bool
     * @return  array
     */
    private function _get_form_data($edit = FALSE)
    {
        $data['username'] = $this->input->post('username', TRUE);
        if ( ! ($edit AND ! $this->input->post('password', TRUE) AND ! $this->input->post('confirm_password', TRUE))) {
            $data['password'] = $this->input->post('password', TRUE);
        }
        $data['email'] = $this->input->post('email', TRUE);
        $data['role'] = $this->input->post('role', TRUE);
                         $data['status'] = $this->input->post('status', TRUE);
        $data['realname'] = $this->input->post('realname', TRUE);
		$data['lock_ip'] = $this->input->post('lock_ip', TRUE);
		$data['ip'] = $this->input->post('ip', TRUE);
        return $data;
    }

    // ------------------------------------------------------------------------

}