<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------
abstract class MY_Controller extends CI_Controller {
    public $_admin = NULL;
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('PRC');
        $this->load->database();
        $this->settings->load('backend');
        $this->load->switch_theme(setting('backend_theme'));
        $this->_check_http_auth();
        $this->_check_login();
        $this->load->library('acl');
        $this->load->library('plugin_manager');
    }
    // ------------------------------------------------------------------------
    protected function _check_http_auth() {
        if (setting('backend_http_auth_on')) {
            $user = $this->input->server('PHP_AUTH_USER');
            $passwword = $this->input->server('PHP_AUTH_PW');
            if (!$user or !$passwword or $user != setting('backend_http_auth_user') or $passwword != setting('backend_http_auth_password')) {
                header('WWW-Authenticate: Basic realm="Welcome to this Private Realm!"');
                header('HTTP/1.0 401 Unauthorized');
                echo '您没有权限访问这里.';
                exit;
            }
        }
    }
    protected function _check_login() {
        if (!$this->session->uid) {
            redirect(base_url() . 'login');
        } else {
            $this->_admin = $this->user_model->get_full_user_by_username($this->session->uid, 'uid');
            if ($this->_admin->status != 1) {
                $this->session->set_flashdata('error', "帐号冻结");
            }
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 加载视图
     */
    protected function _template($template, $data = array()) {
        $data['tpl'] = $template;
        $this->load->view('sys_entry', $data);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 检查权限
     */
    protected function _check_permit($action = '', $folder = '') {
        if (!$this->acl->permit($action, $folder)) {
            $this->_message('对不起，你没有访问这里的权限！', '', FALSE);
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 信息提示
     *
     */
    public function _message($msg, $goto = '', $auto = TRUE, $fix = '', $pause = 2000) {
        if ($goto == '') {
            $goto = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
        } else {
            $goto = strpos($goto, 'http') !== false ? $goto : backend_url($goto);
        }
        $goto.= $fix;
        $this->_template('sys_message', array('msg' => $msg, 'goto' => $goto, 'auto' => $auto, 'pause' => $pause));
        echo $this->output->get_output();
        exit();
    }
}
