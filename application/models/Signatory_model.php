<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signatory_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function get_contents($name = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_signatory.id,
            tbl_signatory.name,
            tbl_signatory.designation,
            tbl_signatory.department,
            tbl_signatory.status,
            tbl_signatory.created
        ');
        $this->db->from('tbl_signatory');
        if ($name != ''){
            $this->db->where('tbl_signatory.name', $name);
        }
        $this->db->order_by('tbl_signatory.id', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
            $query = $this->db->get();
        //    print $this->db->last_query();
        //    die;
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return [];
            }
        } else {
            return $this->db->count_all_results();
        }
    }

    function get_signatory_details($signatory_id){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_signatory.id,
            tbl_signatory.name,
            tbl_signatory.designation,
            tbl_signatory.department,
            tbl_signatory.status
        ');
        $this->db->from('tbl_signatory');
        $this->db->where('tbl_signatory.id', $signatory_id);
        $query = $this->db->get();
        return $query->row();
    }

}

#End of class