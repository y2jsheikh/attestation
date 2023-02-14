<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attest_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function get_contents($cnic = '', $occupation = '', $status = '', $app_number = '', $current_status = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_attestation.id,
            tbl_user_attestation.user_id,
            tbl_user_attestation.app_number,
            tbl_user_attestation.is_application_form,
            tbl_user_attestation.is_affidavit_attested,
            tbl_user_attestation.is_copy_of_degree,
            tbl_user_attestation.is_copy_of_pmc,
            tbl_user_attestation.is_copy_of_pmdc,
            tbl_user_attestation.is_copy_of_pnc,
            tbl_user_attestation.is_copy_of_crc,
            tbl_user_attestation.is_copy_of_cnic,
            tbl_user_attestation.is_copy_of_passport,
            tbl_user_attestation.is_copy_of_experience,
            tbl_user_attestation.is_orignal_doc_attached,
            tbl_user_attestation.no_of_docs,
            tbl_user_attestation.province,
            tbl_user_attestation.province_id,
            tbl_user_attestation.cn_number,
            tbl_user_attestation.courier_receive_role_name,
            tbl_user_attestation.source,
            tbl_user_attestation.status,
            tbl_user_attestation.current_status,
            tbl_user_attestation.application_submitted,
            tbl_user_attestation.created AS attest_request_date
        ");
        $this->db->select('
            tbl_users.fullname,
            tbl_users.fullname AS user_name,
            tbl_users.father_name,
            tbl_users.dob,
            tbl_users.domicile,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender,
            tbl_users.marital_status,
            tbl_users.occupation,
            tbl_users.occupation_id,
            tbl_users.add_occupation,
            tbl_users.add_occupation_id
        ');
        $this->db->from('tbl_user_attestation');
        $this->db->join('tbl_users', "tbl_user_attestation.user_id = tbl_users.id");
        if ($app_number != ''){
            $this->db->where('tbl_user_attestation.app_number', $app_number);
        }
        if ($cnic != ''){
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($occupation != ''){
            $this->db->where('tbl_users.occupation_id', $occupation);
        }
        if ($status != ''){
            if ($status == 'processed'){
                $this->db->where('tbl_user_attestation.status !=', 'pending');
            }else{
                $this->db->where('tbl_user_attestation.status', $status);
            }
        //    $this->db->where('(tbl_user_attestation.status = "'.$status.'" OR tbl_user_attestation.status = "partially_attested")');
        }
        if ($current_status != ''){
            $this->db->where('tbl_user_attestation.current_status', $current_status);
        }
        if ($role_id == 3 || $role_id == 5){
            $this->db->where('tbl_user_attestation.source', 'courier');
            if ($role_id == 3){
                $this->db->where('(tbl_user_attestation.province_id != 4 AND tbl_user_attestation.province_id != 8)');
            }elseif ($role_id == 5){
                $this->db->where('(tbl_user_attestation.province_id = 4 OR tbl_user_attestation.province_id = 8)');
            }
        }
        /*
        if ($role_id == 3){
            $this->db->where('tbl_user_attestation.current_status', 'user_submitted');
        }
        if ($role_id == 4){
        //    $this->db->where('tbl_user_attestation.current_status', 'ministry_received');
            $this->db->where('(tbl_user_attestation.current_status = "ministry_received" OR tbl_user_attestation.current_status = "ministry_dispatched" OR tbl_user_attestation.current_status = "courier_dispatched")');
        }
        */
    //    $this->db->where('tbl_user_attestation.deleted', 'N');
        $this->db->order_by('tbl_user_attestation.id', 'DESC');
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

    function get_attest_user_details($attest_id, $user_id) {
        $session_data = $this->session->userdata('logged_in');
        //    $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_attestation.id,
            tbl_user_attestation.user_id,
            tbl_user_attestation.app_number,
            tbl_user_attestation.is_application_form,
            tbl_user_attestation.is_affidavit_attested,
            tbl_user_attestation.is_copy_of_degree,
            tbl_user_attestation.is_copy_of_pmc,
            tbl_user_attestation.is_copy_of_pmdc,
            tbl_user_attestation.is_copy_of_pnc,
            tbl_user_attestation.is_copy_of_crc,
            tbl_user_attestation.is_copy_of_cnic,
            tbl_user_attestation.is_copy_of_passport,
            tbl_user_attestation.is_copy_of_experience,
            tbl_user_attestation.is_orignal_doc_attached,
            tbl_user_attestation.no_of_docs,
            tbl_user_attestation.province,
            tbl_user_attestation.province_id,
            tbl_user_attestation.courier_receive_role_name,
            tbl_user_attestation.source,
            tbl_user_attestation.status,
            tbl_user_attestation.current_status,
            tbl_user_attestation.application_submitted,
            tbl_user_attestation.created
        ");
        $this->db->select('
            tbl_users.fullname AS user_name,
            tbl_users.father_name,
            tbl_users.address,
            tbl_users.dob,
            tbl_users.domicile,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender,
            tbl_users.marital_status,
            tbl_users.occupation,
            tbl_users.occupation_id,
            tbl_users.add_occupation,
            tbl_users.add_occupation_id
        ');
        $this->db->from('tbl_user_attestation');
        $this->db->join('tbl_users', "tbl_user_attestation.user_id = tbl_users.id");
        $this->db->order_by('tbl_user_attestation.id', 'DESC');
        $this->db->where('tbl_user_attestation.id',$attest_id);
        $this->db->where('tbl_user_attestation.user_id',$user_id);
    //    $this->db->where('tbl_user_attestation.deleted', 'N');
        $query = $this->db->get();
        //    print $this->db->last_query();
        //    die;
        if ($query->num_rows() > 0) {
            //    return $query->result_array();
            return $query->row();
        } else {
            return [];
        }
    }

    function get_attest_document_details($attest_id = '', $user_id = '', $cnic = '', $status = '', $app_number = '', $current_status = '') {
        $session_data = $this->session->userdata('logged_in');
    //    $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_user_attestation_document.id,
            tbl_user_attestation_document.user_attestation_id,
            tbl_user_attestation_document.user_qualification_id,
            tbl_user_attestation_document.user_id,
            tbl_user_attestation_document.doc_type,
            tbl_user_attestation_document.doc_exp,
            tbl_user_attestation_document.qualification,
            tbl_user_attestation_document.remarks,
            tbl_user_attestation_document.is_courier_recieved,
            tbl_user_attestation_document.status,
            tbl_user_attestation_document.created
        ");
        $this->db->select('
            tbl_user_qualification.qualification AS user_qualification,
            tbl_user_qualification.institute,
            tbl_user_qualification.completion_year
        ');
        $this->db->select("
            tbl_user_attestation.user_id,
            tbl_user_attestation.app_number,
            tbl_user_attestation.is_application_form,
            tbl_user_attestation.is_affidavit_attested,
            tbl_user_attestation.is_copy_of_degree,
            tbl_user_attestation.is_copy_of_pmc,
            tbl_user_attestation.is_copy_of_pmdc,
            tbl_user_attestation.is_copy_of_pnc,
            tbl_user_attestation.is_copy_of_crc,
            tbl_user_attestation.is_copy_of_cnic,
            tbl_user_attestation.is_copy_of_passport,
            tbl_user_attestation.is_copy_of_experience,
            tbl_user_attestation.is_orignal_doc_attached,
            tbl_user_attestation.no_of_docs,
            tbl_user_attestation.province,
            tbl_user_attestation.province_id,
            tbl_user_attestation.cn_number,
            tbl_user_attestation.source,
            tbl_user_attestation.status AS request_status,
            tbl_user_attestation.current_status,
            tbl_user_attestation.application_submitted,
            tbl_user_attestation.created
        ");
        $this->db->select('
            tbl_users.fullname,
            tbl_users.fullname AS user_name,
            tbl_users.father_name,
            tbl_users.dob,
            tbl_users.domicile,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender,
            tbl_users.marital_status,
            tbl_users.occupation,
            tbl_users.add_occupation,
            tbl_users.picture
        ');
        $this->db->from('tbl_user_attestation_document');
        $this->db->join('tbl_users', "tbl_user_attestation_document.user_id = tbl_users.id");
        $this->db->join('tbl_user_attestation', "tbl_user_attestation_document.user_attestation_id = tbl_user_attestation.id");
        $this->db->join('tbl_user_qualification', "tbl_user_attestation_document.user_qualification_id = tbl_user_qualification.id", "LEFT");
        $this->db->order_by('tbl_user_attestation_document.id', 'DESC');
        if ($attest_id != '') {
            $this->db->where('tbl_user_attestation_document.user_attestation_id', $attest_id);
        }
        if ($user_id != '') {
            $this->db->where('tbl_user_attestation_document.user_id', $user_id);
        }
        if ($cnic != '') {
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($status != '') {
            $this->db->where('tbl_user_attestation.status', $status);
        //    $this->db->where('(tbl_user_attestation.status = "'.$status.'" OR tbl_user_attestation.status = "partially_attested")');
        }
        if ($app_number != '') {
            $this->db->where('tbl_user_attestation.app_number', $app_number);
        }
        if ($current_status != '') {
        //    user_submitted
            $this->db->where('tbl_user_attestation.current_status', $current_status);
        }
    //    $this->db->where('tbl_user_attestation.deleted', 'N');
        $query = $this->db->get();
        //    print $this->db->last_query();
        //    die;
        if ($query->num_rows() > 0) {
        return $query->result_array();
        //    return $query->row();
        } else {
            return [];
        }
    }

    function get_scheduled_contents($cnic = '', $from_date = '', $to_date = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select("
            tbl_schedular.id,
            tbl_schedular.visit_date,
            tbl_schedular.slot
        ");
        $this->db->select("
            tbl_users.fullname AS applicant
        ");
        $this->db->from('tbl_schedular');
        $this->db->join('tbl_users', "tbl_schedular.user_id = tbl_users.id");
        if ($cnic != ''){
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($from_date != ''){
            $this->db->where('tbl_schedular.visit_date >=', $from_date);
        }
        if ($to_date != ''){
            $this->db->where('tbl_schedular.visit_date <=', $to_date);
        }
    //    $this->db->where('tbl_schedular.visit_date >=', date('m/d/Y'));
    //    $this->db->where('tbl_user_attestation.deleted', 'N');
        $this->db->order_by('tbl_schedular.id', 'ASC');
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

    function get_courier_sent_contents($attest_id = '', $user_id = '', $cnic = '', $status = '', $app_number = '', $cn_number = '', $current_status = '', $from_date = '', $to_date = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $logged_user_id = $session_data['id'];
        $role_id = $session_data['role_id'];

        /*
        $beginOfDay = strtotime("today", time());
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
        */

        $beginOfDay = date('Y-m-d 00:00:00');
        $endOfDay = date('Y-m-d 23:59:59');
        $from_date = $from_date != '' ? $from_date.' 00:00:00' : $beginOfDay;
        $to_date = $to_date != '' ? $to_date.' 23:59:59' : $endOfDay;

        $this->db->select("
            tbl_user_attestation_document.id,
            tbl_user_attestation_document.user_attestation_id,
            tbl_user_attestation_document.user_qualification_id,
            tbl_user_attestation_document.doc_type,            
            tbl_user_attestation_document.doc_exp,
            tbl_user_attestation_document.qualification,
            tbl_user_attestation_document.remarks,
            tbl_user_attestation_document.is_courier_recieved,
            tbl_user_attestation_document.status,
            GROUP_CONCAT(CONCAT(tbl_user_attestation_document.qualification, ' (', tbl_user_attestation_document.doc_type, ')') SEPARATOR '<br/>') AS qualification_1
        ");
        $this->db->select('
            tbl_user_qualification.qualification AS user_qualification,
            tbl_user_qualification.institute,
            tbl_user_qualification.completion_year
        ');
        $this->db->select("
            tbl_user_attestation.app_number,
            tbl_user_attestation.is_application_form,
            tbl_user_attestation.is_affidavit_attested,
            tbl_user_attestation.is_copy_of_degree,
            tbl_user_attestation.is_copy_of_pmc,
            tbl_user_attestation.is_copy_of_pmdc,
            tbl_user_attestation.is_copy_of_pnc,
            tbl_user_attestation.is_copy_of_crc,
            tbl_user_attestation.is_copy_of_cnic,
            tbl_user_attestation.is_copy_of_passport,
            tbl_user_attestation.is_copy_of_experience,
            tbl_user_attestation.is_orignal_doc_attached,
            tbl_user_attestation.no_of_docs,
            tbl_user_attestation.province,
            tbl_user_attestation.province_id,
            tbl_user_attestation.cn_number,
            tbl_user_attestation.courier_receive_role_name,
            tbl_user_attestation.courier_receive_user_name,
            tbl_user_attestation.courier_receive_date,
            tbl_user_attestation.source,
            tbl_user_attestation.status AS request_status,
            tbl_user_attestation.current_status,
            tbl_user_attestation.application_submitted,
            tbl_user_attestation.created
        ");
        $this->db->select('
            tbl_users.fullname,
            tbl_users.fullname AS user_name,
            tbl_users.father_name,
            tbl_users.dob,
            tbl_users.domicile,
            tbl_users.contact_number,
            tbl_users.cnic,
            tbl_users.email,
            tbl_users.gender,
            tbl_users.marital_status,
            tbl_users.occupation,
            tbl_users.add_occupation,
            tbl_users.picture
        ');
        $this->db->from('tbl_user_attestation_document');
        $this->db->join('tbl_users', "tbl_user_attestation_document.user_id = tbl_users.id");
        $this->db->join('tbl_user_attestation', "tbl_user_attestation_document.user_attestation_id = tbl_user_attestation.id");
        $this->db->join('tbl_user_qualification', "tbl_user_attestation_document.user_qualification_id = tbl_user_qualification.id", "LEFT");
        if ($attest_id != '') {
            $this->db->where('tbl_user_attestation_document.user_attestation_id', $attest_id);
        }
        if ($user_id != '') {
            $this->db->where('tbl_user_attestation_document.user_id', $user_id);
        }
        if ($cnic != '') {
            $this->db->where('tbl_users.cnic', $cnic);
        }
        if ($status != '') {
            $this->db->where('tbl_user_attestation.status', $status);
        //    $this->db->where('(tbl_user_attestation.status = "'.$status.'" OR tbl_user_attestation.status = "partially_attested")');
        }
        if ($app_number != '') {
            $this->db->where('tbl_user_attestation.app_number', $app_number);
        }
        if ($cn_number != '') {
            $this->db->where('tbl_user_attestation.cn_number', $cn_number);
        }
        if ($current_status != '') {
            //    user_submitted
            $this->db->where('tbl_user_attestation.current_status', $current_status);
        }
        /*
        $this->db->where('tbl_user_attestation.courier_receive_date >=', $from_date);
        $this->db->where('tbl_user_attestation.courier_receive_date <=', $to_date);
        */
        $this->db->where('tbl_user_attestation.cn_number !=', '');
        $this->db->where('tbl_user_attestation.courier_receive_user_id', $logged_user_id);
        $this->db->order_by('tbl_user_attestation_document.id', 'DESC');
        $this->db->group_by('tbl_user_attestation_document.user_attestation_id');
    //    $this->db->group_by('tbl_user_attestation_document.user_attestation_id, tbl_user_attestation_document.qualification, tbl_user_attestation_document.doc_type');
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

    function get_application_track($attest_id = '', $app_number = '', $limit = '', $start = ''){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $role_id = $session_data['role_id'];
        $this->db->select('
            tbl_app_status_log.app_number,
            tbl_app_status_log.courier_role_id,
            tbl_app_status_log.courier_role,
            tbl_app_status_log.cn_number,
            tbl_app_status_log.status,
            tbl_app_status_log.source,
            tbl_app_status_log.current_status,
            tbl_app_status_log.date
        ');
    //    $this->db->select('tbl_users.fullname AS user_name');
        $this->db->from('tbl_app_status_log');
    //    $this->db->join('tbl_users', "tbl_app_status_log.user_id = tbl_users.id");
        if ($attest_id != ''){
            $this->db->where('tbl_app_status_log.attest_id', $attest_id);
        }
        if ($app_number != ''){
            $this->db->where('tbl_app_status_log.app_number', $app_number);
        }
        $this->db->order_by('tbl_app_status_log.id', 'ASC');
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