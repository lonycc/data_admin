<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->_check_permit();
        $this->load->library('form');
    }
    // ------------------------------------------------------------------------
    public function site() {
        $data['site'] = $this->db->get($this->db->dbprefix('site_settings'))->row();
        $this->_template('settings_site', $data);
    }
    // ------------------------------------------------------------------------
    public function _site_post() {
        $this->db->update($this->db->dbprefix('site_settings'), $this->input->post());
        update_cache('site');
        $this->user_model->writeLog($this->session->user, "用户" . $this->session->user . "更新了网站设置");
        $this->_message("更新成功", '/setting/site', TRUE, ($this->input->get('tab') ? '?tab=' . $this->input->get('tab') : ''));
    }
    // ------------------------------------------------------------------------
    public function backend() {
        $data['backend'] = $this->db->get($this->db->dbprefix('backend_settings'))->row();
        $this->_template('settings_backend', $data);
    }
    // ------------------------------------------------------------------------
    public function _backend_post() {
        $this->db->update($this->db->dbprefix('backend_settings'), $this->input->post());
        update_cache('backend');
        $this->user_model->writeLog($this->session->user, "用户" . $this->session->user . "更新了后台设置");
        $this->_message("更新成功", '/setting/backend', TRUE, ($this->input->get('tab') ? '?tab=' . $this->input->get('tab') : ''));
    }
    // ------------------------------------------------------------------------
    public function thumbs() {
        $thumbs = json_decode($this->db->get('site_settings')->row()->thumbs_preferences);
        if (is_null($thumbs)) {
            $thumbs = array();
        }
        foreach ($thumbs as $thumb) {
            $thumb->id = $thumb->size;
        }
        echo json_encode($thumbs);
    }
    // ------------------------------------------------------------------------
    public function _thumbs_put() {
        $thumb = json_decode(file_get_contents("php://input"), true);
        $thumbs = json_decode($this->db->get('site_settings')->row()->thumbs_preferences);
        if (is_null($thumbs)) {
            $thumbs = array();
        }
        $is_existed = false;
        foreach ($thumbs as $th) {
            if ($th->size == $thumb['size'] and $th->rule == $thumb['rule']) {
                $is_existed = true;
            }
        }
        if (!$is_existed) {
            $thumbs[] = array('size' => $thumb['size'], 'rule' => $thumb['rule'],);
            $this->db->set('thumbs_preferences', json_encode($thumbs))->update('site_settings');
        }
        update_cache('site');
        echo 'ok';
    }
    // ------------------------------------------------------------------------
    public function _thumbs_delete($id = '') {
        $thumbs = json_decode($this->db->get('site_settings')->row()->thumbs_preferences);
        if (is_null($thumbs)) {
            $thumbs = array();
        }
        foreach ($thumbs as $key => $thumb) {
            if ($thumb->size == $id) {
                unset($thumbs[$key]);
                break;
            }
        }
        $this->db->set('thumbs_preferences', json_encode($thumbs))->update('site_settings');
        update_cache('site');
        echo 'ok';
    }
}
