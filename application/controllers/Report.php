<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("attest_model");
    }

    function index($status = ''){
        $roles = array(1,4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Report';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->input->post('occupation_id', TRUE) ? $this->input->post('occupation_id', TRUE) : 0;
        $data['role_id'] = $role_id;
        $data['status'] = $status;
        $data['occupation_select'] = get_occupation($occupation_id);
        $data['content'] = $this->load->view('report/view_attest_report', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function email_log(){
        $roles = array(1);
        checkUserAccess($roles);
        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Report';
        $data['content'] = $this->load->view('report/view_email_log', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function application_track($attest_id, $user_id){
        $roles = array(1,2);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Report';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $logged_user_id = $this->session->userdata['logged_in']['id'];
        if ($logged_user_id != $user_id){
            $this->session->set_flashdata('success_response', 'Access Denied!');
            redirect(site_url('dashboard'));
        }
        $data['role_id'] = $role_id;
        $data['attest_id'] = $attest_id;
        $data['user_id'] = $logged_user_id;
        $data['content'] = $this->load->view('report/view_application_track', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function courier_sent($courier = ''){
        $roles = array(1,3,5);
        checkUserAccess($roles);
        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Report';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['courier'] = $courier;
        $data['content'] = $this->load->view('report/view_courier_sent', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function attest_detail($attest_request_id){
        $roles = array(1,2,3,4,5);
        checkUserAccess($roles);
        $where = "";
        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Attestation';
        $application_status = getsinglefield('tbl_user_attestation','status','WHERE id = "'.$attest_request_id.'"');
        $data['result'] = $this->attest_model->get_attest_document_details($attest_request_id);
        $data['not_received_doc_count'] = $this->common_model->counttotal('tbl_user_attestation_document','user_attestation_id = "'.$attest_request_id.'" AND is_courier_recieved = "N"');
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        if ($application_status == 'cancelled'){
            $this->session->set_flashdata('success_response', "This Application is cancelled and cannot be processed further.");
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('cn_number', 'CN#', 'trim|required|is_unique[tbl_user_attestation.cn_number]');
        if ($this->form_validation->run() == TRUE) {
            $old_status = $this->input->post('old_status', TRUE);
            $update['cn_number'] = $this->input->post('cn_number', TRUE);
            $update['current_status'] = $this->input->post('current_status', TRUE);
            /// Courier Receiving Person Information
            $update['courier_receive_role'] = $role_id;
            $update['courier_receive_role_name'] = !empty($role_id) && $role_id > 0 ? getsinglefield('tbl_roles','role_name', 'WHERE id = "'.$role_id.'"') : '';
            $update['courier_receive_user_id'] = $user_id;
            $update['courier_receive_user_name'] = !empty($user_id) && $user_id > 0 ? getsinglefield('tbl_users','fullname', 'WHERE id = "'.$user_id.'"') : '';
            ////////////////////////////////////////////////////////////
            $update['courier_receive_date'] = date('Y-m-d H:i:s');
            ////////////////////////////////////////////////////////////
            $upateWhr['id'] = $attest_request_id;
            $this->common_model->update('tbl_user_attestation', $update, $upateWhr);
            $log_id = $this->common_model->app_status_log($attest_request_id, $data['result'][0]['app_number'], $update['cn_number'], '', $update['current_status'], $user_id, $update['courier_receive_role'], $update['courier_receive_role_name']);
            $this->_send_courier_received_email($update['cn_number'], $data['result'][0]['fullname'], $data['result'][0]['email'], $data['result'][0]['app_number'], $data['result'][0]['cnic']);
        //    $this->common_model->app_status_email('', $data['result'][0]['fullname'], $data['result'][0]['email'], $data['result'][0]['app_number'], $data['result'][0]['cnic'], $update['cn_number'], '', 'courier_app_received');

            $this->session->set_flashdata('success_response', "CN# Entered Successfully...");
            if ($old_status != '') {
                redirect(site_url('attestation/'.$old_status));
            }else{
                redirect(site_url('courier/centers'));
            }
        }
        $data['role_id'] = $role_id;
        $data['attest_id'] = $attest_request_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('report/attest_detail', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _send_courier_received_email($cn_number = '', $full_name = "", $to = '', $app_no = '', $user_cnic = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'courier_app_received'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}", "{courier_name}", "{cn_number}");
        $replace = array($full_name, $to, $app_no, $user_cnic, "TCS", $cn_number);
        $message = str_replace($find, $replace, $message);
        $message = "".$message."";
        $From = "noreply@ppwnap.gov.pk";
        $From = "noreply@nhsrc.gov.pk";
    //    $From = "";
        $FromName = "Ministry of Health";
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email($to, $subject, $message, $From, $FromName);
        }
        $this->session->set_flashdata('success_response', 'Status Change Email has been sent!');
        //    redirect($_SERVER['HTTP_REFERER']);
    }

    function _send_courier_dispatched_email($cn_number = '', $full_name = "", $to = '', $app_no = '', $user_cnic = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'courier_app_dispatched'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{courier_name}", "{user_cnic}", "{cn_number}");
        $replace = array($full_name, $to, $app_no, 'TCS', $user_cnic, $cn_number);
        $message = str_replace($find, $replace, $message);
        $message = "".$message."";
        $From = "noreply@ppwnap.gov.pk";
        $From = "noreply@nhsrc.gov.pk";
    //    $From = "";
        $FromName = "Ministry of Health";
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email($to, $subject, $message, $From, $FromName);
        }
        $this->session->set_flashdata('success_response', 'Status Change Email has been sent!');
        //    redirect($_SERVER['HTTP_REFERER']);
    }

}
