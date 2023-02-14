<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qualification_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function unique_check($qualification_id, $user_id, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_user_qualification');
        $this->db->where('qualification_id', $qualification_id);
        $this->db->where('user_id', $user_id);
        if ($id != 0) {
            $this->db->where('id!=', $id);
        }
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_contents($qualification = '', $limit = '', $start = '') {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_qualification.id,
            tbl_user_qualification.institute,
            tbl_user_qualification.qualification_area,
            tbl_user_qualification.completion_year,
            tbl_user_qualification.qualification,
            tbl_user_qualification.status,
            tbl_user_qualification.created
        ");
        $this->db->select('tbl_users.fullname AS user_name');
    //    $this->db->select('tbl_qualification.name AS qualification');
        $this->db->from('tbl_user_qualification');
        $this->db->join('tbl_users', "tbl_user_qualification.user_id = tbl_users.id");
    //    $this->db->join('tbl_qualification', "tbl_user_qualification.qualification_id = tbl_qualification.id");
        $this->db->order_by('tbl_user_qualification.id', 'DESC');
        if ($qualification != '') {
            $this->db->like('tbl_user_qualification.qualification', $qualification, 'BOTH');
        }
        if ($role_id != 1){
            $this->db->where('tbl_user_qualification.user_id', $user_id);
        }
        if ($limit > 0) {
            $this->db->limit($limit, $start);
            $query = $this->db->get();
//            print $this->db->last_query();
//            die;
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return [];
            }
        } else {
            return $this->db->count_all_results();
        }
    }

    function get_user_qualifications($id = '', $user_id = ''){
        $this->db->select('
            tbl_user_qualification.id,
            tbl_user_qualification.qualification
        ');
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_qualification');
        $this->db->join('tbl_users', "tbl_user_qualification.user_id = tbl_users.id");
        if ($id != '') {
            $this->db->where('tbl_user_qualification.id', $id);
        }
        if ($user_id != '') {
            $this->db->where('tbl_user_qualification.user_id', $user_id);
        }
    //    $this->db->where('tbl_user_qualification.status', 'pending');
        $this->db->where('(tbl_user_qualification.status = "pending" OR tbl_user_qualification.status = "rejected")');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        if ($id != '') {
            $result = $query->row();
        }else{
            $result = $query->result();
        }
        return $result;
    }

    function get_details($id = ''){
        $this->db->select('
            tbl_user_qualification.id,
            tbl_user_qualification.user_id,
            tbl_user_qualification.qualification_area,
            tbl_user_qualification.qualification_id,
            tbl_user_qualification.qualification,
            tbl_user_qualification.institute,
            tbl_user_qualification.completion_year,
            tbl_user_qualification.status,
            tbl_user_qualification.created,
            tbl_user_qualification.created_by,
            tbl_user_qualification.updated,
            tbl_user_qualification.created_by
        ');
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_qualification');
        $this->db->join('tbl_users', "tbl_user_qualification.user_id = tbl_users.id");
        $this->db->where('tbl_user_qualification.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

}

#End of class