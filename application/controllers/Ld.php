<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ld extends CI_Controller {
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 处理上传的POST请求
     *
     * @access  public
     * @param   string
     * @param   string
     * @return  void
     */
    public function json($model = '', $name = '') {
        if (!$model OR !$name) {
            return;
        }
        $parentid = $this->input->get('parentid');
        if ($parentid == '') {
            echo '[]';
            return;
        }
        include (APPPATH . 'settings/category/data_' . $model . '.php');
        $json_str = "[";
        $json = array();
        foreach ($setting['category'][$model] as $v) {
            if ($v['parentid'] == $parentid) {
                $json[] = json_encode(array('classid' => $v['classid'], $name => $v[$name]));
            }
        }
        $json_str.= implode(',', $json);
        $json_str.= "]";
        echo $json_str;
    }
    // ------------------------------------------------------------------------
    
}
