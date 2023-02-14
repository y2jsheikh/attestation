<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("user_model");
    }

    function get_district(){
        $id = $this->input->post('province', TRUE);
        $multiple = $this->input->post('multiple', TRUE);
        $name = $this->input->post('name', TRUE) ? $this->input->post('name', TRUE) : 'districts';
        $default = $this->input->post('default') ? $this->input->post('default') : 0;
        $where = "province_id = '" . $id . "'";
        if (empty($multiple)) {
            $html = get_district_dropdown($default, $where, $name);
        } else {
            $html = get_district_dropdown($default, $where, 'tehsil[]', 'no', 'multiple');
        }
        echo $html;
        exit;
    }

    function get_tehsil(){
        //    echo"12345"; die;
        $multiple = $this->input->post('multiple', TRUE);
        $name = $this->input->post('name', TRUE) ? $this->input->post('name', TRUE) : 'tehsil';
        if (empty($multiple)) {
            $id = $this->input->post('district', TRUE);
            $default = $this->input->post('default') ? $this->input->post('default') : 0;
            $where = "district_id = '" . $id . "'";
            $html = get_tehsil_dropdown($default, $where, $name);
        } else {
            $default = $this->input->post('district[]', TRUE);
            $id = implode(',', $default);
            $where = "district_id IN(" . $id . ")";
            $html = get_tehsil_dropdown($default, $where, 'tehsil[]', 'no', 'multiple');
        }
        echo $html;
        exit;
    }

    function content($page = 0){
        //pre($_POST('action', TRUE), 1);
        $this->load->library('pagination');
        $action = $this->input->post('action');
        //pre($action, 1);
        $output = array();
        switch ($action) {
            case 'user_content':
                $this->load->model("user_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $name = $this->input->post('name', TRUE);
                $cnic = $this->input->post('cnic', TRUE);
                $search_role = $this->input->post('role_id', TRUE);
                $count = $this->user_model->get_contents($name, $cnic, $search_role);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->user_model->get_contents($name, $cnic, $search_role, $config["per_page"], $page);
                $data["role_id"] = $user_role_id;
                $data["timeslot_select"] = get_time_slot('','status = "N"');
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('user/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'user_qualification_content':
                $this->load->model("qualification_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
            //    $qualification_id = $this->input->post('qualification_id', TRUE);
                $qualification = $this->input->post('qualification', TRUE);
                $count = $this->qualification_model->get_contents($qualification);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->qualification_model->get_contents($qualification, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('qualification/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'user_experience_content':
                $this->load->model("experience_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $emp_type = $this->input->post('emp_type', TRUE);
                $count = $this->experience_model->get_contents($emp_type);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->experience_model->get_contents($emp_type, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('experience/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'user_overseas_experience_content':
                $this->load->model("experience_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $country = $this->input->post('country', TRUE);
                $count = $this->experience_model->get_overseas_contents($country);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->experience_model->get_overseas_contents($country, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('experience/overseas_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'signatory_content':
                $this->load->model("signatory_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $name = $this->input->post('name', TRUE);
                $count = $this->signatory_model->get_contents($name);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->signatory_model->get_contents($name, $config["per_page"], $page);
                $data["role_id"] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('signatory/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'attestation_request_content':
                $this->load->model("attest_model","atm");
                $this->load->model("statement_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $app_number = $this->input->post('app_number',true);
                $cnic = $this->input->post('cnic',true);
                $current_status = $this->input->post('current_status',true);
                if ($user_role_id == 4){
                    $status = 'pending';
                }else{
                    $status = '';
                }
                $count = $this->atm->get_contents($cnic, '', $status, $app_number, $current_status);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_contents($cnic, '', $status, $app_number, $current_status, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('attestation/attest_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'attestation_report_content':
                $this->load->model("attest_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $cnic = $this->input->post('cnic',true);
                $occupation = $this->input->post('occupation_id',true);
                $status = $this->input->post('status',true);
                $count = $this->atm->get_contents($cnic, $occupation, $status, '', '');
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_contents($cnic, $occupation, $status, '', '', $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('report/attest_report_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'attestation_receive_dispatch_content':
                $this->load->model("attest_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $cnic = $this->input->post('cnic',true);
                $occupation = $this->input->post('occupation_id',true);
                $status = $this->input->post('status',true);
                $current_status = $this->input->post('current_status',true);
            //    $count = $this->atm->get_received_contents($cnic, $occupation);
                $count = $this->atm->get_contents($cnic, $occupation, $status, '', $current_status);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_contents($cnic, $occupation, $status, '', $current_status, $config["per_page"], $page);
                $data["current_status"] = $current_status;
                $data['csrf'] = array(
                    'name' => $this->security->get_csrf_token_name(),
                    'hash' => $this->security->get_csrf_hash()
                );
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('attestation/attest_receive_dispatch_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'attestation_scheduled_content':
                $this->load->model("attest_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $cnic = $this->input->post('cnic',true);
                $from_date = $this->input->post('from_date',true);
                $to_date = $this->input->post('to_date',true);
                $count = $this->atm->get_scheduled_contents($cnic, $from_date, $to_date);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_scheduled_contents($cnic, $from_date, $to_date, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('attestation/scheduled_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'courier_sent_report_content':
                $this->load->model("attest_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $cnic = $this->input->post('cnic',true);
                $count = $this->atm->get_courier_sent_contents('', '', $cnic, '', '', '' ,'courier_received');
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_courier_sent_contents('', '', $cnic, '', '', '', 'courier_received', '', '', $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('report/view_courier_sent_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'application_track_content':
                $this->load->model("attest_model","atm");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $attest_id = $this->input->post('attest_id', TRUE);
                $app_number = $this->input->post('app_number', TRUE) ? $this->input->post('app_number', TRUE) : '';
                $count = $this->atm->get_application_track($attest_id, $app_number);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->atm->get_application_track($attest_id, $app_number, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('report/application_track_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'email_log_content':
                $this->load->model("email_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $to = $this->input->post('to', TRUE);
                $send_status = $this->input->post('send_status', TRUE);
                $limit = $this->input->post('select_limit', TRUE);
                $count = $this->email_model->get_log_contents($to, $send_status);
                $data = array();
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->email_model->get_log_contents($to, $send_status, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('report/email_log_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'user_statement_of_need_content':
                $this->load->model("statement_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $ecfmg_no = $this->input->post('ecfmg_no', TRUE);
                $pmc_no = $this->input->post('pmc_no', TRUE);
                $cnic = $this->input->post('cnic', TRUE);
                $limit = $this->input->post('select_limit', TRUE);
                $count = $this->statement_model->get_contents($ecfmg_no, $pmc_no, $cnic);
                $data = array();
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->statement_model->get_contents($ecfmg_no, $pmc_no, $cnic, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('statement_of_need/user_statement_of_need_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'receive_user_statement_of_need_content':
                $this->load->model("statement_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $ecfmg_no = $this->input->post('ecfmg_no', TRUE) ? $this->input->post('ecfmg_no', TRUE) : '';
                $pmc_no = $this->input->post('pmc_no', TRUE);
                $cnic = $this->input->post('cnic', TRUE);
                $limit = $this->input->post('select_limit', TRUE);
                $count = $this->statement_model->get_receive_contents($ecfmg_no, $pmc_no, $cnic);
                $data = array();
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->statement_model->get_receive_contents($ecfmg_no, $pmc_no, $cnic, $config["per_page"], $page);
                $data['role_id'] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('statement_of_need/receive_user_statement_of_need_list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            case 'user_password_reset_content':
                $this->load->model("user_model");
                $user_role_id = $this->session->userdata['logged_in']['role_id'];
                $cnic = $this->input->post('cnic', TRUE);
                $search_role = $this->input->post('role_id', TRUE);
                $count = $this->user_model->get_contents('', $cnic, $search_role);
                $data = array();
                $limit = $this->input->post('select_limit', TRUE);
                $config = array(
                    'base_url' => site_url("Ajax/content"),
                    'first_url' => site_url("Ajax/content/1"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                    'anchor_class'=> "page-link"
                );
                //pre($config,1);
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->user_model->get_contents('', $cnic, $search_role, $config["per_page"], $page);
                $data["role_id"] = $user_role_id;
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('password/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $count
                );
                break;
            default:
                break;
        }
        echo json_encode($output);
        exit;
    }

    function get_time_slots(){
        $html = '';
        $visit_date = $this->input->post('visit_date', TRUE) ? $this->input->post('visit_date', TRUE) : "";
        $user_id = $this->input->post('user_id', TRUE) ? $this->input->post('user_id', TRUE) : "";

        $today_date = date('m/d/Y');
        $today_time = date('H:i');

        $html .= '<select name="slot_id" id="slot_id" class="form-control input-paf" required >';
        $html .= '<option value="">Select</option>';
        if ($visit_date != ''){
            $schedular = $this->common_model->GetDataByFields("tbl_schedular", "slot_id", "visit_date = '".$visit_date."' AND user_id != '".$user_id."'");
            $time_slots = $this->common_model->GetDataByFields("tbl_time_slot", "id, slot", "status = 'Y'");
            foreach ($time_slots as $row){
                $disabled = '';
                $search = array_search($row['id'], array_column($schedular, 'slot_id'));
                if (isset($schedular[$search]['slot_id']) && $schedular[$search]['slot_id'] == $row['id']){
                    $disabled = 'disabled';
                }else{
                    $disabled = '';
                }
                if ($today_date == $visit_date){
                    if ($today_time > $row['slot']){
                        $disabled = 'disabled';
                    }else{
                        $disabled = '';
                    }
                }
                $html .= '<option value="'.$row['id'].'" '.$disabled.'>'.$row['slot'].'</option>';
            }
        }
        $html .= '</select>';
        echo json_encode($html);
    }

    function resend_email(){
        $this->load->library('email');
        $email_log_id = $this->input->post('email_log_id', TRUE);
        $email_log_data = $this->common_model->GetDataByFields('tbl_email_log', '*', 'id = "'.$email_log_id.'"', 'row');
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            $response = $this->common_model->resend_email($email_log_id, $email_log_data->to, $email_log_data->subject, $email_log_data->message, $email_log_data->from, 'MONHSRC');
        }else{
            $response = "localhost";
        }
    //    $response = $this->common_model->resend_email($email_log_id, $email_log_data->to, $email_log_data->subject, $email_log_data->message, $email_log_data->from, 'MONHSRC');
        echo json_encode($response);
        exit;
    }

}
