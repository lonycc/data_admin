<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*创建面包屑导航*/
if (!function_exists('make_bread')) {
    function make_bread($flour) {
        $bread = array();
        $bread[] = "<li><a href=\"/index/index\">首页</a></li>";
        foreach ($flour as $name => $link) {
            if (empty($link)) {
                $bread[] = "<li>$name</li>";
            } else {
                $bread[] = "<li><a href=\"$link\">$name</a></li>";
            }
        }
        return implode('', $bread);
    }
}
/*字符转数字*/
if (!function_exists('turn_char_to_number')) {
    function turn_char_to_number($s) {
        $len = strlen($s);
        $num = 0;
        for ($i = 0;$i < $len;$i++) {
            $num+= pow(26, $len - $i - 1) * (ord($s[$i]) - 64);
        }
        return $num;
    }
}
/*转换数字为中文大写*/
if (!function_exists('translate_number_to_tradition')) {
    function translate_number_to_tradition($string) {
        return preg_replace_callback('/(\d+)/', create_function('$matches', 'return number_to_tradition($matches[0]);'), $string);
    }
}
/*数字转中文*/
if (!function_exists('number_to_tradition')) {
    function number_to_tradition($num) {
        $unit = ['', '十', '百', '千'];
        $units = ['', '万', '亿', '兆'];
        $n2s = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'];
        $s2 = strrev($num); //倒转字符串
        $r = "";
        $i4 = - 1;
        $zero = "";
        for ($i = 0, $len = strlen($s2);$i < $len;$i++) {
            if ($i % 4 == 0) {
                $i4++;
                $r = $units[$i4] . $r;
                $zero = "";
            }
            //处理0
            if ($s2{$i} == '0') {
                switch ($i % 4) {
                    case 0:
                    break;
                    case 1:
                    case 2:
                    case 3:
                        if ($s2{$i - 1} != '0') $zero = "零";
                        break;
                    }
                    $r = $zero . $r;
                    $zero = '';
            } else {
                $r = $n2s[intval($s2{$i}) ] . $unit[$i % 4] . $r;
            }
        }
        //处理前面的0
        $zPos = strpos($r, "零");
        if ($zPos == 0 && $zPos !== false) {
            $r = substr($r, 2, strlen($r) - 2);
        }
        return $r;
    }
}
/*把秒单位的数字转为类似03:25格式的时间*/
if (!function_exists('number_to_standard_time')) {
    function number_to_standard_time($second) {
        $second = intval($second);
        if ($second <= 0) {
            return "00:00";
        }
        if ($second < 60) {
            return $second < 10 ? "00:0{$second}" : "00:{$second}";
        } elseif ($second < 3600) {
            $minute = floor($second / 60);
            $second = $second % 60;
            $minute = ($minute < 10) ? "0{$minute}" : "{$minute}";
            $second = ($second < 10) ? "0{$second}" : "{$second}";
            return "{$minute}:{$second}";
        } else {
            $hour = floor($second / 3600);
            $second = $second % 3600;
            $minute = floor($second / 60);
            $second = $second % 60;
            $hour = ($hour < 10) ? "0{$hour}" : "{$hour}";
            $minute = ($minute < 10) ? "0{$minute}" : "{$minute}";
            $second = ($second < 10) ? "0{$second}" : "{$second}";
            return "{$hour}:{$minute}:{$second}";
        }
    }
}
/**
 * 生成栏目树形结构
 *
 * @param      <type>  $items  二维数组
 *
 * @return     array   ( description_of_the_return_value )
 */
if (!function_exists('generateTree')) {
    function generateTree($items) {
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['son'][] = & $items[$item['id']];
            } else {
                $tree[] = & $items[$item['id']];
            }
        }
        return $tree;
    }
}
if (!function_exists('isValidDate')) {
    function isValidDate($date, $startDate = '2016-10-20') {
        if (preg_match('/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/', $date) && strtotime($date) >= strtotime($startDate) && strtotime($date) < strtotime(date('Y-m-d', time()))) {
            return true;
        }
        return false;
    }
}
if (!function_exists('_check_email')) {
    function _check_email($email) {
        if (_utf8_strlen($email) < 6 || _utf8_strlen($email) > 50 || !preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', $email)) {
            die(json_encode(['success' => 0, 'msg' => '必须6到50位之间有效的邮箱']));
        }
    }
}
if (!function_exists('_check_username')) {
    function _check_username($u) {
        if (_utf8_strlen($u) < 2 || _utf8_strlen($u) > 20 || !preg_match('/^[a-zA-Z0-9_]+$/', $u)) {
            die(json_encode(['success' => 0, 'msg' => '用户名必须2到20位数字、小写字母、下划线组合']));
        }
    }
}
if (!function_exists('_check_length')) {
    function _check_length($value, $name = '字段', $minlength = 10, $maxlength = 200) {
        if (_utf8_strlen($value) > $maxlength || _utf8_strlen($value) < $minlength) {
            die(json_encode(['success' => 0, 'msg' => "{$name}长度必须在{$minlength}和{$maxlength}之间"]));
        }
    }
}
if (!function_exists('_check_phone')) {
    function _check_phone($value) {
        $p1 = '/^((13[0-9])|(14[5|7])|(17[0-9])|(15([0-3]|[5-9]))|(18[0-1,3-9]))\\d{8}$/';
        $p2 = '/^(0\\d{2}-\\d{8}(-\\d{1,4})?)|(0\\d{3}-\\d{7,8}(-\\d{1,4})?)$/';
        if (!preg_match($p1, $value) && !preg_match($p2, $value)) {
            die(json_encode(['success' => 0, 'msg' => '联系电话格式不对']));
        }
    }
}
if (!function_exists('_utf8_strlen')) {
    function _utf8_strlen($value = null) {
        preg_match_all('/./us', $value, $match);
        return count($match[0]);
    }
}
