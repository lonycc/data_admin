<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller
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
		$this->load->model('role_model');
	}

	// ------------------------------------------------------------------------

	/**
     * 默认入口
     *
     * @access  public
     * @return  void
     */
	public function view()
	{
            $offset = $this->input->get('offset', TRUE) ? $this->input->get('offset', TRUE) : 0;
            $data['list'] = $this->role_model->get_roles(10, $offset);
            //加载分页
            $this->load->library('pagination');
            $config['base_url'] = backend_url('/role/view');
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

            $config['total_rows'] = $this->role_model->get_role_user_num();
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

		$this->_template('role_list',$data);
	}

	// ------------------------------------------------------------------------

	/**
     * 添加用户组表单页
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
     * 添加用户组表单生成/处理函数
     *
     * @access  public
     * @return  void
     */
	public function _add_post()
	{
		$data = $this->role_model->get_form_data();
		if ( ! $this->_validate_role_form()) {
			$this->_template('role_add', $data);
		} else {
			$role_id = $this->role_model->add_role($this->_get_form_data());
			update_cache('role', $role_id);
                  $this->user_model->writeLog($this->session->user, "用户".$this->session->user."创建了用户组".$role_id);
			$this->_message('用户组添加成功!', '/role/view');
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 修改用户组表单入口
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
     * 修改用户组表单生成/处理函数
     *
     * @access  public
     * @param   int
     * @return  void
     */
	public function _edit_post($id = 0)
	{
        if ( ! preg_match_all('/^[1-9]\d*$/', $id) ) {
            $this->_message('不存在的角色', '/role/view');
        }
        if ( $id == 1) {
            $this->_message('内置角色不容修改', '/role/view');
        }
		$data = $this->role_model->get_form_data();
		$data['role'] = $this->role_model->get_role_by_id($id);
		if ( ! $data['role']) {
			$this->_message('不存在的用户组', '/role/view');
		}
		if ( ! $this->_validate_role_form($data['role']->name)) {
			$this->_template('role_edit', $data);
		} else {
			$this->role_model->edit_role($id, $this->_get_form_data());
			update_cache('role', $id);
                  $this->user_model->writeLog($this->session->user, "用户".$this->session->user."修改了用户组".$id);
			$this->_message('用户组修改成功!', '/role/edit/' . $id);
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 删除用户组
     *
     * @access  public
     * @param   int
     * @return  void
     */
	public function del($id = 0)
	{
        if ( ! (preg_match_all('/^[1-9]\d*$/', $id) && $id > 1) ) {
            $this->_message('不存在的角色', '/role/view');
        }
		$role = $this->role_model->get_role_by_id($id);
		if ( ! $role) {
			$this->_message('不存在的用户组', '/role/view');
		}
		if ($this->role_model->get_role_num($id) > 0) {
			$this->_message('该用户组下有用户不允许删除!', '/role/view');
		}
		$this->role_model->del_role($id);
            $this->user_model->writeLog($this->session->user, "用户".$this->session->user."删除了用户组".$role->name);
		$this->_message('用户组删除成功!', '/role/view');
	}

	// ------------------------------------------------------------------------

	/**
     * 检查用户组名称是否存在
     *
     * @access  public
     * @param   string
     * @return  bool
     */
	public function _check_role_name($name = '')
	{
		if ($this->role_model->get_role_by_name($name)) {
			$this->form_validation->set_message('_check_role_name', '已经存在的用户组名称！');
			return FALSE;
		}
		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
     * 检查表单数据合法性
     *
     * @access  private
     * @param   string
     * @return  bool
     */
	private function _validate_role_form($name = '')
	{
		$this->load->library('form_validation');
		$callback = '|callback__check_role_name';
		if ($name AND $name == trim($this->input->post('name', TRUE))) {
			$callback = '';
		}
		$this->form_validation->set_rules('name', '用户组名称', 'trim|required|min_length[3]|max_length[20]' . $callback);
		if ($this->form_validation->run() == FALSE) {
			$this->load->library('form');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 数组转换成字符串
     *
     * @access  private
     * @param   array
     * @return  string
     */
	private function _array_to_string($array)
	{
		if ($array AND is_array($array)) {
			return implode(',', $array);
		} else {
			return '0';
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 获取表单数据
     *
     * @access  private
     * @param   int
     * @return  array
     */
	private function _get_form_data()
	{
		$data['name'] = $this->input->post('name', TRUE);
		$data['rights'] = $this->_array_to_string($this->input->post('right', TRUE));
		$data['models'] = $this->_array_to_string($this->input->post('model', TRUE));
		$data['category_models'] = $this->_array_to_string($this->input->post('category', TRUE));
		$data['plugins'] = $this->_array_to_string($this->input->post('plugin', TRUE));
		return $data;
	}

	// ------------------------------------------------------------------------

}
