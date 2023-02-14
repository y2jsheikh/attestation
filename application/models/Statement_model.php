<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Statement_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function get_contents($ecfmg_no = '', $pmc_no = '', $cnic = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_user_statement_of_need.id,
            tbl_user_statement_of_need.app_number,
            tbl_user_statement_of_need.contract_letter,
            tbl_user_statement_of_need.ecfmg_certificate,
            tbl_user_statement_of_need.cnic_copy,
            tbl_user_statement_of_need.other_file,
            tbl_user_statement_of_need.post_grad_training,
            tbl_user_statement_of_need.statement_of_need_file,
            tbl_user_statement_of_need.user_application_submitted,
            tbl_user_statement_of_need.application_submitted,
            tbl_user_statement_of_need.user_comment,
            tbl_user_statement_of_need.ministry_comment,
            tbl_user_statement_of_need.signatory_id,
            tbl_user_statement_of_need.signatory,
            tbl_user_statement_of_need.is_pmc_reg,
            tbl_user_statement_of_need.created,
            tbl_user_statement_of_need.status
        ');
        $this->db->select('
            tbl_users.id AS user_id,
            tbl_users.fullname,
            tbl_users.father_name,
            tbl_users.ecfmg_no,
            tbl_users.pmc_no,
            tbl_users.cnic
        ');
        $this->db->from('tbl_user_statement_of_need');
        $this->db->join('tbl_users', "tbl_user_statement_of_need.user_id = tbl_users.id");
        if ($ecfmg_no != ''){
            $this->db->where('tbl_users.ecfmg_no', $ecfmg_no);
        }
        if ($pmc_no != ''){
            $this->db->where('tbl_users.pmc_no', $pmc_no);
        }
        if ($cnic != ''){
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($role_id == 4) {
            $this->db->where('tbl_user_statement_of_need.user_application_submitted', 'Y');
            $this->db->where('tbl_user_statement_of_need.status !=', 'pending');
        } elseif ($role_id == 2){
            $this->db->where('tbl_user_statement_of_need.created_by', $user_id);
        }
        $this->db->order_by('tbl_user_statement_of_need.id', 'DESC');
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

    function get_receive_contents($ecfmg_no = '', $pmc_no = '', $cnic = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_user_statement_of_need.id,
            tbl_user_statement_of_need.app_number,
            tbl_user_statement_of_need.contract_letter,
            tbl_user_statement_of_need.ecfmg_certificate,
            tbl_user_statement_of_need.cnic_copy,
            tbl_user_statement_of_need.other_file,
            tbl_user_statement_of_need.statement_of_need_file,
            tbl_user_statement_of_need.user_application_submitted,
            tbl_user_statement_of_need.application_submitted,
            tbl_user_statement_of_need.user_comment,
            tbl_user_statement_of_need.ministry_comment,
            tbl_user_statement_of_need.signatory_id,
            tbl_user_statement_of_need.signatory,
            tbl_user_statement_of_need.is_pmc_reg,
            tbl_user_statement_of_need.created,
            tbl_user_statement_of_need.status
        ');
        $this->db->select('
            tbl_users.id AS user_id,
            tbl_users.fullname,
            tbl_users.father_name,
            tbl_users.ecfmg_no,
            tbl_users.pmc_no,
            tbl_users.cnic
        ');
        $this->db->from('tbl_user_statement_of_need');
        $this->db->join('tbl_users', "tbl_user_statement_of_need.user_id = tbl_users.id");
        if ($ecfmg_no != ''){
            $this->db->where('tbl_users.ecfmg_no', $ecfmg_no);
        }
        if ($pmc_no != ''){
            $this->db->where('tbl_users.pmc_no', $pmc_no);
        }
        if ($cnic != ''){
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($role_id == 2){
            $this->db->where('tbl_user_statement_of_need.created_by', $user_id);
        }
        $this->db->where('tbl_user_statement_of_need.status', 'pending');
        $this->db->where('tbl_user_statement_of_need.user_application_submitted', 'Y');
        $this->db->order_by('tbl_user_statement_of_need.id', 'DESC');
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

    function get_statement_of_need_details($statement_id){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_user_statement_of_need.id,
            tbl_user_statement_of_need.app_number,
            tbl_user_statement_of_need.qualification,
            tbl_user_statement_of_need.post_qualification,
            tbl_user_statement_of_need.institute,
            tbl_user_statement_of_need.special_need_remarks,
            tbl_user_statement_of_need.contract_letter,
            tbl_user_statement_of_need.ecfmg_certificate,
            tbl_user_statement_of_need.cnic_copy,
            tbl_user_statement_of_need.other_file,
            tbl_user_statement_of_need.statement_of_need_file,
            tbl_user_statement_of_need.pass_year,
            tbl_user_statement_of_need.speciality,
            tbl_user_statement_of_need.years,
            tbl_user_statement_of_need.training_institute,
            tbl_user_statement_of_need.is_gov_employee,
            tbl_user_statement_of_need.post_grad_training,
            tbl_user_statement_of_need.is_pmc_reg,
            tbl_user_statement_of_need.is_special_need,
            tbl_user_statement_of_need.user_application_submitted,
            tbl_user_statement_of_need.application_submitted,
            tbl_user_statement_of_need.user_comment,
            tbl_user_statement_of_need.ministry_comment,
            tbl_user_statement_of_need.signatory_id,
            tbl_user_statement_of_need.signatory,
            tbl_user_statement_of_need.status
        ');
        $this->db->select('
            tbl_users.id AS user_id,
            tbl_users.fullname,
            tbl_users.father_name,
            tbl_users.ecfmg_no,
            tbl_users.pmc_no,
            tbl_users.address,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender
        ');
        $this->db->select('
            tbl_signatory.designation AS signatory_designation,
            tbl_signatory.department AS signatory_department
        ');
        $this->db->from('tbl_user_statement_of_need');
        $this->db->join('tbl_users', "tbl_user_statement_of_need.user_id = tbl_users.id");
        $this->db->join('tbl_signatory', "tbl_user_statement_of_need.signatory_id = tbl_signatory.id", "LEFT");
        $this->db->where('tbl_user_statement_of_need.id', $statement_id);
        $query = $this->db->get();
        return $query->row();
    }

}

#End of class