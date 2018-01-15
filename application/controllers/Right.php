<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Right extends MY_Controller
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
		$this->load->model('right_model');
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
        $offset = $this->input->get('offset', TRUE) ? intval($this->input->get('offset', TRUE)) : 0;
        $data['list'] = $this->right_model->get_rights(10, $offset);

        //加载分页
        $this->load->library('pagination');
        $config['base_url'] = backend_url('right/view');
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

        $config['total_rows'] = $this->right_model->get_rights_num();
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->_template('right_list', $data);
	}

	// ------------------------------------------------------------------------

	/**
     * 添加表单入口
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
     * 添加表单呈现/处理函数
     *
     * @access  public
     * @return  void
     */
	public function _add_post()
	{
		if ($this->_validate_model_form() == TRUE) {
			//新增权限
			$this->right_model->add_right($this->_get_post_data());
			$this->user_model->writeLog($this->session->user, '新增了权限'.json_encode($this->_get_post_data(), JSON_UNESCAPED_UNICODE));
			$this->_message('权限添加成功!', '/right/view');
		} else {
			$this->_template('right_add');
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 修改表单入口
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
     * 修改表单呈现/处理函数
     *
     * @access  public
     * @return  void
     */
	public function _edit_post($id = 0)
	{
		$target_right = $this->right_model->get_right_by_id($id);
		! $target_right AND $this->_message('不存在的权限!', '', FALSE);
		if ($this->_validate_model_form($target_right->right_name) == TRUE) {
			$this->right_model->edit_right($target_right->right_id, $this->_get_post_data());
			$this->user_model->writeLog($this->session->user, '修改了权限'.json_encode($target_right, JSON_UNESCAPED_UNICODE));
			$this->_message('权限修改成功!', '/right/edit/' . $target_right->right_id, TRUE);
		} else {
			$this->_template('right_edit', array('right' => $target_right));
		}
	}

	// ------------------------------------------------------------------------

	/**
     * 验证插件信息的合法性
     *
     * @access  private
     * @param   string
     * @param   bool
     * @return  bool
     */
	private function _validate_model_form($name = '', $load_form = TRUE)
	{
		$this->load->library('form_validation');
		$callback = '|callback__check_right_name';
		if ($name AND $name == trim($this->input->post('right_name', TRUE)) ) {
			$callback = '';
		}
		$this->form_validation->set_rules('right_name', '权限名称', 'trim|required|min_length[3]|max_length[30]' . $callback);
		$this->form_validation->set_rules('right_class', '控制器名', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('right_method', '方法名', 'trim|required|max_length[30]');

		if ($this->form_validation->run() == FALSE) {
			$load_form AND $this->load->library('form');
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
     * @return  array
     */
	private function _get_post_data()
	{
		//获取表单数据
		$data['right_name'] = $this->input->post('right_name', TRUE);
		$data['right_class'] = $this->input->post('right_class', TRUE);
		$data['right_method'] = $this->input->post('right_method', TRUE);
		$data['right_detail'] = $this->input->post('right_detail', TRUE);
		return $data;
	}

	// ------------------------------------------------------------------------

	/**
     * 删除GET方式入口
     *
     * @access  public
     * @return  void
     */
	public function del()
	{
		$this->_del_post();
	}

	// ------------------------------------------------------------------------

	/**
     * 删除POST入口/处理函数
     *
     * @access  public
     * @return  void
     */
	public function _del_post()
	{
		$id = $this->input->get_post('id', TRUE);
		$this->right_model->del_right($id);
		$this->user_model->writeLog($this->session->user, "删除了权限[{$id}]");
		$this->_message('删除权限成功!', '/right/view');
	}

	// ------------------------------------------------------------------------

	/**
       * 检查权限名称是否已经存在
       */
	public function _check_right_name($name)
	{
		if ( $this->right_model->check_right_name($name))
		{
			$this->form_validation->set_message('_check_right_name', '已经存在的权限名称');
			return FALSE;
		} else {
			return TRUE;
		}
	}


	// ------------------------------------------------------------------------

}
