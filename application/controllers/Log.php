<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->_check_permit();
		$this->load->model('log_model');
	}

	public function view()
	{
		$offset = preg_match_all('/^[1-9]\d*$/', $this->input->get('offset', TRUE)) ? $this->input->get('offset', TRUE) : 0;
		$data['list'] = $this->log_model->get_logs(10, $offset);

		//加载分页
		$this->load->library('pagination');
		$config['base_url'] = backend_url('/log/view');
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

		$config['total_rows'] = $this->log_model->get_log_nums();
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();


		$this->_template('log_list', $data);
	}

}
