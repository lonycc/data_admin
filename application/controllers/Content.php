<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $this->load->model('model_model');
    }

    // ------------------------------------------------------------------------

    /**
     * 默认入口(列表页)
     *
     * @access  public
     * @return  void
     */
    public function view()
    {
        $this->_view_post();
    }

    // ------------------------------------------------------------------------

    /**
     * 内容列表页
     *
     * @access  public
     * @return  void
     */
    public function _view_post()
    {
        $model = $this->input->get('model', TRUE);
        if ( ! $model AND $this->acl->_default_link) {
            redirect($this->acl->_default_link);
        }
        $this->_check_permit();
        if ( ! $this->platform->cache_exists(APPPATH . 'settings/model/' . $model . '.php')) {
            $this->_message('不存在的模型！', '', FALSE);
        }
        $this->plugin_manager->trigger('reached');
        $this->settings->load('model/' . $model);
        $data['model'] = $this->settings->item('models');
        $data['model'] = $data['model'][$model];
        $this->load->library('form');
        $this->load->library('field_behavior');
        $data['provider'] = $this->_pagination($data['model']);
        $data['bread'] = make_bread(Array(
	'内容管理' => '',
	$data['model']['description'] => site_url('/content/view?model=' . $data['model']['name']),
        ));
        $this->_template('content_list', $data);
    }

    // ------------------------------------------------------------------------

    /**
     * 分页处理
     *
     * @access  private
     * @param   array
     * @return  array
     */
    private function _pagination($model)
    {
        $this->load->library('pagination');
        $config['base_url'] = backend_url('/content/view');
        $config['per_page'] = $model['perpage'];
        $config['uri_segment'] = 3;
        $config['suffix'] = '?model=' . $model['name'];

        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';

        //$config['use_page_numbers'] = TRUE;

        //把结果包在ul标签里
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        //自定义数字
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //当前页
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a><li>';
        //前一页
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        //后一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '<li>';

        $condition = array('id >' => '0');
        $data['where'] = array();
        foreach ( $model['searchable'] as $v ) {
            $this->field_behavior->on_do_search($model['fields'][$v], $condition, $data['where'], $config['suffix']);
        }
        $this->plugin_manager->trigger('querying', $condition);
        $config['total_rows'] = $this->db->where($condition)->count_all_results($this->db->dbprefix('u_m_') . $model['name']);
        $this->db->from($this->db->dbprefix('u_m_') . $model['name']);
        $this->db->select('id, create_time');
        $this->db->where($condition);
        $this->field_behavior->set_extra_condition();
        foreach ( $model['listable'] as $v ) {
            $this->db->select($model['fields'][$v]['name']);
        }
        $this->db->order_by('create_time', 'DESC');
        $this->db->offset($this->uri->segment($config['uri_segment'], 0));
        $this->db->limit($config['per_page']);
        $data['list'] = $this->db->get()->result();
        $this->plugin_manager->trigger('listing', $data['list']);
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        return $data;
    }

    // ------------------------------------------------------------------------

    /**
     * 添加/修改入口
     *
     * @access  public
     * @return  void
     */
    public function form()
    {
        $this->_save_post();
    }

    public function save()
    {
        $this->_save_post();
    }

    // ------------------------------------------------------------------------

    /**
     * 添加/修改表单显示/处理函数
     *
     * @access  public
     * @return  void
     */
    public function _save_post()
    {
        $model = $this->input->get('model', TRUE);
        $this->session->set_userdata('model_type', 'model');
        $this->session->set_userdata('model', $model);
        $this->settings->load('model/' . $model);
        $data['model'] = $this->settings->item('models');
        $data['model'] = $data['model'][$model];
        $id = $this->input->get('id', TRUE);

        $data['button_name'] = $id ? '编辑' : '添加';
        $data['bread'] = make_bread(array(
            '内容管理' => '',
            $data['model']['description'] => site_url('/content/view?model=' . $data['model']['name']),
            $data['button_name'] => '',
        ));

        if ( preg_match('/^[1-9]\d*$/', $id) ) {
            $this->_check_permit('edit');
            $data['content'] = $this->model_model->get_model_content_by_id($id, $model);
            $data['attachment'] = $this->db->where('model', $data['model']['id'])->where('content', $id)->where('from', 0)->get($this->db->dbprefix('attachments'))->result_array();
        } else {
            $this->_check_permit('add');
            $data['content'] = array();
        }
        $this->load->library('form_validation');
        foreach ( $data['model']['fields'] as $v ) {
            if ( $v['rules'] != '' ) {
                $this->form_validation->set_rules($v['name'], $v['description'], str_replace(",", "|", $v['rules']));
            }
        }

        $this->load->library('form');
        $this->load->library('field_behavior');
        if ( $this->form_validation->run() == FALSE )
        {
            $thumb_preferences = json_decode($data['model']['thumb_preferences']);
            $data['thumb_default_size'] = '';
            if ($thumb_preferences and $thumb_preferences->default != 'original')
            {
                $data['thumb_default_size'] = $thumb_preferences->default;
            }
            $this->_template('content_form', $data);
        } else {
            $modeldata = $data['model'];
            $data = array();
            foreach ( $modeldata['fields'] as $v ) {
                if ( $v['editable'] ) {
                    $this->field_behavior->on_do_post($v, $data);
                }
            }
            $attachment = $this->input->post('uploadedfile', TRUE);
            if ( $id ) {
                $this->db->where('id', $id);
                $data['update_time'] = time();
                $data['update_user'] = $this->_admin->uid;
                $this->plugin_manager->trigger('updating', $data , $id);
                $this->db->update($this->db->dbprefix('u_m_') . $model, $data);
                $this->plugin_manager->trigger('updated', $data , $id);
                if ( $attachment != null ) {
                    $this->db->set('model', $modeldata['id'])->set('from', 0)->set('content', $id)->where('aid in (' . $attachment . ')')->update($this->db->dbprefix('attachments'));
                }
                $this->user_model->writeLog($this->session->user, "修改了[{$modeldata['description']}]中id为{$id}的数据");
                $this->_message('修改成功！', '/content/form', TRUE, '?model=' . $modeldata['name'] . '&id=' . $id);
            } else {
                $data['create_time'] = $data['update_time'] = time();
                $data['create_user'] = $data['update_user'] = $this->_admin->uid;
                $this->plugin_manager->trigger('inserting', $data);
                $this->db->insert($this->db->dbprefix('u_m_') . $model, $data);
                $id = $this->db->insert_id();
                $this->plugin_manager->trigger('inserted', $data, $id);
                if ( $attachment != null ) {
                    $this->db->set('model', $modeldata['id'])->set('from', 0)->set('content', $id)->where('aid in (' . $attachment . ')')->update($this->db->dbprefix('attachments'));
                }
                $this->user_model->writeLog($this->session->user, "添加了数据到[{$modeldata['description']}]");
                $this->_message('添加成功！', '/content/view', TRUE, '?model=' . $modeldata['name']);
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * 删除入口
     *
     * @access  public
     * @return  void
     */
    public function del()
    {
        $this->_check_permit();
        $this->_del_post();
    }

    // ------------------------------------------------------------------------

    /**
     * 删除处理函数
     *
     * @access  public
     * @return  void
     */
    public function _del_post()
    {
        $this->_check_permit();
        $ids = $this->input->get_post('id', TRUE);
        $model = $this->input->get('model', TRUE);
        $model_id = $this->db->select('id')->where('name', $model)->get($this->db->dbprefix('models'))->row()->id;
        if ($ids) {
            if ( ! is_array($ids)) {
                $ids = array($ids);
            }
            $this->plugin_manager->trigger('deleting', $ids);
            $attachments = $this->db->select('name, folder, type')->where('model', $model_id)->where('from', 0)->where_in('content', $ids)->get($this->db->dbprefix('attachments'))->result();
            foreach ( $attachments as $attachment ) {
                $this->platform->file_delete(APPPATH . '../' . setting('attachment_dir') . '/' . $attachment->folder . '/' . $attachment->name . '.' . $attachment->type);
            }
	$this->db->where('model', $model_id)->where_in('content', $ids)->where('from', 0)->delete($this->db->dbprefix('attachments'));
	$this->db->where_in('id', $ids)->delete($this->db->dbprefix('u_m_') . $model);
	$this->plugin_manager->trigger('deleted', $ids);
        }
        $idss = implode(', ', $ids);
        $this->user_model->writeLog($this->session->user, "删除了[{$model}]中id为{$idss}的数据");
        $this->_message('删除成功！', '', TRUE);
    }

    // ------------------------------------------------------------------------

    /**
     * 相关附件列表和删除
     *
     * @access  public
     * @param   string
     * @return  void
     */
    public function attachment($action = 'list')
    {
        if ( $action == 'list' ) {
	$response = array();
            $ids = $this->input->get('ids', TRUE);
            $attachments = $this->db->select('aid, realname, name, image, folder, type')->where("aid in ($ids)")->get($this->db->dbprefix('attachments'))->result_array();
            foreach ( $attachments as $v ) {
                array_push($response, implode('|', $v));
            }
            echo implode(',', $response);
        } elseif ( $action == 'del' ) {
            $attach = $this->db->select('aid, name, folder, type')->where('aid', $this->input->get('id', TRUE))->get($this->db->dbprefix('attachments'))->row();
            if ($attach) {
                $this->platform->file_delete(APPPATH . '../' . setting('attachment_dir') . '/' . $attach->folder . '/' . $attach->name . '.' . $attach->type);
                $this->db->where('aid', $attach->aid)->delete($this->db->dbprefix('attachments'));
                echo 'ok';
            } else {
                echo 'ok';
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * 模糊搜索记录,用于调用内容字段
     *
     * @access  public
     * @param   string
     * @return  void
     */
    public function search($model, $field)
    {
        $html = '';
        $q = $this->input->get('keyword', TRUE);
        if ($q AND $results = $this->db->select("id, $field")->like($field, $q)->limit(10)->get('u_m_'.$model)->result()) {
            foreach ($results as $result) {
                $html .= '<p data-text="'.$result->$field.'" onclick="autocomplete_set_value(this,\''.$result->id.'\');">'.str_replace($q, "<span style=\"background:yellow\">$q</span>", $result->$field).'</p>';
            }
        }
        echo $html;
    }

    // ------------------------------------------------------------------------

    /**
     * 批量导入数据
     */
    public function import()
    {
        $this->_import_post();
    }

    public function _import_post()
    {
        $model = $this->input->get('model', TRUE);
        $this->session->set_userdata('model_type', 'model');
        $this->session->set_userdata('model', $model);
        $this->settings->load('model/' . $model);
        $data['model'] = $this->settings->item('models');
        $data['model'] = $data['model'][$model];
        $data['button_name'] = '导入';
        $data['bread'] = make_bread(Array(
            '内容管理' => '',
            $data['model']['description'] => site_url('/content/view?model=' . $data['model']['name']),
            $data['button_name'] => '',
        ));
        $this->_check_permit('add');

        $config['upload_path'] = APPPATH . '../' .setting('attachment_dir') .'/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 2048;
        $config['detect_mime'] = TRUE;
        $config['file_name'] = date('Ymdhis',time());
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile') )
        {
            $data['info'] = $this->upload->display_errors();
            $this->_template('content_import', $data);
        } else {
            $data['info'] = $this->upload->data();
            $uploadfile = $config['upload_path'] . $data['info']['file_name'];
            $objReader = IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($uploadfile);
            $sheet = $objPHPExcel->getSheet(0);//读取第一个sheet
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $succ = 0;
            $error = 0;
            for ( $j = 2; $j <= $highestRow; $j++ ) {
                $dddd = array();
                $dddd['create_time'] = time();
                $dddd['create_user'] = $this->_admin->uid;
                for ( $k = 0; $k < turn_char_to_number($highestColumn); $k++ ) {
                    $key = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($k,1)->getValue();
                    if ( preg_match('/\((.*)\)/', $key, $m) ) {
                        $key = $m[1];
                    }
                    $value = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($k,$j)->getValue();
                    $dddd[$key] = $value;
                }
                if ( $this->db->insert($this->db->dbprefix('u_m_'.$model), $dddd) ) {
                    $succ ++;
                } else {
                    $error ++;
                }
                //echo $this->db->last_query();
            }
            unlink($uploadfile);
            $data['success'] = $succ;
            $data['fail'] = $error;
            $this->user_model->writeLog($this->session->user, "导入数据到[{$data['model']['description']}], 其中成功{$data['success']}条, 失败{$data['fail']}条");
            $this->_template('content_import', $data);
        }
    }

    /**
     * 批量导出
     */
    public function export() {
        $this->_exporting_post();
    }

    public function _exporting_post() {
        $model = $this->input->get('model', TRUE);
        $this->session->set_userdata('model_type', 'model');
        $this->session->set_userdata('model', $model);
        $this->settings->load('model/' . $model);
        $data['model'] = $this->settings->item('models');
        $data['model'] = $data['model'][$model];
        $this->_check_permit('add');

        $query = $this->db->get($this->db->dbprefix('u_m_'.$model));
        //echo $this->db->last_query();

        if ( ! $query ) {
            return false;
        }
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("demo")->setDescription("database");
        $objPHPExcel->setActiveSheetIndex(0);
        $fields = $query->list_fields();
        $col = 0;
        foreach ( $fields as $field ) {
            if ( $col > 4 )
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col-5, 1, $this->model_model->get_field_by_model_and_name($model, $field)->description . "(" . $field . ")");
            }
            $col++;
        }
        $row = 2;
        foreach ( $query->result() as $datas ) {
            $col = 0;
            foreach ( $fields as $field ) {
                if ( $col > 4 ) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col-5, $row, $datas->$field);
                }
                $col++;
            }
            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['model']['description'] . '_' . date('Ymdhis') . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        $this->user_model->writeLog($this->session->user, "导出了[{$data['model']['description']}]");
    }

}
