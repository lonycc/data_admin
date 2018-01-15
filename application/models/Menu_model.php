<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $rs_0 = $this->db->select('menu_level')->where('menu_id', $data['menu_parent'])->get($this->db->dbprefix('menus'))->row();
        $data['menu_level'] = is_null($rs_0) ? 0 : intval($rs_0->menu_level) + 1;
        $rs = $this->db->insert($this->db->dbprefix('menus') , $data);
        if ( $rs )
        {
            return $this->db->insert_id();
        }
        return 0;
    }

    public function get()
    {
       return $this->db->select('menu_id as id,menu_parent as pid, concat(menu_name, " - ", class_name, "/", method_name) as name')->order_by('menu_id', 'asc')->get($this->db->dbprefix('menus'))->result_array();
    }

    public function get_menus()
    {
        $channels = [];
        foreach ($this->db->select('menu_id as id, menu_name as name')->where('menu_parent', 0)->get($this->db->dbprefix('menus'))->result_array() as $v)
        {
            $channels[$v['id']] = $v['name'];
        }
        return $channels;
    }

    public function update($data, $check=FALSE)
    {
        if ($check)
        {
            $rs = $this->db->select('menu_parent as pid')->where('menu_id', $data['menu_id'])->get($this->db->dbprefix('menus'))->row();
            if ( $rs->pid === $data['menu_parent'] )
            {
                return 0;
            }
            $rs_1 = $this->db->select('menu_level')->where('menu_id', $data['menu_parent'])->get($this->db->dbprefix('menus'))->row();
            $data['menu_level'] = intval($rs_1->menu_level) + 1;
        }
        return $this->db->where('menu_id', $data['menu_id'])->update($this->db->dbprefix('menus'), $data);
    }

    public function del($id)
    {
        if ( $this->db->where('menu_parent', $id)->get($this->db->dbprefix('menus'))->result() )
        {
            return 0;
        }
        return $this->db->where('menu_id', $id)->delete($this->db->dbprefix('menus'));
    }


}
