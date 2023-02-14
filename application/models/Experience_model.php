<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Experience_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function unique_check($emp_type, $user_id, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_user_experience');
        $this->db->where('emp_type', $emp_type);
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

    function get_contents($emp_type = '', $limit = '', $start = '') {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_experience.id,
            tbl_user_experience.designation,
            tbl_user_experience.institute,
            tbl_user_experience.emp_type,
            tbl_user_experience.start_date,
            tbl_user_experience.end_date,
            tbl_user_experience.is_currently_working,
            tbl_user_experience.status,
            tbl_user_experience.created
        ");
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_experience');
        $this->db->join('tbl_users', "tbl_user_experience.user_id = tbl_users.id");
        $this->db->order_by('tbl_user_experience.id', 'DESC');
        if ($emp_type != '') {
            $this->db->where('tbl_user_experience.emp_type', $emp_type);
        }
        if ($role_id != 1){
            $this->db->where('tbl_user_experience.user_id', $user_id);
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

    function get_overseas_contents($country = '', $limit = '', $start = '') {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_overseas_experience.id,
            tbl_user_overseas_experience.country,
            tbl_user_overseas_experience.institute,
            tbl_user_overseas_experience.position,
            tbl_user_overseas_experience.joining_date,
            tbl_user_overseas_experience.purpose,
            tbl_user_overseas_experience.status,
            tbl_user_overseas_experience.created
        ");
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_overseas_experience');
        $this->db->join('tbl_users', "tbl_user_overseas_experience.user_id = tbl_users.id");
        $this->db->order_by('tbl_user_overseas_experience.id', 'DESC');
        if ($country != '') {
            $this->db->where('tbl_user_overseas_experience.country', $country);
        }
        if ($role_id != 1){
            $this->db->where('tbl_user_overseas_experience.user_id', $user_id);
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

    function get_details($id = ''){
        $this->db->select('
            tbl_user_experience.id,
            tbl_user_experience.user_id,
            tbl_user_experience.emp_type,
            tbl_user_experience.designation,
            tbl_user_experience.institute,
            tbl_user_experience.start_date,
            tbl_user_experience.end_date,
            tbl_user_experience.is_currently_working,
            tbl_user_experience.status,
            tbl_user_experience.created,
            tbl_user_experience.created_by,
            tbl_user_experience.updated,
            tbl_user_experience.created_by
        ');
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_experience');
        $this->db->join('tbl_users', "tbl_user_experience.user_id = tbl_users.id");
        $this->db->where('tbl_user_experience.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

    function get_overseas_details($id = ''){
        $this->db->select('
            tbl_user_overseas_experience.id,
            tbl_user_overseas_experience.user_id,
            tbl_user_overseas_experience.country,
            tbl_user_overseas_experience.institute,
            tbl_user_overseas_experience.position,
            tbl_user_overseas_experience.joining_date,
            tbl_user_overseas_experience.purpose,
            tbl_user_overseas_experience.status,
            tbl_user_overseas_experience.created,
            tbl_user_overseas_experience.created_by,
            tbl_user_overseas_experience.updated,
            tbl_user_overseas_experience.created_by
        ');
        $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_user_overseas_experience');
        $this->db->join('tbl_users', "tbl_user_overseas_experience.user_id = tbl_users.id");
        $this->db->where('tbl_user_overseas_experience.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

}

#End of class