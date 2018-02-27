<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Form {
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        //nothing to do!
        
    }
    // ------------------------------------------------------------------------
    
    /**
     * 输出控件HTML
     *
     * @access  public
     * @param   array
     * @param   string
     * @param   bool
     * @return  void
     */
    public function display(&$field, $default = '', $has_tip = TRUE, $allow_upload = FALSE) {
        $this->_find_real_value($field['name'], $default);
        $type = '_' . $field['type'];
        if ($has_tip) {
            //echo  $this->_add_tip($field['ruledescription'], $this->$type($field, $default, $allow_upload));
            echo $this->$type($field, $default, $field['ruledescription'], $allow_upload);
        } else {
            echo $this->$type($field, $default, '', $allow_upload);
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 检测表单元素的真正的值
     *
     * @access  private
     * @param   string
     * @param   string
     * @return  void
     */
    private function _find_real_value($name, &$default) {
        if (isset($_POST[$name])) {
            $default = $_POST[$name];
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 输出分类的HTML
     *
     * @access  public
     * @param   array
     * @param   string
     * @param   string
     * @return  void
     */
    public function show_class(&$category, $name, $default) {
        $this->_find_real_value($name, $default);
        $html = '<select name="' . $name . '" id="' . $name . '"><option value="">请选择</option>';
        foreach ($category as $v) {
            $html.= '<option value="' . $v['class_id'] . '" ' . ($default == $v['class_id'] ? 'selected="selected"' : '') . '>';
            for ($i = 0;$i < $v['deep'];$i++) {
                $html.= "&nbsp;&nbsp;";
            }
            $html.= $v['class_name'] . '</option>';
        }
        $html.= '</select>';
        echo $html;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 输出隐藏控件的HTML
     *
     * @access  public
     * @param   string
     * @param   string
     * @return  void
     */
    public function show_hidden($name, $default = '', $lock = FALSE) {
        if ($lock == true) {
            $this->_find_real_value($name, $default);
        }
        echo '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $default . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 根据给定的类型输出控件的HTML
     *
     * @access  public
     * @param   string
     * @param   string
     * @param   string
     * @param   string
     * @return  void
     */
    public function show($name, $type, $value = '', $default = '') {
        $this->_find_real_value($name, $default);
        $type = '_' . $type;
        $field = array('name' => $name, 'values' => $value, 'width' => 0, 'height' => 0);
        echo $this->$type($field, $default);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成INT类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _int($field, $default, $place_holder = '') {
        return '<input class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="text" style="width:100px;" placeholder="' . $place_holder . '" value="' . $default . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成FLOAT类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _float($field, $default, $place_holder = '') {
        return '<input class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="text" style="width:50px" placeholder="' . $place_holder . '" value="' . $default . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成THUMBNAIL类控件HTML
     */
    private function _thumbnail($field, $default, $place_holder = '') {
        $input = $this->_input($field, $default, $place_holder);
        if (preg_match('/^http(.*?)(jpg|png|jpeg)$/', $default)) {
            $input.= '<a href="' . $default . '" target="_blank"><img src="' . $default . '" width="100px" /></a>';
        }
        return $input;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成PASSWORD类型控件HTML
     *
     * @access  private
     * @param   array<
     * @param   string
     * @return  string
     */
    private function _password($field, $default, $place_holder = '') {
        $field['width'] = $field['width'] ? $field['width'] : 150;
        return '<input class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="password" style="width:' . $field['width'] . 'px" placeholder="' . $place_holder . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成INPUT类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _input($field, $default, $place_holder = '') {
        $field['width'] = $field['width'] ? $field['width'] : 150;
        return '<input class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="text" style="width:' . $field['width'] . 'px" value="' . $default . '" placeholder="' . $place_holder . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成TEXTAREA类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _textarea($field, $default, $place_holder = '') {
        if (!$field['width']) {
            $field['width'] = 300;
        }
        if (!$field['height']) {
            $field['height'] = 100;
        }
        return '<textarea class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '" style="width:' . $field['width'] . 'px;height:' . $field['height'] . 'px">' . $default . '</textarea>';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成SELECT类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _select($field, $default, $place_holder = '') {
        $return = '<select  class="form-control" style="width:150px;" name="' . $field['name'] . '" id="' . $field['name'] . '">' . '<option value="">请选择</option>';
        foreach ($field['values'] as $key => $v) {
            $pre_fix = '';
            if (isset($field['levels'][$key]) AND $field['levels'][$key] > 0) {
                for ($i = 0;$i < $field['levels'][$key];$i++) {
                    $pre_fix.= '&nbsp;&nbsp;';
                }
            }
            $return.= '<option value="' . $key . '" ' . ($default == $key ? 'selected="selected"' : '') . '>' . $pre_fix . $v . '</option>';
        }
        $return.= '</select>';
        return $return;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成RADIO类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _radio($field, $default, $place_holder = '') {
        $return = '';
        $count = 1;
        foreach ($field['values'] as $key => $v) {
            $return.= '<input id="rad_' . $field['name'] . '_' . $count . '" name="' . $field['name'] . '" type="radio" value="' . $key . '" ' . ($default == $key ? 'checked="checked"' : '') . ' />' . $v;
            $count++;
        }
        return $return;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成CHECKBOX类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _checkbox($field, $default, $place_holder = '') {
        $return = '';
        if (is_array($field['values'])) {
            if (!is_array($default)) {
                $default = ($default != '' ? explode(',', $default) : array());
            }
            $count = 1;
            foreach ($field['values'] as $key => $v) {
                $return.= '<input id="chk_' . $field['name'] . '_' . $count . '" name="' . $field['name'] . '[]" type="checkbox" value="' . $key . '" ' . (in_array($key, $default) ? 'checked="checked"' : '') . ' />' . $v;
                $count++;
            }
        } else {
            $return.= '<input id="chk_' . $field['name'] . '" name="' . $field['name'] . '" type="checkbox" value="1" ' . ($default == 1 ? 'checked="checked"' : '') . ' />' . $field['values'];
        }
        return $return;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成WYSISYG类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @param   bool
     * @return  string
     */
    private function _wysiwyg($field, $default, $place_holder = '', $allow_upload = FALSE, $basic = FALSE) {
        $default_width = ($field['width'] ? $field['width'] : '100%');
        $default_height = ($field['height'] ? $field['height'] : '300');
        $upload_url = backend_url('/attachment/save');
        //$upload_url = backend_url('/static/js/kindeditor/php/upload_json.php');
        return '<textarea class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" data-editor-width="' . $default_width . '" data-editor-height="' . $default_height . '"' . '  data-editor="kindeditor" data-editor-mode="' . ($basic ? 'simple' : 'full') . '" data-upload="' . ($allow_upload ? 'true' : 'false') . '" data-url="' . $upload_url . '">' . $default . '</textarea>';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成WYSISWYG_BASIC类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _wysiwyg_basic($field, $default, $allow_upload = FALSE) {
        return $this->_wysiwyg($field, $default, $allow_upload, TRUE);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成DATETIME类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _datetime($field, $default, $place_holder = '') {
        return '<input class="form-control" style="width:185px;" type="text" name="' . $field['name'] . '" id="' . $field['name'] . '" value="' . $default . '" onFocus="WdatePicker({isShowClear:true,readOnly:true,dateFmt:\'yyyy-MM-dd HH:mm\'})"/>';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成COLORPICKER类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _colorpicker($field, $default) {
        if (!$field['width']) {
            $field['width'] = 100;
        }
        return '<input class="field_colorpicker form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="text" style="width:' . $field['width'] . 'px" autocomplete="off" value="' . $default . '" />';
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成内容模型调用的控件
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _content($field, $default) {
        $html = '';
        if (!$field['values']) {
            return '请设置数据源';
        }
        if (count($options = explode('|', $field['values'])) != 2) {
            return '数据源格式不正确';
        }
        $CI = & get_instance();
        if (!$CI->platform->cache_exists(APPPATH . 'settings/model/' . $options[0] . '.php')) {
            return '内容模型不存在!';
        }
        $CI->settings->load('model/' . $options[0]);
        $model_data = setting('models');
        if (!isset($model_data[$options[0]]) OR !$model_data[$options[0]]) {
            return '内容模型不合法!';
        }
        $find_target_field = FALSE;
        foreach ($model_data[$options[0]]['fields'] as $_field) {
            if ($_field['name'] == $options[1]) {
                $find_target_field = TRUE;
                break;
            }
        }
        if (!$find_target_field) {
            return '不存在的字段名称!';
        }
        $html = '<input class="form-control" name="' . $field['name'] . '" id="' . $field['name'] . '" type="text" autocomplete="off" value="' . $default . '" />';
        // 如果有默认值，则需要走数据库读取默认值
        $default_label = '';
        if ($default AND $row = $CI->db->where('id', $default)->get('u_m_' . $options[0])->row_array()) {
            $default_label = $row[$options[1]];
        }
        //绑定js事件
        $html.= '<script>autocomplete_wrapper("' . $field['name'] . '","' . site_url('/content/search/' . implode('/', $options)) . '","' . $default_label . '");</script>';
        return $html;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成LINKED_MENU类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _linked_menu($field, $default) {
        $html = '';
        if (!$field['values']) {
            return '请设置数据源';
        }
        if (count($options = explode('|', $field['values'])) != 4) {
            return '数据源格式不正确';
        }
        $ci = & get_instance();
        if (!$ci->platform->cache_exists(APPPATH . 'settings/category/data_' . $options[0] . '.php')) {
            return '分类模型数据不存在!';
        }
        $html.= '<br />';
        for ($i = 1;$i <= $options[2];$i++) {
            $html.= '<select class="linked_menu_' . $options[0] . '"><option value="">请选择</option></select>';
        }
        $html.= '<input type="hidden" value="' . $default . '" name="' . $field['name'] . '" id="' . $field['name'] . '" />';
        $html.= '&nbsp;<a href="javascript:void();" onclick="linked_menu_insert(\'linked_menu_' . $options[0] . '\',\'' . $field['name'] . '\',' . $options[3] . ');"  class="">添加</a>';
        $html.= '<div class="linked_menu"><ul id="linked_menu_' . $options[0] . '_list">';
        if ($default) {
            $ci->settings->load('category/data_' . $options[0]);
            $model_data = setting('category');
            $default = explode('|', $default);
            foreach ($default as $v) {
                $v = str_replace(',', '', $v);
                $k = explode('-', $v);
                foreach ($k as $kk) {
                    $kk = isset($model_data[$options[0]][$kk][$options[1]]) ? $model_data[$options[0]][$kk][$options[1]] : 'undefined';
                }
                $html.= '<li><em class="value">' . $v . '</em><em>' . implode('-', $k) . '</em><span onclick="linked_menu_delete(\'linked_menu_' . $options[0] . '\',\'' . $field['name'] . '\', this);">移除</span></li>';
            }
        }
        $html.= '</ul></div>';
        $html.= '<script>$(".linked_menu_' . $options[0] . '").ld({ajaxOptions : {"url" : "' . backend_url('ld/json/' . $options[0] . '/' . $options[1]) . '"},style : {"width" : 120},field:{region_id:"classid",region_name:"' . $options[1] . '",parent_id:"parentid"}});</script>';
        return $html;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成SELECT_FROM_MODEL类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _select_from_model($field, $default) {
        if (!$this->_get_data_from_model($field, TRUE)) {
            return '获取数据源时出错了!';
        }
        return $this->_select($field, $default);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成RADIO_FROM_MODEL类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _radio_from_model($field, $default) {
        if (!$this->_get_data_from_model($field)) {
            return '获取数据源时出错了!';
        }
        return $this->_radio($field, $default);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成CHECKBOX_FROM_MODEL类型控件HTML
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _checkbox_from_model($field, $default) {
        if (!$this->_get_data_from_model($field)) {
            return '获取数据源时出错了!';
        }
        return $this->_checkbox($field, $default);
    }
    // ------------------------------------------------------------------------
    
    /**
     * 获取缓存数据并处理，返回处理状态
     *
     * @access  private
     * @param   array
     * @param   bool
     * @return  bool
     */
    private function _get_data_from_model(&$field, $need_level = FALSE) {
        if (!$field['values']) {
            return FALSE;
        }
        if (count($options = explode('|', $field['values'])) != 2) {
            return FALSE;
        }
        $ci = & get_instance();
        if (!$ci->platform->cache_exists(APPPATH . 'settings/category/data_' . $options[0] . '.php')) {
            return FALSE;
        }
        $ci->settings->load('category/data_' . $options[0]);
        $model_data = setting('category');
        $field['values'] = array();
        foreach ($model_data[$options[0]] as $v) {
            $field['values'][$v['classid']] = $v[$options[1]];
            $need_level AND $field['levels'][$v['classid']] = $v['deep'];
        }
        return TRUE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 生成控件的TIPS
     *
     * @access  private
     * @param   array
     * @param   string
     * @return  string
     */
    private function _add_tip($rules, $html) {
        if ($rules) {
            $html.= '<label>' . $rules . '</lable>';
        }
        return $html;
    }
}
