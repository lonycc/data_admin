<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

      /**
       * 获取指定日志
       */
      public function get_logs($limit, $offset = 0)
      {
            return $this->db->order_by('pdate', 'desc')->limit($limit, $offset)->get($this->db->dbprefix('log'))->result();
      }


	// ------------------------------------------------------------------------

    /**
     * 获取操作日志总条数
     *
     */
	public function get_log_nums()
	{
		return $this->db->count_all_results($this->db->dbprefix('log'));
	}
}
