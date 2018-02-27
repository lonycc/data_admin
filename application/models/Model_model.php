<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_model extends CI_Model {
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        parent::__construct();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 获得所有内容模型
     *
     * @access  public
     * @return  object
     */
    public function get_models($limit, $offset = 0) {
        return $this->db->limit($limit, $offset)->get($this->db->dbprefix('models'))->result();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 根据内容模型id获取内容模型
     *
     * @access  public
     * @param   int
     * @return  object
     */
    public function get_model_by_id($id) {
        return $this->db->where('id', $id)->get($this->db->dbprefix('models'))->row();
    }
    public function get_model_num() {
        return $this->db->count_all_results($this->db->dbprefix('models'));
    }
    // ------------------------------------------------------------------------
    
    /**
     * 根据内容模型name获取内容模型
     *
     * @access  public
     * @param   string
     * @return  object
     */
    public function get_model_by_name($name) {
        return $this->db->where('name', $name)->get($this->db->dbprefix('models'))->row();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 新增内容模型
     *
     * @access  public
     * @param   array
     * @return  bool
     */
    public function add_new_model($data) {
        if ($this->db->insert($this->db->dbprefix('models'), $data)) {
            $this->load->dbforge();
            $table = 'u_m_' . $data['name'];
            $this->dbforge->drop_table($table, true);
            $this->dbforge->add_field(array('id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE)));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_field(array('create_time' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'default' => 0)));
            $this->dbforge->add_field(array('update_time' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'default' => 0)));
            $this->dbforge->add_field(array('create_user' => array('type' => 'TINYINT', 'constraint' => 10, 'unsigned' => TRUE, 'default' => 0)));
            $this->dbforge->add_field(array('update_user' => array('type' => 'TINYINT', 'constraint' => 10, 'unsigned' => TRUE, 'default' => 0)));
            $this->dbforge->create_table($table);
            return TRUE;
        }
        return FALSE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 修改内容模型
     *
     * @access  public
     * @param   object
     * @param   array
     * @return  bool
     */
    public function edit_model($target_model, $data) {
        if ($this->db->where('id', $target_model->id)->update($this->db->dbprefix('models'), $data)) {
            $this->load->dbforge();
            $old_table_name = $target_model->name;
            if ($old_table_name != $data['name']) {
                $this->dbforge->rename_table('u_m_' . $old_table_name, 'u_m_' . $data['name']);
                $this->platform->cache_delete(APPPATH . 'settings/model/' . $old_table_name . '.php');
            }
            return TRUE;
        }
        return FALSE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 删除内容模型
     *
     * @access  public
     * @param   object
     * @return  void
     */
    public function del_model($model) {
        $this->load->dbforge();
        //删除表
        $this->dbforge->drop_table('u_m_' . $model->name, true);
        //删除字段
        $this->db->where('model', $model->id)->delete($this->db->dbprefix('model_fields'));
        //删除附件
        $attachments = $this->db->select('name, folder, type')->where('model', $model->id)->where('from', 0)->get($this->db->dbprefix('attachments'))->result();
        foreach ($attachments as $attachment) {
            $this->platform->file_delete(APPPATH . '../' . setting('attachment_dir') . '/' . $attachment->folder . '/' . $attachment->name . '.' . $attachment->type);
        }
        $this->db->where('model', $model->id)->where('from', 0)->delete($this->db->dbprefix('attachments'));
        //删除记录
        $this->db->where('id', $model->id)->delete($this->db->dbprefix('models'));
        //清除缓存文件
        $this->platform->cache_delete(APPPATH . 'settings/model/' . $model->name . '.php');
    }
    // ------------------------------------------------------------------------
    
    /**
     * 获取全部字段
     *
     * @access  public
     * @param   int
     * @return  object
     */
    public function get_model_fields($id) {
        return $this->db->where('model', $id)->order_by('order', 'ASC')->get($this->db->dbprefix('model_fields'))->result();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 添加新内容模型字段
     *
     * @access  public
     * @param   object
     * @param   array
     * @return  bool
     */
    public function add_field($model, $data) {
        $this->load->dbforge();
        $this->load->library('field_behavior');
        $data['model'] = $model->id;
        if ($this->db->insert($this->db->dbprefix('model_fields'), $data)) {
            $this->dbforge->add_column('u_m_' . $model->name, $this->field_behavior->on_info($data));
            return TRUE;
        }
        return FALSE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 根据字段id获取字段信息
     *
     * @access  public
     * @param   int
     * @return  object
     */
    public function get_field_by_id($id) {
        return $this->db->where('id', $id)->get($this->db->dbprefix('model_fields'))->row();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 根据字段name获取字段信息
     *
     * @access  public
     * @param   string
     * @return  object
     */
    public function get_field_by_name($name) {
        return $this->db->where('name', $name)->get($this->db->dbprefix('model_fields'))->row();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 检查字段name唯一性
     *
     * @access  public
     * @param   int
     * @param   string
     * @return  object
     */
    public function check_field_unique($model, $name) {
        return $this->db->where('model', $model)->where('name', $name)->get($this->db->dbprefix('model_fields'))->row();
    }
    // ------------------------------------------------------------------------
    
    /**
     * 修改内容模型字段信息
     *
     * @access  public
     * @param   object
     * @param   object
     * @param   array
     * @return  bool
     */
    public function edit_field($model, $field, $data) {
        $this->load->dbforge();
        $this->load->library('field_behavior');
        $old_name = $field->name;
        if ($this->db->where('id', $field->id)->update($this->db->dbprefix('model_fields'), $data)) {
            $this->dbforge->modify_column('u_m_' . $model->name, $this->field_behavior->on_info($data, $old_name));
            return TRUE;
        }
        return FALSE;
    }
    // ------------------------------------------------------------------------
    
    /**
     * 判断文件是否存在
     *
     * @access  public
     * @param   int
     * @param   object
     * @return  void
     */
    //删除内容模型字段
    public function del_field($model, $field) {
        $this->load->dbforge();
        $this->dbforge->drop_column('u_m_' . $model->name, $field->name);
        $this->db->where('id', $field->id)->delete($this->db->dbprefix('model_fields'));
    }
    // ------------------------------------------------------------------------
    public function get_field_by_model_and_name($model, $name) {
        $modelid = $this->db->where('name', $model)->get($this->db->dbprefix('models'))->row()->id;
        return $this->db->where('name', $name)->where('model', $modelid)->get($this->db->dbprefix('model_fields'))->row();
    }
    public function get_model_content_by_id($id, $model) {
        return $this->db->where('id', $id)->get($this->db->dbprefix('u_m_') . $model)->row_array();
    }
}
