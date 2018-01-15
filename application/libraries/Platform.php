<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Platform
{
    private $_name = '物理机';

    // ------------------------------------------------------------------------
    public function file_exists($path =  '')
    {
        return file_exists($path);
    }

    // ------------------------------------------------------------------------
    public function file_write($path = '', $content = '')
    {
        return file_put_contents($path, $content);
    }

    // ------------------------------------------------------------------------
    public function file_read($path = '')
    {
        return file_get_contents($path);
    }

    // ------------------------------------------------------------------------
    public function file_delete($path = '')
    {
        return unlink($path);
    }

    // ------------------------------------------------------------------------
    public function file_upload($from = '', $to = '')
    {
        $target_path = dirname($to);
        if ( ! is_dir($target_path) AND  ! mkdir($target_path, 0755, TRUE)) {
            return FALSE;
        } else {
            return move_uploaded_file($from, $to);
        }
    }

    // ------------------------------------------------------------------------
    public function file_url($path = '')
    {
        $CI = &get_instance();
        return  $CI->settings->item('attachment_url'). '/' . $path;
    }

    // ------------------------------------------------------------------------
    public function cache_exists($path =  '')
    {
        return $this->file_exists($path);
    }

    // ------------------------------------------------------------------------
    public function cache_write($path = '', $content = '')
    {
        return $this->file_write($path, $content);
    }

    // ------------------------------------------------------------------------
    public function cache_read($path = '')
    {
        return $this->file_read($path);
    }

    // ------------------------------------------------------------------------
    public function cache_delete($path = '')
    {
        return $this->file_delete($path);
    }

    // ------------------------------------------------------------------------
    public function get_name()
    {
        return $this->_name;
    }
}
