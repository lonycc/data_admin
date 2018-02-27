<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->_check_permit();
        $this->load->model('menu_model');
    }
    public function view() {
        $this->_template('menu_all');
    }
    public function find() {
        $this->load->library('OpChannel');
        $this->load->library('JsonArr');
        $oc = new OpChannel();
        $channel = $this->menu_model->get();
        $arr = $oc->setData($channel)->start();
        $arr = JsonArr::my_json_encode($arr);
        echo $arr;
    }
    public function add() {
        return $this->_add_post();
    }
    public function _add_post() {
        $name = $this->input->post('name', TRUE);
        $arr1 = explode(' - ', $name);
        $arr2 = count($arr1) === 2 ? explode('/', $arr1[1]) : array();
        $dep = $this->input->post('dep', TRUE);
        $data['menu_parent'] = $this->input->post('pid', TRUE);
        $data['menu_name'] = $arr1[0];
        $data['class_name'] = count($arr2) === 2 ? $arr2[0] : '';
        $data['method_name'] = count($arr2) === 2 ? $arr2[1] : '';
        $rs = $this->menu_model->add($data);
        if ($rs) {
            update_cache('menu');
            echo json_encode(array('res' => 1, 'dep' => $dep, 'id' => $rs));
        } else {
            echo json_encode(array('res' => 0));
        }
    }
    public function update() {
        return $this->_update_post();
    }
    public function _update_post() {
        $name = $this->input->post('name', TRUE);
        $arr1 = explode(' - ', $name);
        $arr2 = count($arr1) === 2 ? explode('/', $arr1[1]) : array();
        $data['menu_id'] = $this->input->post('id', TRUE);
        $data['menu_name'] = $arr1[0];
        $data['class_name'] = count($arr2) === 2 ? $arr2[0] : '';
        $data['method_name'] = count($arr2) === 2 ? $arr2[1] : '';
        $rs = $this->menu_model->update($data);
        if ($rs) {
            update_cache('menu');
            echo json_encode(array('res' => 1));
        } else {
            echo json_encode(array('res' => 0));
        }
        return;
    }
    public function del() {
        return $this->_del_post();
    }
    public function _del_post() {
        $id = $this->input->post('id', TRUE);
        $rs = $this->menu_model->del($id);
        if ($rs) {
            update_cache('menu');
            echo 1;
        } else {
            echo 0;
        }
    }
    public function move() {
        $this->_move_post();
    }
    public function _move_post() {
        $data['menu_parent'] = $this->input->post('pid', TRUE);
        $data['menu_id'] = $this->input->post('id', TRUE);
        $rs = $this->menu_model->update($data, TRUE);
        if ($rs) {
            update_cache('menu');
            echo json_encode(array('res' => 1));
        } else {
            echo json_encode(array('res' => 0));
        }
        return;
    }
}
