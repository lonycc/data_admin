<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('PRC');
	}

	// ------------------------------------------------------------------------
	public function index()
	{
		$keyword = $this->input->get('keyword', TRUE);
		echo  json_encode(['status'=>200, 'msg'=>'OK', 'data'=>htmlspecialchars($keyword)]);
	}

}