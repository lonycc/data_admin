<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attach_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->conn_id->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function get_attach_list($limit, $offset, $uid)
    {
        $stmt = $this->db->conn_id->prepare(sprintf('SELECT * from %s where uid=:uid order by postdate desc limit :limit offset :offset', $this->db->dbprefix('attach')));
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function get_attach_nums_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->count_all_results($this->db->dbprefix('attach'));
    }

    public function get_attach_by_aid($aid)
    {
        return $this->where('aid', $aid)->get($this->db->dbprefix('attach'))->row();
    }

    public function get_attach_by_aid_uid($aid, $uid)
    {
        return $this->db->where('aid', $aid)->where('uid', $uid)->get($this->db->dbprefix('attach'))->row();
    }

    public function delete_attach($aid)
    {
        return $this->db->where('aid', $aid)->delete($this->db->dbprefix('attach'));
    }

    public function add_attach($data)
    {
        return $this->db->insert($this->db->dbprefix('attach'), $data);
    }

}
