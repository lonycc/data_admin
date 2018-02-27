<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Acl {
    private $ci = NULL;
    private $top_menus = array();
    private $left_menus = array();
    private $_current_menu = - 1;
    public $_default_link = '';
    public $rights = array();
    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->settings->load('menus'); //加载菜单数据
        $this->top_menus = setting('menus');
        if ($this->ci->_admin->role != 1) {
            $this->ci->settings->load('acl/role_' . $this->ci->_admin->role . '.php'); //加载权限数据
            $this->top_menus = setting('menus');
            $this->rights = setting('current_role');
        }
        $this->_filter_menus();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 输出顶部菜单
     *
     * @access  public
     * @return  void
     */
    public function show_top_menus() {
        //检查是否显示顶部插件菜单.
        $is_show_module_menu = FALSE;
        if ($this->ci->plugin_manager->get_menus()) {
            $is_show_module_menu = TRUE;
        }
        $last_menu_key = count($this->top_menus) - 1;
        foreach ($this->top_menus as $key => $v) {
            if ($key === 2 AND !$is_show_module_menu) {
                continue;
            }
            echo '<a class="navbar-brand ' . ($key == 0 ? 'first' : ($key == $last_menu_key ? 'last' : '')) . ($key == $this->_current_menu ? ' selected' : '') . '" href="' . backend_url($v['class_name'] . '/' . $v['method_name']) . '">' . $v['menu_name'] . '</a>';
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 输出边栏菜单
     *
     * @access  public
     * @return  void
     */
    public function show_left_menus() {
        foreach ($this->left_menus as $key => $v) {
            if ($v['sub_menus']) {
                echo '<li class="parent"><a><span class="glyphicon glyphicon-list"></span>' . $v['menu_name'] . '<span data-toggle="collapse" href="#sub-item-' . $key . '" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-minus"></em></span></a><ul class="children collapse in" id="sub-item-' . $key . '">';
                foreach ($v['sub_menus'] as $j) {
                    $extra = '';
                    $this->_current_menu == 1 AND $extra = 'model=' . $j['extra'];
                    if ($this->_current_menu == 2) {
                        echo '<li class="' . (isset($j['current']) ? 'selected' : '') . '"><a href="' . plugin_url($key, $j['class_name'], $j['method_name']) . '"><span class="glyphicon glyphicon-star">' . $j['menu_name'] . '</a></li>';
                        continue;
                    }
                    echo '<li class="' . (isset($j['current']) ? 'selected' : '') . '"><a href="' . backend_url($j['class_name'] . '/' . $j['method_name'], $extra) . '"><span class="glyphicon glyphicon-star">' . $j['menu_name'] . '</a></li>';
                }
                echo '</ul></li>';
            }
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 过滤菜单
     *
     * @access  private
     * @return  void
     */
    private function _filter_menus() {
        $class_name = $this->ci->uri->rsegment(1);
        $method_name = $this->ci->uri->rsegment(2);
        switch ($class_name) {
            case 'content':
            case 'category_content':
                $this->_filter_content_menus($class_name, $method_name);
            break;
            case 'module':
                $this->_filter_module_menus($class_name, $method_name);
            break;
            default:
                $this->_filter_normal_menus($class_name, $method_name);
            break;
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 过滤系统菜单
     *
     * @access  private
     * @param   string
     * @param   string
     * @return  void
     */
    private function _filter_normal_menus($class_name, $method_name, $default_uri = 'index/index', $current_menu = 0, $folder = '') { //0
        $this->_current_menu = $current_menu;
        $this->_default_link = backend_url($default_uri);
        $this->left_menus = & $this->top_menus[$this->_current_menu]['sub_menus'];
        foreach ($this->left_menus as $vkey => & $v) {
            foreach ($v['sub_menus'] as $jkey => & $j) {
                if ($j['class_name'] == $folder . $class_name AND $j['method_name'] == $method_name) {
                    $j['current'] = TRUE;
                }
                if ($this->ci->_admin->role == 1) {
                    continue;
                }
                $right = $j['class_name'] . '@' . $j['method_name'];
                if (!in_array($right, $this->rights['rights']) AND $right != 'index@index') {
                    unset($this->left_menus[$vkey]['sub_menus'][$jkey]);
                }
            }
            if (!$v['sub_menus']) {
                unset($this->left_menus[$vkey]);
            }
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 过滤模型菜单
     *
     * @access  private
     * @param   string
     * @param   string
     * @return  void
     */
    private function _filter_content_menus($class_name, $method_name) { //1
        $this->_current_menu = 1;
        $this->left_menus = & $this->top_menus[$this->_current_menu]['sub_menus'];
        $extra = $this->ci->input->get('model');
        foreach ($this->left_menus as $vkey => & $v) {
            foreach ($v['sub_menus'] as $jkey => & $j) {
                if ($j['class_name'] == $class_name AND $j['method_name'] == $method_name AND (($j['extra'] == $extra AND $vkey == 0) || ($j['extra'] == $extra AND $vkey == 1))) {
                    $j['current'] = TRUE;
                }
                if ($this->ci->_admin->role == 1) {
                    continue;
                }
                $right = $j['class_name'] . '@' . $j['method_name'];
                if (!in_array($right, $this->rights['rights']) || (!in_array($j['extra'], $this->rights['models']) AND $vkey == 0) || (!in_array($j['extra'], $this->rights['category_models']) AND $vkey == 1)) {
                    unset($this->left_menus[$vkey]['sub_menus'][$jkey]);
                }
            }
            if (!$v['sub_menus']) {
                unset($this->left_menus[$vkey]);
            }
        }
        //设定默认链接
        if ($_item = @reset($this->left_menus[0]['sub_menus'])) {
            if (!$this->_default_link) {
                $this->_default_link = backend_url($_item['class_name'] . '/view', 'model=' . $_item['extra']);
            }
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 过滤cms菜单
     */
    private function _filter_cms_menus($class_name, $method_name) { //3
        $this->_current_menu = 3;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 过滤插件菜单
     *
     * @access  private
     * @param   string
     * @param   string
     * @return  void
     */
    private function _filter_module_menus($class_name, $method_name) { //3
        $this->_current_menu = 2;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 检测模块插件菜单
     *
     * @access  public
     * @return  void
     */
    public function detect_plugin_menus() {
        $this->top_menus[$this->_current_menu]['sub_menus'] = $this->ci->plugin_manager->get_menus();
        $this->left_menus = & $this->top_menus[$this->_current_menu]['sub_menus'];
        foreach ($this->left_menus as $key => & $v) {
            if (isset($v['sub_menus']) AND $v['sub_menus']) {
                foreach ($v['sub_menus'] as & $j) {
                    $j['extra'] = 'plugin=' . $key . '&action=' . $j['method_name'];
                    if ($key == $this->ci->input->get('plugin') AND $j['class_name'] == $this->ci->input->get('c') AND $j['method_name'] == $this->ci->input->get('m')) {
                        $j['current'] = TRUE;
                    }
                    if (!$this->_default_link) {
                        $this->_default_link = plugin_url($key, $j['class_name'], $j['method_name']);
                    }
                }
            } else {
                unset($this->left_menus[$key]);
            }
        }
    }
    // ------------------------------------------------------------------------
    
    /**
     * 检测插件
     *
     * @access  public
     * @param   string
     * @return  void
     */
    public function permit($act = '', $folder = '') {
        if ($this->ci->_admin->role == 1) {
            return TRUE;
        }
        $class_method = $folder . $this->ci->uri->rsegment(1) . '@' . $this->ci->uri->rsegment(2) . ($act ? '@' . $act : '');
        if (!in_array($class_method, $this->rights['rights'])) {
            return FALSE;
        }
        if ($this->ci->uri->rsegment(1) == 'content') {
            if (!in_array($this->ci->input->get('model'), $this->rights['models'])) {
                return FALSE;
            }
        } else if ($this->ci->uri->rsegment(1) == 'category_content') {
            if (!in_array($this->ci->input->get('model'), $this->rights['category_models'])) {
                return FALSE;
            }
        } else if ($this->ci->uri->rsegment(1) == 'module') {
            if (!in_array($this->ci->input->get('plugin'), $this->rights['plugins'])) {
                return FALSE;
            }
        }
        return TRUE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 设置顶部选中菜单
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function set_current_menu($key = 0) {
        $this->_current_menu = $key;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 触发自定义菜单的检测
     *
     * @access  public
     * @param   int
     * @return  void
     */
    public function filter_left_menus($default_uri = '', $current_menu = 0, $folder = '') {
        $current_menu AND $this->_current_menu = $current_menu;
        $class_name = $this->ci->uri->rsegment(1);
        $method_name = $this->ci->uri->rsegment(2);
        $this->_filter_normal_menus($class_name, $method_name, $default_uri, $this->_current_menu, $folder);
    }
    // ------------------------------------------------------------------------
    
}
