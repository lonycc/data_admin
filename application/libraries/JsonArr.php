<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JsonArr {
    /**
     * 自定义实现json_encode功能的函数
     * @param mixed $data
     */
    static public function my_json_encode($data){
        if(is_object($data)) return false;
        if(is_array($data)){
            $data = self::deal_array($data);
        }
        //return urldecode(json_encode($data));
        return urldecode(json_encode($data));
    }
    static private function deal_array($data){
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $data[$key] = self::deal_array($val);
                } else {
                    $data[$key] = urlencode($val);
                }
            }
        } elseif (is_string($data)) {
            $data = urlencode($data);
        }
        return $data;
    }

}