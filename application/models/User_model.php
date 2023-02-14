<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function unique_check($username, $clinicid, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('username', $username);
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

    function get_contents($search_text = '', $cnic = '', $search_role = '', $limit = '', $start = '') {
        $session_data = $this->session->userdata('logged_in');
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_users.id,
            tbl_users.username,
            tbl_users.role_id,
            tbl_users.fullname,
            tbl_users.status,
            tbl_users.password,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender,
            tbl_users.picture,
            tbl_users.created
        ");
        $this->db->from('tbl_users');
        $this->db->where("tbl_users.role_id !=", 1);
        $this->db->order_by('tbl_users.id', 'DESC');
        if ($search_text != '') {
            $this->db->like('tbl_users.fullname', $search_text, 'Both');
        }
        if ($cnic != '') {
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($search_role != '') {
            $this->db->where('tbl_users.role_id', $search_role);
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

    function get_details($tbl, $fld, $val){
        $this->db->select('role_name');
        $this->db->from($tbl);
        $this->db->where($fld, $val);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

    function get_all_details($id = ''){
        $this->db->select('tbl_users.*,tbl_roles.role_name');
        $this->db->from('tbl_users');
        $this->db->join('tbl_roles', "tbl_users.role_id=tbl_roles.id", "LEFT");

        $this->db->where('tbl_users.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->row();
    }

    function unique_cnic_check($cnic, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('cnic', $cnic);
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

    function unique_email_check($email, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('email', $email);
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

    function unique_ecfmg_check($ecfmg, $id = 0){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('ecfmg_no', $ecfmg);
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

}

#End of class