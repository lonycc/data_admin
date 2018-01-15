<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dept_model extends MY_Model
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
	}

	// ------------------------------------------------------------------------

    /**
     *  获取指定部门指定日期的数据
     *
     * @access  public
     * @return  object
     */
	public function get_channel_data($id, $date)
	{
            $key = "get_channel_data_{$id}_{$date}";
            if ( ! $this->cache->redis->get($key) )
            {
              $result = $this->db->query("select d.create_time,d.name,d.re_by_hour,d.pv,d.uv,d.pub,c.timeflow from app_u_m_cdetail as d left join app_u_c_channel as c on d.sid=c.sid where d.create_time=$date and d.sid in (select sid from app_u_c_channel where deptid=$id) and c.status=1")->result();
              $this->cache->redis->save($key, $result, 43200);
            }
            return $this->cache->redis->get($key);
	}

      public function get_dept_data($date)
      {
            $key = "get_dept_data_{$date}";
            if ( ! $this->cache->redis->get($key) )
            {
              $result = $this->db->query("SELECT sum(pv) as tpv,sum(pub) as tpub,group_concat(pv SEPARATOR '@@@@') as pvs,group_concat(pub SEPARATOR '@@@@') as pubs,group_concat(re_by_hour SEPARATOR '@@@@') as res,group_concat(t.n SEPARATOR '@@@@') as tns,t.k,count(*) as cnt,t.percent from app_u_m_cdetail as m left join (select c.sid,c.name as n,d.name as k,d.percent from app_u_c_channel as c left join app_u_c_dept as d on c.deptid=d.classid and c.status=1) as t on m.sid=t.sid where m.create_time=$date group by t.k order by tpv desc")->result();
              $this->cache->redis->save($key, $result, 43200);
            }
            return $this->cache->redis->get($key);
      }

      public function get_dept_by_id($id)
      {
            $key  = "get_dept_by_id_{$id}";
            if ( ! $this->cache->redis->get($key))
            {
                $result = $this->db->where('classid', $id)->get($this->db->dbprefix('u_c_dept'))->row();
                $this->cache->redis->save($key, $result, 50000);
            }
            return $this->cache->redis->get($key);
      }

      public function get_summary_by_date($date = null)
      {
            $key = "get_summary_by_date_{$date}";
            if ( ! $this->cache->redis->get($key) )
            {
                if( $date )
                {
                    $result = $this->db->where('create_time', $date)->get($this->db->dbprefix('u_m_summary'))->row();
                } else {
                   $xid = floor((time()-1479571200)/86400);
                   $result = $this->db->where('id>', $xid)->where('tool_cc_rank>', 0)->order_by('create_time', 'asc')->get($this->db->dbprefix('u_m_summary'))->result();
                }
                $this->cache->redis->save($key, $result, 43200);
            }
            return $this->cache->redis->get($key);
      }

      public function get_editor_data($date, $id = null)
      {
            $key = "get_editor_data_{$date}_{$id}";
            if ( ! $this->cache->redis->get($key) )
            {
                  if ( $id )
                  {
                        $result = $this->db->query("select name,pv,pub from app_u_m_edetail where create_time=$date and  sid in (select sid from app_u_c_editor where deptid=$id) order by pv desc")->result();
                  } else {
                    $result = $this->db->query("select group_concat(t.ename SEPARATOR '@@@@') as enames,group_concat(pv SEPARATOR '@@@@') as pvs,group_concat(pub SEPARATOR '@@@@') as pubs,dname,count(*) as cnt from app_u_m_edetail as m left join (select e.sid,e.name as ename,d.name as dname from app_u_c_editor as e left join app_u_c_dept as d on e.deptid=d.classid where e.status=1) as t on m.sid=t.sid where m.create_time=$date group by t.dname")->result();
                  }
                  $this->cache->redis->save($key, $result, 43200);
            }
            return $this->cache->redis->get($key);
      }
     // -----------------------------------------------------------------------------------
     /**
      * 获取alexa数据
      */
     public function get_alexa_data($params)
     {
        $key = "get_alexa_data_{$params['site']}";
        if ( ! $this->cache->redis->get($key) )
        {
            $this->load->library('alexa', $params);
            $response = $this->alexa->getUrlInfo();
            $this->cache->redis->save($key, $response, 86400);
        }
        return $this->cache->redis->get($key);
     }

}
