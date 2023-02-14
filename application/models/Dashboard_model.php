<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
    /* ------------------constructor goes here-------------- */

    function __construct(){
        parent::__construct();
    }

    function get_application_count($param = array(), $status = '', $current_status = '', $source = '', $courier_role = '') {
    /*
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
    */
        $this->db->select("id");
        $this->db->from('tbl_user_attestation');
        if (!empty($param)) {

        }
        if ($status != ''){
            $this->db->where('tbl_user_attestation.status', $status);
        }else{
            $this->db->where('tbl_user_attestation.status !=', 'pending');
        }
        if ($current_status != ''){
            $this->db->where('tbl_user_attestation.current_status', $current_status);
        }
        if ($source != ''){
            $this->db->where('tbl_user_attestation.source', $source);
        }
        if ($courier_role != ''){
            $this->db->where('tbl_user_attestation.courier_receive_role', $courier_role);
        }
        return $this->db->count_all_results();
    }

    function get_application_document_count($param = array(), $status = '', $current_status = '') {
        $this->db->select("id");
        $this->db->from('tbl_user_attestation_document');
        $this->db->join('tbl_user_attestation', "tbl_user_attestation_document.user_attestation_id = tbl_user_attestation.id");
        if (!empty($param)) {

        }
        if ($status != ''){
            $this->db->where('tbl_user_attestation_document.status', $status);
        }
        if ($current_status != ''){
            $this->db->where('tbl_user_attestation.current_status', $current_status);
        }
        return $this->db->count_all_results();
    }

    function get_occupation_count($param = array()) {
        $session_data = $this->session->userdata('logged_in');
        $role_id = $session_data['role_id'];
    /*
        $this->db->select("
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 1 THEN 1 END), 0) AS doctor,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 2 THEN 1 END), 0) AS nurse,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 3 THEN 1 END), 0) AS paramedic,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 4 THEN 1 END), 0) AS pharmacist,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 5 THEN 1 END), 0) AS homeopathic,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 6 THEN 1 END), 0) AS tabib,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 7 THEN 1 END), 0) AS physiotherapist,
            COALESCE( COUNT( CASE WHEN tbl_users.occupation_id = 8 THEN 1 END), 0) AS other,
            tbl_users.occupation
        ");
    */
        $this->db->select("
            COUNT(tbl_users.occupation_id) AS count,
            tbl_users.occupation
        ");

        $this->db->from('tbl_users');
        if (!empty($param)) {

        }
        $this->db->where('tbl_users.role_id', 2);
    //    $this->db->where('tbl_users.status', 'Y');
        $this->db->order_by('tbl_users.occupation', 'ASC');
    //    $this->db->group_by('tbl_users.occupation_id, tbl_users.occupation');
        $this->db->group_by('tbl_users.occupation_id');
        $query = $this->db->get();
    //    print $this->db->last_query();
    //    die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

    function get_courier_received_until_returned_count($param = array(), $courier_receive_role = '', $status = '') {
        $this->db->select("id");
        $this->db->from('tbl_user_attestation');
        if (!empty($param)) {

        }
        if ($courier_receive_role != ''){
            $this->db->where('tbl_user_attestation.courier_receive_role', $courier_receive_role);
        }
        if ($status != ''){
            $this->db->where('tbl_user_attestation.status', $status);
        }
        $this->db->where('tbl_user_attestation.source', 'courier');
        $this->db->where('(tbl_user_attestation.current_status = "courier_received" OR tbl_user_attestation.current_status = "ministry_received" OR tbl_user_attestation.current_status = "ministry_dispatched")');
        return $this->db->count_all_results();
    }

}
