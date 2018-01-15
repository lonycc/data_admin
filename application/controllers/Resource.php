<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library("Server", "server");
        $this->server->require_scope("userinfo cloud file node");//you can require scope here
    }

    public function index(){
        //resource api controller
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }
}
