<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Role_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    // ------------------------------------------------------------------------
    public function get_roles($limit, $offset = 0) {
        return $this->db->where('id <>', '1')->limit($limit, $offset)->get($this->db->dbprefix('roles'))->result();
    }
    // ------------------------------------------------------------------------
    public function get_role_by_id($id) {
        return $this->db->where('id', $id)->get($this->db->dbprefix('roles'))->row();
    }
    // ------------------------------------------------------------------------
    public function get_role_by_name($name) {
        return $this->db->where('name', $name)->get($this->db->dbprefix('roles'))->row();
    }
    // ------------------------------------------------------------------------
    private function _re_parse_array($array, $key, $value) {
        $data = array();
        foreach ($array as $v) {
            $data[$v->$key] = $v->$value;
        }
        return $data;
    }
    // ------------------------------------------------------------------------
    public function get_form_data() {
        $data['rights'] = $this->_re_parse_array($this->db->select('right_id,right_name')->get($this->db->dbprefix('rights'))->result(), 'right_id', 'right_name');
        $data['models'] = $this->_re_parse_array($this->db->select('name,description')->get($this->db->dbprefix('models'))->result(), 'name', 'description');
        $data['category_models'] = $this->_re_parse_array($this->db->select('name,description')->get($this->db->dbprefix('cate_models'))->result(), 'name', 'description');
        $data['plugins'] = $this->_re_parse_array($this->db->select('name,title')->where('active', 1)->get($this->db->dbprefix('plugins'))->result(), 'name', 'title');
        return $data;
    }
    // ------------------------------------------------------------------------
    public function add_role($data) {
        $this->db->insert($this->db->dbprefix('roles'), $data);
        return $this->db->insert_id();
    }
    // ------------------------------------------------------------------------
    public function edit_role($id, $data) {
        return $this->db->where('id', $id)->update($this->db->dbprefix('roles'), $data);
    }
    public function get_role_num($id) {
        return $this->db->where('role', $id)->count_all_results($this->db->dbprefix('admins'));
    }
    // ------------------------------------------------------------------------
    public function get_role_user_num() {
        return $this->db->where('name<>', 'root')->count_all_results($this->db->dbprefix('roles'));
    }
    // ------------------------------------------------------------------------
    public function del_role($id) {
        $this->db->where('id', $id)->delete($this->db->dbprefix('roles'));
        $this->platform->cache_delete(APPPATH . 'settings/acl/role_' . $id . '.php');
    }
}
