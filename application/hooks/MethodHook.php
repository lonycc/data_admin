<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MethodHook
{

  public function __construct($params = array())
  {
      $this->api_method = ['login'];
  }

  // ------------------------------------------------------------------------

    /**
     * 将POST请求的方法method变成_method_post。
     *
     */
  public function turn_post_to_private()
  {
    global $method;
    if (isset($_SERVER['REQUEST_METHOD']) and $_SERVER['REQUEST_METHOD'] !== 'GET')
    {
        if (  ! in_array($method, $this->api_method, true) )
        {
            $method = '_' . $method . '_'. strtolower($_SERVER['REQUEST_METHOD']);
        }
    }
  }
}