<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

      // ------------------------------------------------------------------------

    /**
     * 根据用户名或者用户UID称获取该用户完整的信息
     */
    public function get_full_user_by_username($username = '', $type = 'username')
    {
        $table_admins = $this->db->dbprefix('admins');
        $table_roles = $this->db->dbprefix('roles');
        if ( $type == 'uid' ) {
            $this->db->where($table_admins . '.uid', $username);
        } else if ( $type == 'email' ) {
            $this->db->where($table_admins . '.email', $username);
        } else {
            $this->db->where($table_admins . '.username', $username);
        }
        return $this->db->select("$table_admins.uid, $table_admins.username, $table_admins.password, $table_admins.salt, $table_admins.role, $table_roles.name, $table_admins.status,$table_admins.email,$table_admins.ip,$table_admins.lock_ip")->from($table_admins)->join($table_roles, "$table_roles.id = $table_admins.role")->get()->row();
    }

    // ------------------------------------------------------------------------

    /**
     * 根据用户ID获取用户信息
     *
     */
    public function get_user_by_uid($uid = 0)
    {
        return $this->db->where('uid', $uid)->get($this->db->dbprefix('admins'))->row();
    }

    // ------------------------------------------------------------------------

    /**
     * 根据用户名获取用户信息
     *
     */
    public function get_user_by_name($name)
    {
        return $this->db->where('username', $name)->get($this->db->dbprefix('admins'))->row();
    }

    // ------------------------------------------------------------------------

    /**
     * 用户自己密码
     *
     */
    public function update_user_password()
    {
        $data['password'] = $this->input->post('new_pass', TRUE);
        $data['salt'] = substr(sha1(time()), -10);
        $data['password'] = sha1($data['password'].$data['salt']);
        return $this->db->where('uid', $this->session->uid)->update($this->db->dbprefix('admins'), $data);
    }

    // ------------------------------------------------------------------------

    /**
     * 获取用户组列表
     */
    public function get_roles()
    {
        $roles = array();
        foreach ($this->db->select('id, name')->where('id <>', 1)->get($this->db->dbprefix('roles'))->result_array() as $v)
        {
            $roles[$v['id']] = $v['name'];
        }
        return $roles;
    }

    // ------------------------------------------------------------------------

    /**
     * 获取用户数
     *
     */
    public function get_users_num($role_id = 0)
    {
        $this->db->where('uid <>', 1);
        if ( $role_id > 0 )
        {
            $this->db->where('role', $role_id);
        }
        return $this->db->count_all_results($this->db->dbprefix('admins'));
    }

    // ------------------------------------------------------------------------

    /**
     * 获取某个用户组下所有用户
     *
     */
    public function get_users($role_id = 0, $limit = 0, $offset = 0)
    {
        $table_admins = $this->db->dbprefix('admins');
        $table_roles = $this->db->dbprefix('roles');
        $this->db->where("$table_admins.uid <>", 1);
        if ( $role_id > 0)
        {
            $this->db->where("$table_admins.role", $role_id);
        }
        if ( $limit > 0 )
        {
            $this->db->limit($limit);
        }
        if ( $offset > 0 )
        {
            $this->db->offset($offset);
        }
        return $this->db->from($table_admins)->join($table_roles, "$table_roles.id = $table_admins.role")->get()->result();
    }

    // ------------------------------------------------------------------------

    /**
     * 添加用户
     */
    public function add_user($data)
    {
        $data['salt'] = substr(sha1(time()), -10);
        $data['password'] = sha1($data['password'].$data['salt']);
        return $this->db->insert($this->db->dbprefix('admins'), $data);
    }

    // ------------------------------------------------------------------------

    /**
     * 修改用户
     */
    public function edit_user($uid, $data)
    {
        if ( isset($data['password']) )
        {
            $data['salt'] = substr(sha1(time()), -10);
            $data['password'] = sha1($data['password'].$data['salt']);
        }
        return $this->db->where('uid', $uid)->update($this->db->dbprefix('admins'), $data);
    }

    // ------------------------------------------------------------------------

    /**
     * 删除用户
     */
    public function del_user($uid)
    {
        return $this->db->where('uid', $uid)->delete($this->db->dbprefix('admins'));
    }
      /**
       * Writes a log.
       *
       * @param      <type>  $user   The user
       * @param      <type>  $sql    The sql
       *
       * @return     <type>  ( description_of_the_return_value )
       */

      public function writeLog($user, $sql) {
            $data['user'] = $user;
            $data['what'] = $sql;
            $data['pdate'] = time();
            return $this->db->insert($this->db->dbprefix('log'), $data);
      }

    /**
     * 检查appkey是否有效
     */
    public function checkAppkey($appkey)
    {
        return $this->db->where('appkey', $appkey)->get($this->db->dbprefix('u_m_authorization'))->row();
    }

    /**
     * 检查指定appkey调用接口频率
     */
    public function checkApiFreq($appkey)
    {
        return $this->db->where('user', $appkey)->where('pdate>=', time()-60)->count_all_results($this->db->dbprefix('log'));
    }

    public function get_throttle($uid)
    {
        return $this->db->where('created_at >', time() - 1800)->where('user_id', $uid)->limit(1)->get($this->db->dbprefix('throttles')) ->row();
    }

    public function add_throttle($data)
    {
        return $this->db->insert($this->db->dbprefix('throttles') ,$data);
    }

}