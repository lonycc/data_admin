<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试分层controller
     */
    public function demo()
    {
        echo 'hello';
    }

}