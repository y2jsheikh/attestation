<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_contents($search_text = '', $limit = 10, $start = 0)
    {
        $this->db->select('tbl_roles.*');
        $this->db->from('tbl_roles');
        $this->db->limit($limit, $start);
        if ($search_text != '') {
            $this->db->like('tbl_roles.role_name', $search_text, 'both');
        }
        $this->db->where('tbl_roles.id != 1');
        $this->db->order_by('tbl_roles.role_name', 'ASC');
        $query = $this->db->get();
        return $result = $query->result();
    }

    function total_count($search_text = '')
    {
        $this->db->select('tbl_roles.*');
        $this->db->where('tbl_roles.id != 1');
        $this->db->from('tbl_roles');
        if ($search_text != '') {
            $this->db->like('tbl_roles.role_name', $search_text, 'both');
        }
        return $this->db->count_all_results();
    }

    function get_all_details($id = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_roles');
        $this->db->where('tbl_roles.id', $id);
        $this->db->where('tbl_roles.id != 1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

    function unique_check($role_name,$id)
    {
        $this->db->select('*');
        $this->db->from('tbl_roles');
        $this->db->where('role_name', $role_name);
        $this->db->where('id !=', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getRoleMapping($role_id ,$parent_id = 0){
        $this->db->select("module_name,class_name,method_name,parent_id,tbl_modules.id as m_id");
        $this->db->where("parent_id",$parent_id);
        $query =   $this->db->get("tbl_modules");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getAssigned($role_id){
        $this->db->select("module_id");
        $this->db->where("role_id",$role_id);
        $query =   $this->db->get("tbl_role_mod_maping");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}

#End of class