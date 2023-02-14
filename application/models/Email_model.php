<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function get_log_contents($to = '', $send_status = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_email_log.id,
            tbl_email_log.message,
            tbl_email_log.from,
            tbl_email_log.to,
            tbl_email_log.send_status,
            tbl_email_log.datetime
        ");
    //    $this->db->select('tbl_users.fullname');
        $this->db->from('tbl_email_log');
    //    $this->db->join('tbl_users', "tbl_users.id = tbl_email_log.created_by", "LEFT");
        if ($to != ''){
            $this->db->like('tbl_email_log.to', $to, 'Both');
        }
        if ($send_status != ''){
            $this->db->where('tbl_email_log.send_status', $send_status);
        }
        $this->db->order_by('tbl_email_log.id', 'DESC');
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

}

#End of class