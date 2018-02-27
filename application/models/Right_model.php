<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Right_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    // ------------------------------------------------------------------------
    public function get_rights($limit, $offset = 0) {
        return $this->db->order_by('right_id', 'asc')->limit($limit, $offset)->get($this->db->dbprefix('rights'))->result();
    }
    public function check_right_name($name) {
        return $this->db->select('right_id')->where('right_name', $name)->get($this->db->dbprefix('rights'))->row();
    }
    // ------------------------------------------------------------------------
    public function get_right_by_id($id) {
        return $this->db->where('right_id', $id)->get($this->db->dbprefix('rights'))->row();
    }
    // ------------------------------------------------------------------------
    public function add_right($data) {
        $this->db->insert($this->db->dbprefix('rights'), $data);
        return $this->db->insert_id();
    }
    // ------------------------------------------------------------------------
    public function edit_right($id, $data) {
        return $this->db->where('right_id', $id)->update($this->db->dbprefix('rights'), $data);
    }
    // ------------------------------------------------------------------------
    public function get_rights_num() {
        return $this->db->count_all_results($this->db->dbprefix('rights'));
    }
    // ------------------------------------------------------------------------
    public function del_right($id) {
        return $this->db->where('right_id', $id)->delete($this->db->dbprefix('rights'));
    }
}
