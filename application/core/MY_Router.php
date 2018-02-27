<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Router extends CI_Router {
    // --------------------------------------------------------------------
    function set_directory($dir, $append = FALSE) {
        if ($append !== TRUE OR empty($this->directory)) {
            $this->directory = str_replace('.', '', trim($dir, '/')) . '/';
        } else {
            $this->directory.= str_replace('.', '', trim($dir, '/')) . '/';
        }
    }
    function _validate_request($segments) {
        if (count($segments) == 0) {
            return $segments;
        }
        if (file_exists(APPPATH . 'controllers/' . ucfirst($segments[0]) . '.php')) {
            return $segments;
        }
        if (is_dir(APPPATH . 'controllers/' . $segments[0])) {
            $temp = array('dir' => '', 'number' => 0, 'path' => '');
            $temp['number'] = count($segments) - 1;
            for ($i = 0;$i <= $temp['number'];$i++) {
                $temp['path'].= $segments[$i] . '/';
                if (is_dir(APPPATH . 'controllers/' . $temp['path'])) {
                    $temp['dir'][] = str_replace(array('/', '.'), '', $segments[$i]);
                }
            }
            $this->set_directory(implode('/', $temp['dir']));
            $segments = array_diff($segments, $temp['dir']);
            $segments = array_values($segments);
            unset($temp);
            if (count($segments) > 0) {
                if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . ucfirst($segments[0]) . '.php')) {
                    if (!empty($this->routes['404_override'])) {
                        $x = explode('/', $this->routes['404_override']);
                        $this->set_directory('');
                        $this->set_class($x[0]);
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');
                        return $x;
                    } else {
                        show_404($this->fetch_directory() . $segments[0]);
                    }
                }
            } else {
                if (strpos($this->default_controller, '/') !== FALSE) {
                    $x = explode('/', $this->default_controller);
                    $this->set_class($x[0]);
                    $this->set_method($x[1]);
                } else {
                    $this->set_class($this->default_controller);
                    $this->set_method('index');
                }
                if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . ucfirst($this->default_controller) . '.php')) {
                    $this->directory = '';
                    return array();
                }
            }
            return $segments;
        }
        if (!empty($this->routes['404_override'])) {
            $x = explode('/', $this->routes['404_override']);
            $this->set_class($x[0]);
            $this->set_method(isset($x[1]) ? $x[1] : 'index');
            return $x;
        }
        show_404($segments[0]);
    }
}
