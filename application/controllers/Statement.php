<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statement extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("statement_model");
    }

    function index(){
        $roles = array(1,4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['content'] = $this->load->view('statement_of_need/user_statement_of_need', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function receive(){
        $roles = array(1,4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['content'] = $this->load->view('statement_of_need/receive_user_statement_of_need', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function request(){
        $data = [];
        $roles = [2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $user_data = $this->common_model->GetDataByFields('tbl_users', '*', 'id = "'.$user_id.'"', 'row');
        $is_request_pending = $this->common_model->counttotal("tbl_user_statement_of_need","user_id = '".$user_id."' AND (status != 'sent_to_ecfmg')");
        if ($is_request_pending > 0){
            $this->session->set_flashdata('success_response', "Your Application is Already Submitted.");
        //    redirect(site_url('attestation'));
            redirect(site_url('dashboard'));
        }
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        $this->form_validation->set_rules('ecfmg_no', 'ECFMG', 'trim|required|min_length[11]|max_length[11]|callback__ValidateECFMG');
    //    $this->form_validation->set_rules('is_pmc_reg', 'PMC Registered', 'trim|required');
        if (empty($_FILES['contract_letter']['name'])) {
            $this->form_validation->set_rules('contract_letter', 'Offer Letter/Letter of contract (FHS Agreement)', 'required');
        }
        if (empty($_FILES['ecfmg_certificate']['name'])) {
            $this->form_validation->set_rules('ecfmg_certificate', 'Copy of ECFMG Certificate', 'required');
        }
        if (empty($_FILES['cnic_copy']['name'])) {
            $this->form_validation->set_rules('cnic_copy', 'Copy of CNIC / NICOP / Passport', 'required');
        }
        $this->form_validation->set_rules('qualification', 'Graduation', 'trim|required');
        $this->form_validation->set_rules('institute', 'Institute where Graduation Degree was received', 'trim|required');
        $this->form_validation->set_rules('pass_year', 'Year of Passing', 'trim|required');
        $this->form_validation->set_rules('is_gov_employee', 'Are you a serving government employee?', 'trim|required');
        $this->form_validation->set_rules('post_grad_training', 'Post Grad Training', 'trim|required');
        $this->form_validation->set_rules('speciality', 'Speciality Area', 'trim|required');
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->form_validation->set_rules('training_start_date', 'Commencing Date', 'trim|required');
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->form_validation->set_rules('years', 'Duration (in Years)', 'trim|required');
        $this->form_validation->set_rules('training_institute', 'Institute in which overseas training is sought', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
        //    pre($_FILES);
            $time = time();
            $ecfmg_no = $this->input->post('ecfmg_no', TRUE);
            $pmc_no = $this->input->post('pmc_no', TRUE);
            $filename_contract_letter = $this->security->sanitize_filename('contract_letter');
            $filename_ecfmg_certificate = $this->security->sanitize_filename('ecfmg_certificate');
            $filename_cnic_copy = $this->security->sanitize_filename('cnic_copy');
            $filename_other_file = $this->security->sanitize_filename('other_file');
            if ($_FILES['contract_letter']['size'] > 0) {
                $insert['contract_letter'] = $this->_docUpload($filename_contract_letter, 'uploads/statment_of_need/letters');
            }
            if ($_FILES['ecfmg_certificate']['size'] > 0) {
            //    $insert['ecfmg_certificate'] = file_upload($filename_ecfmg_certificate, 'uploads/statment_of_need/certificates');
                $insert['ecfmg_certificate'] = $this->_docUpload($filename_ecfmg_certificate, 'uploads/statment_of_need/certificates');
            }
            if ($_FILES['cnic_copy']['size'] > 0) {
            //    $insert['cnic_copy'] = file_upload($filename_cnic_copy, 'uploads/statment_of_need/documents');
                $insert['cnic_copy'] = $this->_docUpload($filename_cnic_copy, 'uploads/statment_of_need/documents');
            }
            if ($_FILES['other_file']['size'] > 0) {
            //    $insert['other_file'] = file_upload($filename_other_file, 'uploads/statment_of_need/documents');
                $insert['other_file'] = $this->_docUpload($filename_other_file, 'uploads/statment_of_need/others');
            }
        //    pre($insert,1);
            $insert['is_pmc_reg'] = $this->input->post('is_pmc_reg', TRUE);
            $insert['qualification'] = $this->input->post('qualification', TRUE);
            $insert['institute'] = $this->input->post('institute', TRUE);
            $insert['post_qualification'] = $this->input->post('post_qualification', TRUE);
            $insert['pass_year'] = $this->input->post('pass_year', TRUE);
            $insert['is_gov_employee'] = $this->input->post('is_gov_employee', TRUE);
            $insert['post_grad_training'] = $this->input->post('post_grad_training', TRUE);
            $insert['speciality'] = $this->input->post('speciality', TRUE);
            //////////////////////////////////////////////////////////////////////////////////////////////
            $insert['training_start_date'] = $this->input->post('training_start_date', TRUE);
            //////////////////////////////////////////////////////////////////////////////////////////////
            $insert['years'] = $this->input->post('years', TRUE);
            $insert['training_institute'] = $this->input->post('training_institute', TRUE);
            $insert['is_special_need'] = $this->input->post('is_special_need', TRUE) == 'on' ? 'Y' : 'N';
            $insert['special_need_remarks'] = $this->input->post('special_need_remarks', TRUE);
            $insert['user_comment'] = $this->input->post('user_comment', TRUE);
            $insert['user_id'] = $user_id;
            $insert['created'] = $time;
            $insert['created_by'] = $user_id;
            $insert['updated'] = $time;
            $insert['updated_by'] = $user_id;
            $insert_id = $this->common_model->insert('tbl_user_statement_of_need', $insert);

            $app_number = "1".str_pad($insert_id,10,"0",STR_PAD_LEFT);
            $serial_no = str_pad($insert_id,1,"0",STR_PAD_LEFT);

            $updateStatement['app_number'] = $app_number;
            $updateStatement['sr_no'] = $serial_no;
            $updateStatementWhr['id'] = $insert_id;
            // Statement App number Updated...
            $this->common_model->update('tbl_user_statement_of_need', $updateStatement, $updateStatementWhr);
            // Update User's Table
            $updateUser['ecfmg_no'] = $ecfmg_no;
            if ($pmc_no != '') {
                $updateUser['pmc_no'] = $pmc_no;
            }
            $whereUser['id'] = $user_id;
            $this->common_model->update('tbl_users', $updateUser, $whereUser);
            // For the statement log
            $this->common_model->statement_status_log($insert_id, $app_number, 'pending', 'user_submitted', $user_id);

            $this->session->set_flashdata('success_response', "Your Application has been saved as draft. Please confirm final save by clicking Save Application.");
            redirect(site_url('statement/statement_of_need_undertaking/'.$insert_id));
        }
        $data['title'] = 'Statement of Need';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_id'] = $occupation_id;
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['content'] = $this->load->view('statement_of_need/request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit_request($id){
        $data = [];
        $roles = [2, 4];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $data['result'] = $this->statement_model->get_statement_of_need_details($id);
        if ($user_role_id == 2 && $data['result']->user_application_submitted == 'Y'){
            $this->session->set_flashdata('success_response', "This Application # ".$data['result']->app_number." Has Been Saved Successfully and cannot be further modified.");
            redirect(site_url('dashboard'));
        }
        if ($data['result']->application_submitted == 'Y'){
            $this->session->set_flashdata('success_response', "This Application # ".$data['result']->app_number." Has Been Saved and Approved Successfully and cannot be further modified.");
            if ($user_role_id == 2){
                redirect(site_url('dashboard'));
            }elseif ($user_role_id == 4){
                redirect(site_url('statement'));
            }
        }
        if ($user_role_id == 2) {
            $user_data_id = $user_id;
        }else{
            $user_data_id = $data['result']->user_id;
        }
        $user_data = $this->common_model->GetDataByFields('tbl_users', '*', 'id = "' . $user_data_id . '"', 'row');
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        $this->form_validation->set_rules('ecfmg_no', 'ECFMG', 'trim|required|min_length[11]|max_length[11]|callback__ValidateECFMG');
        $this->form_validation->set_rules('is_pmc_reg', 'PMC Registered', 'trim|required');
    //    $this->form_validation->set_rules('contract_letter', 'Offer Letter/Letter of contract (FHS Agreement)', 'trim|required');
    //    $this->form_validation->set_rules('ecfmg_certificate', 'Copy of ECFMG Certificate', 'trim|required');
    //    $this->form_validation->set_rules('cnic_copy', 'Copy of CNIC / NICOP / Passport', 'trim|required');
        $this->form_validation->set_rules('qualification', 'Graduation', 'trim|required');
        $this->form_validation->set_rules('institute', 'Institute where Graduation Degree was received', 'trim|required');
        $this->form_validation->set_rules('pass_year', 'Year of Passing', 'trim|required');
        $this->form_validation->set_rules('is_gov_employee', 'Are you a serving government employee?', 'trim|required');
        $this->form_validation->set_rules('post_grad_training', 'Post Grad Training', 'trim|required');
        $this->form_validation->set_rules('speciality', 'Speciality Area', 'trim|required');
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->form_validation->set_rules('training_start_date', 'Commencing Date', 'trim|required');
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->form_validation->set_rules('years', 'Duration (in Years)', 'trim|required');
        $this->form_validation->set_rules('training_institute', 'Institute in which overseas training is sought', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $ecfmg_no = $this->input->post('ecfmg_no', TRUE);
            $pmc_no = $this->input->post('pmc_no', TRUE);
            $filename_contract_letter = $this->security->sanitize_filename('contract_letter');
            $filename_ecfmg_certificate = $this->security->sanitize_filename('ecfmg_certificate');
            $filename_cnic_copy = $this->security->sanitize_filename('cnic_copy');
            $filename_other_file = $this->security->sanitize_filename('other_file');
            if ($_FILES['contract_letter']['size'] > 0) {
            /*
                $real_filename = $_FILES['contract_letter']['name'];
                $file = fopen("uploads/statment_of_need/letters/".$real_filename,"w");
                fclose($file);
                unlink("uploads/statment_of_need/letters/".$real_filename);
            */
                $update['contract_letter'] = $this->_docUpload($filename_contract_letter, 'uploads/statment_of_need/letters');
            }
            if ($_FILES['ecfmg_certificate']['size'] > 0) {
            //    $update['ecfmg_certificate'] = file_upload($filename_ecfmg_certificate, 'uploads/statment_of_need/certificates');
            //    $update['ecfmg_certificate'] = $this->_docUpload($filename_ecfmg_certificate, 'uploads/statment_of_need/certificates');
                $update['ecfmg_certificate'] = $this->_docUpload($filename_ecfmg_certificate, 'uploads/statment_of_need/letters');
            }
            if ($_FILES['cnic_copy']['size'] > 0) {
            //    $update['cnic_copy'] = file_upload($filename_cnic_copy, 'uploads/statment_of_need/documents');
            //    $update['cnic_copy'] = $this->_docUpload($filename_cnic_copy, 'uploads/statment_of_need/documents');
                $update['cnic_copy'] = $this->_docUpload($filename_cnic_copy, 'uploads/statment_of_need/letters');
            }
            if ($_FILES['other_file']['size'] > 0) {
            //    $update['other_file'] = file_upload($filename_other_file, 'uploads/statment_of_need/documents');
            //    $update['other_file'] = $this->_docUpload($filename_other_file, 'uploads/statment_of_need/documents');
                $update['other_file'] = $this->_docUpload($filename_other_file, 'uploads/statment_of_need/letters');
            }
            $update['is_pmc_reg'] = $this->input->post('is_pmc_reg', TRUE);
            $update['qualification'] = $this->input->post('qualification', TRUE);
            $update['institute'] = $this->input->post('institute', TRUE);
            $update['post_qualification'] = $this->input->post('post_qualification', TRUE);
            $update['pass_year'] = $this->input->post('pass_year', TRUE);
            $update['is_gov_employee'] = $this->input->post('is_gov_employee', TRUE);
            $update['post_grad_training'] = $this->input->post('post_grad_training', TRUE);
            $update['speciality'] = $this->input->post('speciality', TRUE);
            //////////////////////////////////////////////////////////////////////////////////////////////
            $update['training_start_date'] = $this->input->post('training_start_date', TRUE);
            //////////////////////////////////////////////////////////////////////////////////////////////
            $update['years'] = $this->input->post('years', TRUE);
            $update['training_institute'] = $this->input->post('training_institute', TRUE);
            $update['is_special_need'] = $this->input->post('is_special_need', TRUE) == 'on' ? 'Y' : 'N';
            $update['special_need_remarks'] = $this->input->post('special_need_remarks', TRUE);
            $update['user_comment'] = $this->input->post('user_comment', TRUE);
            $update['updated'] = $time;
            $update['updated_by'] = $user_id;
            $where['id'] = $id;
            $this->common_model->update('tbl_user_statement_of_need', $update, $where);
            if ($pmc_no != '') {
                $updateUser['pmc_no'] = $pmc_no;
            }
            if ($ecfmg_no != '') {
                $updateUser['ecfmg_no'] = $ecfmg_no;
            }
            $updateUser['fullname'] = $this->input->post('fullname', TRUE);
            $updateUser['father_name'] = $this->input->post('father_name', TRUE);
            $updateUser['contact_number'] = $this->input->post('contact_number', TRUE);
            $updateUser['address'] = $this->input->post('address', TRUE);
            $whereUser['id'] = $data['result']->user_id;
            $this->common_model->update('tbl_users', $updateUser, $whereUser);
            // For the statement log
            $current_status = "";
            if ($user_role_id == 2){
                $current_status = "user_edited";
            }elseif ($user_role_id == 4){
                $current_status = "ministry_edited";
            }
            $this->common_model->statement_status_log($id, $data['result']->app_number, 'pending', $current_status, $data['result']->user_id);
            $this->session->set_flashdata('success_response', "The Application Has Been Updated Successfully.");
            if ($user_role_id == 2){
                redirect(site_url('statement/statement_of_need_undertaking/'.$id));
            }elseif ($user_role_id == 4){
                redirect(site_url('statement/statement_of_need_application/'.$id));
            }
        }
        $data['title'] = 'Statement of Need';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_id'] = $occupation_id;
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['content'] = $this->load->view('statement_of_need/edit_request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function statement_of_need_form($statement_id){
        $roles = array(1,4);
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $where = "";
        $data = array();
        $data['result'] = array();
        $data['result'] = $this->statement_model->get_statement_of_need_details($statement_id);
    //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('status', 'Status', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $update = array();
            if (isset($_POST['status'])) {
            //    pre("Set",1);
                $update['status'] = $this->input->post('status', TRUE) == 'on' ? 'accepted' : 'pending';
            }else{
            //    pre("Not Set",1);
                $update['user_application_submitted'] = 'N';
            }
            ////////////////////////////////////////////////////////////////////////////////
            $update['signatory_id'] = $this->input->post('signatory_id', TRUE);
            $update['signatory'] = $this->input->post('signatory', TRUE);
            ////////////////////////////////////////////////////////////////////////////////
            $update['ministry_comment'] = $this->input->post('ministry_comment', TRUE);
            $update['updated'] = time();
            $update['updated_by'] = $user_id;
            $updateWhr['id'] = $statement_id;
            // Statement of Need Final Submission Updated...
            $this->common_model->update('tbl_user_statement_of_need', $update, $updateWhr);
            // For the statement log
            $this->common_model->statement_status_log($statement_id, $data['result']->app_number, $update['status'], 'ministry_accepted', $data['result']->user_id);
            $this->session->set_flashdata('success_response', "The Application Status is Changed.");
            redirect(site_url('statement'));
        }
        $data['role_id'] = $role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['user_id'] = $data['result']->user_id;
        $data['signatory_select'] = get_signatory();
        $data['statement_id'] = $statement_id;
        $this->load->view('statement_of_need/statment_of_need_form_print_view', $data);
    }

    function statement_of_need_undertaking($statement_id){
        $roles = array(1,2,4);
        checkUserAccess($roles);
        $where = "";
        $data = array();
        $data['result'] = array();
        $data['result'] = $this->statement_model->get_statement_of_need_details($statement_id);
    //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('status', 'Status', 'trim');
        if ($this->form_validation->run() == TRUE) {
            echo 'Form submission here';
        }
        $data['role_id'] = $role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['statement_id'] = $statement_id;
        ////// --> Just for testing purpose <-- //////
        $data['result']->application_submitted = "N";
        ////// --> Just for testing purpose <-- //////
        $this->load->view('statement_of_need/undertaking_print_view', $data);
    }

    function statement_of_need_application($statement_id){
        $roles = array(1,2,4);
        checkUserAccess($roles);
        $where = "";
        $data = array();
        $data['result'] = array();
        $data['result'] = $this->statement_model->get_statement_of_need_details($statement_id);
    //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('status', 'Status', 'trim');
        if ($this->form_validation->run() == TRUE) {
            echo 'Form submission here';
        }
        $data['role_id'] = $role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['statement_id'] = $statement_id;
        $this->load->view('statement_of_need/statement_of_need_print_view', $data);
    }

    function sent_to_ecfmg($statement_id){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $statement_data = $this->statement_model->get_statement_of_need_details($statement_id);
        /*
        if ($data['result']->status == 'Y'){
            $this->session->set_flashdata('success_response', "This Application # ".$statement_data->app_number." Has Been Saved and Approved and cannot be further modified.");
            redirect(site_url('statement'));
        }
        */
        $updateRequest['status'] = "sent_to_ecfmg";
        $updateRequest['updated'] = time();
        $updateRequest['updated_by'] = $user_id;
        $updateRequestWhr['id'] = $statement_id;
        // Attestation Final Submission Updated...
        $this->common_model->update('tbl_user_statement_of_need', $updateRequest, $updateRequestWhr);
        // For the statement log
        $this->common_model->statement_status_log($statement_id, $statement_data->app_number, 'approved', 'ministry_approved', $statement_data->user_id);

        $this->session->set_flashdata('success_response', "Status Changed Successfully.");
        redirect(site_url('statement'));
    }

    function save_application($statement_id){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
    //    $user_data = $this->common_model->GetDataByFields('tbl_users', 'id, fullname, email, cnic', 'id = "'.$user_id.'"', 'row');
        $statement_data = $this->statement_model->get_statement_of_need_details($statement_id);
        /*
        if ($data['result']->application_submitted == 'Y'){
            $this->session->set_flashdata('success_response', "This Application # ".$statement_data->app_number." Has Been Saved and Approved and cannot be further modified.");
            redirect(site_url('statement'));
        }
        */
        $updateRequest['application_submitted'] = "Y";
        $updateRequest['status'] = "approved";
        $updateRequest['updated'] = time();
        $updateRequest['updated_by'] = $user_id;
        $updateRequestWhr['id'] = $statement_id;
        // Attestation Final Submission Updated...
        $this->common_model->update('tbl_user_statement_of_need', $updateRequest, $updateRequestWhr);
        // For the statement log
        $this->common_model->statement_status_log($statement_id, $statement_data->app_number, 'approved', 'ministry_approved', $statement_data->user_id);

        $this->session->set_flashdata('success_response', "Application saved successfully.");
        redirect(site_url('statement'));
    }

    function user_save_application($statement_id){
        $data = [];
        $roles = [2];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
    //    $user_data = $this->common_model->GetDataByFields('tbl_users', 'id, fullname, email, cnic', 'id = "'.$user_id.'"', 'row');
        $statement_data = $this->statement_model->get_statement_of_need_details($statement_id);
        $updateRequest['user_application_submitted'] = "Y";
        $updateRequest['updated'] = time();
        $updateRequest['updated_by'] = $user_id;
        $updateRequestWhr['id'] = $statement_id;
        // Attestation Final Submission Updated...
        $this->common_model->update('tbl_user_statement_of_need', $updateRequest, $updateRequestWhr);
        // For the statement log
        $this->common_model->statement_status_log($statement_id, $statement_data->app_number, 'pending', 'user_saved', $statement_data->user_id);

        $this->session->set_flashdata('success_response', "Application saved successfully.");
        redirect(site_url('dashboard'));
    }

    function statment_of_need_upload_letter($statement_id){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $statement_data = $this->statement_model->get_statement_of_need_details($statement_id);
        if ($statement_data->statement_of_need_file != ''){
            $this->session->set_flashdata('success_response', "Letter is already Uploaded");
            redirect(site_url('statment'));
        }
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('statement_of_need_file', 'Statement of Need Letter', 'trim');
        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
        //    pre($_FILES);
            $time = time();
            $filename_statement_of_need_file = $this->security->sanitize_filename('statement_of_need_file');
            $ministry_comments = $this->input->post('ministry_comment', TRUE);

            if ($_FILES['statement_of_need_file']['size'] > 0) {
                $updateRequest['statement_of_need_file'] = $this->_docUpload($filename_statement_of_need_file, 'uploads/statment_of_need/son_letters');

                $updateRequest['ministry_comment'] = $this->input->post('ministry_comment', TRUE);
                $updateRequest['updated'] = time();
                $updateRequest['updated_by'] = $user_id;
                $updateRequestWhr['id'] = $statement_id;
                // Statement App number Updated...
                $this->common_model->update('tbl_user_statement_of_need', $updateRequest, $updateRequestWhr);
                // For the statement log
                $this->common_model->statement_status_log($statement_id, $statement_data->app_number, 'sent_to_ecfmg', 'letter_uploaded', $statement_data->user_id);

                $this->session->set_flashdata('success_response', "File Uploaded Successfully.");
                redirect(site_url('statement'));
            }else{
                $this->session->set_flashdata('success_response', "Error While File Uploading.");
                redirect(site_url('statment_of_need_upload_letter/'.$statement_id));
            }

        }
        $data['title'] = 'Statement of Need';
        $data['user_id'] = $statement_data->user_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('statement_of_need/upload_son_letter', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function statement_of_need_user_fields_print_view($statement_id){
        $roles = array(1,2,4);
        checkUserAccess($roles);
        $where = "";
        $data = array();
        $data['result'] = array();
        $data['result'] = $this->statement_model->get_statement_of_need_details($statement_id);
        //    $this->load->helper('form');
        $data['title'] = 'Statement of Need';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('status', 'Status', 'trim');
        if ($this->form_validation->run() == TRUE) {
            echo 'Form submission here';
        }
        $data['role_id'] = $role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['statement_id'] = $statement_id;
        ////// --> Just for testing purpose <-- //////
        $data['result']->application_submitted = "N";
        ////// --> Just for testing purpose <-- //////
        $this->load->view('statement_of_need/statement_of_need_user_fields', $data);
    }

    function doc_view($statement_id) {
        $roles = [1, 4];
        checkUserAccess($roles);
        $data = array();
        $data['result'] = array();
        $data['result'] = $this->statement_model->get_statement_of_need_details($statement_id);
        $htmlView = $this->load->view('statement_of_need/statement_of_need_doc_view', $data, true); //true for return
    //    echo $htmlView; die;
        word_generater($htmlView);
    }

    function _ValidateECFMG(){
        $ecfmg_no = $this->input->post('ecfmg_no', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
        $result = $this->user_model->unique_ecfmg_check($ecfmg_no, $user_id);
        if ($result) {
        //    $this->form_validation->set_message('_ValidateECFMG', 'ECFMG No. Already Exits');
            $this->form_validation->set_message('_ValidateECFMG', 'This ECFMG No. is already assigned to another user...');
            return false;
        } else {
            return TRUE;
        }
    }

    function _docUpload($file_name = '', $path = '') {
        $CI = &get_instance();
        $unique_id = uniqid();
        $curr_time = time();
        $new_name = $unique_id . '_' . $curr_time;
        $config['file_name'] = $new_name;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
        $CI->load->library('upload', $config);
        if ($CI->upload->do_upload($file_name)) {
            $document = array('upload_data' => $CI->upload->data());
            return $document['upload_data']['file_name'];
        } else {
            return false;
        }
    }

}
