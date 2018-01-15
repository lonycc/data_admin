<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefreshToken extends CI_Controller {
    function __construct(){
        @session_start();
        parent::__construct();
        $this->load->library("Server", "server");
    }

    function index(){
        $this->server->refresh_token();
    }
}
