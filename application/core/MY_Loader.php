<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------
	public function switch_theme($theme = 'default')
	{
		$this->_ci_view_paths = array(APPPATH . 'views/' . $theme . '/'	=> TRUE);
	}

}

function CI()
{
    $CI = & get_instance();
    return $CI;
}
