<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("user_model");
    }

    function delete($id) {
        $roles = [1];
        checkUserAccess($roles);
    //    $session_data = $this->session->userdata('logged_in');

        $sql = "INSERT INTO `delete_users` SELECT * FROM tbl_users where id = '$id';";
        $deleted_id = $this->common_model->SqlExec($sql);

        $where = ['id' => $id];
        $this->common_model->delete("tbl_users", $where);

        $where = array();
        $where = ['user_id' => $id];
        $this->common_model->delete("tbl_app_status_log", $where);
        $this->common_model->delete("tbl_schedular", $where);
        $this->common_model->delete("tbl_user_attestation", $where);
        $this->common_model->delete("tbl_user_attestation_document", $where);
        $this->common_model->delete("tbl_user_experience", $where);
        $this->common_model->delete("tbl_user_overseas_experience", $where);
        $this->common_model->delete("tbl_user_qualification", $where);


        $this->session->set_flashdata('success_response', "User Deleted Successfully");
        redirect(base_url('user'));
    }

    function index(){
        $roles = [1,4];
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['title'] = $role_id == 4 ? 'Applicants' : 'Users';
        $data['search_role'] = $role_id == 4 ? 2 : '';
        $data['role_id'] = $role_id;
        $data['content'] = $this->load->view('user/view', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function register(){
        $data = [];
    //    $roles = ['1'];
    //    checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
    //    $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('confirm_email', 'Confirm Email', 'trim|required|callback__ValidateConfirmEmail');
        $this->form_validation->set_rules('occupation_id', 'Occupation', 'trim|required');
    //    $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|is_unique[tbl_users.cnic]');
        $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|callback__ValidateCNIC');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        /*
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback__ValidateUser');
        $this->form_validation->set_rules('occupation_id', 'Occupation', 'trim|required');
        $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|is_unique[tbl_users.cnic]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
        */
        $role_id = $this->input->post('role_id', TRUE) ? $this->input->post('role_id', TRUE) : 0;
        $occupation_id = $this->input->post('occupation_id', TRUE) ? $this->input->post('occupation_id', TRUE) : 0;
    //    $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : 0;

        if ($this->form_validation->run() == TRUE) {
            /* start for image upload */
            $otp_number = rand(100000,999999);
            $insert['fullname'] = $this->input->post('fullname', TRUE);
            $insert['username'] = $this->input->post('username', TRUE);
            $insert['password'] = md5($this->input->post('password', TRUE));
            $insert['role_id'] = $this->input->post('role_id', TRUE);
            $insert['email'] = $this->input->post('email', TRUE);
            $insert['contact_number'] = $this->input->post('contact_number', TRUE);
            $insert['occupation'] = $this->input->post('occupation', TRUE);
            $insert['occupation_id'] = $occupation_id;
            $insert['cnic'] = $this->input->post('cnic', TRUE);
            $insert['gender'] = $this->input->post('gender', TRUE);
        //    $insert['province'] = $this->input->post('province', TRUE);
        //    $insert['province_id'] = $province_id;
            $insert['created'] = strtotime(date("Y-m-d H:i:s", time()));
            $insert['updated'] = strtotime(date("Y-m-d H:i:s", time()));
            $insert['status'] = "Y";
            $insert['otp'] = $otp_number;
         //   pre($insert);
            $user_id = $this->common_model->insert('tbl_users', $insert);
            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                $this->_send_email($insert['username'], $insert['email'], $insert['password']);
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $this->session->set_flashdata('success_response', "Your Account has been generated Successfully. Please login with your provided username and password.");
            redirect(site_url());
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /* For OTP Verification
            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                $this->_send_otp_email($insert['fullname'], $insert['email'], $otp_number, $user_id);
            }
            $this->session->set_flashdata('success_response', "OTP SENT FOR VERIFICATION");
            redirect(site_url('user/verify/'.$user_id));
            */
        }
        $data['title'] = 'Registration';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_select'] = get_occupation($occupation_id);
    //    $data['province_select'] = get_province($province_id);
        $this->load->view('register', $data);
    }

    function verify($id){
        $this->load->model('login_model');
        $is_user_verified = $this->common_model->counttotal('tbl_users','id = "'.$id.'" AND status = "Y"');
    //    pre($is_user_verified,1);
        if ($is_user_verified > 0){
            redirect(site_url());
        }
        $data = [];
    //    $roles = ['1'];
    //    checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            /* start for image upload */
            $otp_number = $this->input->post('otp', TRUE);
            $is_otp_matched = $this->common_model->counttotal('tbl_users','id = "'.$id.'" AND otp = "'.$otp_number.'"');
            $sess_array = array();
            if ($is_otp_matched > 0) {
                $updateData['status'] = "Y";
                $updateWhr['id'] = $id;
                $this->common_model->update('tbl_users', $updateData, $updateWhr);

                $result = $this->login_model->login_id($id);
                //pre($result[0]->is_firstlogin,1);
                $sess_array = array(
                    'id' => $result->id,
                    'fullname' => $result->fullname,
                    'role_id' => $result->role_id,
                    'gender' => $result->gender,
                    'email' => $result->email,
                    'cnic' => $result->cnic,
                    'occupation_id' => $result->occupation_id
                );
                $this->session->set_userdata('logged_in', $sess_array);
                $this->session->set_flashdata('success_response', "OTP MATCHED SUCCESSFULLY");
            //    redirect(site_url('dashboard'));
                redirect(site_url());
            }else{
                $this->session->set_flashdata('error_response', "PLEASE PROVIDE CORRECT OTP");
                redirect(site_url('user/verify/'.$id));
            }
        }
        $data['title'] = 'OTP';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['user_id'] = $id;
        $this->load->view('user/add_otp', $data);
    }

    function otp_resend($id){
        $otp_number = rand(100000,999999);
        $updateData['otp'] = $otp_number;
        $result = $this->common_model->GetDataByFields('tbl_users', '*', 'id = "'.$id.'"', 'row');
        $this->common_model->update('tbl_users', $updateData, 'id = "'.$id.'"');
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            $this->_send_otp_email($result->fullname, $result->email, $otp_number, $id);
        }
        $this->session->set_flashdata('success_response', "NEW OTP SENT...");
        redirect(site_url('user/verify/'.$id));
    }

    function add(){
        $data = [];
        $roles = ['1'];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback__ValidateUser');
    //    $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('occupation_id', 'Occupation', 'trim|required');
        $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|is_unique[tbl_users.cnic]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
        $role_id = $this->input->post('role_id', TRUE) ? $this->input->post('role_id', TRUE) : 0;
        $occupation_id = $this->input->post('occupation_id', TRUE) ? $this->input->post('occupation_id', TRUE) : 0;
    //    $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : 0;

        if ($this->form_validation->run() == TRUE) {
            /* start for image upload */
            $otp_number = rand(100000,999999);
            $path = 'uploads/user_image';
            $filename = $this->security->sanitize_filename('picture');
            if ($_FILES['picture']['size'] > 0) {
            //    $insert['picture'] = file_upload('picture', $path);
                $insert['picture'] = file_upload($filename, $path);
            }
            $insert['fullname'] = $this->input->post('fullname', TRUE);
            $insert['username'] = $this->input->post('username', TRUE);
            $insert['password'] = md5($this->input->post('password', TRUE));
            $insert['role_id'] = $this->input->post('role_id', TRUE);
            $insert['email'] = $this->input->post('email', TRUE);
            $insert['contact_number'] = $this->input->post('contact_number', TRUE);
            $insert['occupation'] = $this->input->post('occupation', TRUE);
            $insert['occupation_id'] = $occupation_id;
        //    $insert['cnic'] = $this->input->post('cnic', TRUE);
            $insert['gender'] = $this->input->post('gender', TRUE);
        //    $insert['status'] = $this->input->post('status', TRUE);
        //    $insert['province'] = $this->input->post('province', TRUE);
        //    $insert['province_id'] = $province_id;
            $insert['created'] = strtotime(date("Y-m-d H:i:s", time()));
            $insert['updated'] = strtotime(date("Y-m-d H:i:s", time()));
            $insert['status'] = 'Y';
            $insert['otp'] = $otp_number;
         //   pre($insert);
            $this->common_model->insert('tbl_users', $insert);
          //  pre($this->db->last_query(),1);
            //$this->_send_email($username, $email, $password, $usertype);
            $this->session->set_flashdata('success_response', "USER ADDED SUCCESSFULLY ");
            redirect(site_url('user'));
        }
        $data['title'] = 'Add User';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['role_select'] = get_role($role_id);
        $data['occupation_select'] = get_occupation($occupation_id);
    //    $data['province_select'] = get_province($province_id);
        $data['content'] = $this->load->view('user/add', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit($id){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $data['result'] = $this->user_model->get_all_details($id);
        $user_id = $this->session->userdata['logged_in']['id'];
        $user_occupation_id = $this->session->userdata['logged_in']['occupation_id'];

    //    $is_request_pending = $this->common_model->counttotal("tbl_user_attestation","source = 'self' AND user_id = '".$user_id."' AND (status = 'pending')");
        $is_request_pending = $this->common_model->counttotal("tbl_user_attestation","user_id = '".$user_id."' AND (status = 'pending')");
        if ($is_request_pending > 0){
            $this->session->set_flashdata('success_response', "Your Application is Under Process, You cannot change your Profile at the moment.");
            redirect(site_url('dashboard'));
        }

        $is_qualification_entered = $this->common_model->counttotal('tbl_user_qualification','user_id = "'.$user_id.'"');
        $is_experience_entered = $this->common_model->counttotal('tbl_user_experience','user_id = "'.$user_id.'"');
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('father_name', 'Father Name', 'trim|required');
    //    $this->form_validation->set_rules('domicile', 'Domicile', 'trim|required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
    //    $this->form_validation->set_rules('email', 'Email', 'trim|required|callback__ValidateEmail');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
        if ($user_role_id == 1) {
            $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|callback__ValidateCNIC');
        }
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('marital_status_id', 'Marital Status', 'trim|required');
    //    $this->form_validation->set_rules('occupation_id', 'Occupation', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $role_id = $this->input->post('role_id', TRUE) ? $this->input->post('role_id', TRUE) : $data['result']->role_id;
        $marital_status_id = $this->input->post('marital_status_id', TRUE) ? $this->input->post('marital_status_id', TRUE) : $data['result']->marital_status_id;
        $add_occupation_id = $this->input->post('add_occupation_id', TRUE) ? $this->input->post('add_occupation_id', TRUE) : $data['result']->add_occupation_id;
    //    $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : $data['result']->province_id;

        if ($this->form_validation->run() == TRUE) {
            $is_son = $this->input->post('is_son', TRUE);
            /* start for image upload */
            $path = 'uploads/user_image';
            $filename = $this->security->sanitize_filename('picture');
            if ($_FILES['picture']['size'] > 0) {
        //    if ($_FILES['picture']['name'] != '') {
            //    $update['picture'] = file_upload('picture', $path);
                $update['picture'] = file_upload($filename, $path);
            }
            $update['fullname'] = $this->input->post('fullname', TRUE);
            $update['father_name'] = $this->input->post('father_name', TRUE);
            $update['domicile'] = $this->input->post('domicile', TRUE);
            $update['username'] = $this->input->post('username', TRUE);
            $update['email'] = $this->input->post('email', TRUE);
            $update['dob'] = $this->input->post('dob', TRUE);
            $update['contact_number'] = $this->input->post('contact_number', TRUE);
            $update['address'] = $this->input->post('address', TRUE);
            if ($user_role_id == 1) {
                $update['cnic'] = $this->input->post('cnic', TRUE);
            }
            $update['gender'] = $this->input->post('gender', TRUE);
            $update['marital_status'] = $this->input->post('marital_status', TRUE);
            $update['marital_status_id'] = $marital_status_id;
        //    $update['occupation'] = $this->input->post('occupation', TRUE);
        //    $update['occupation_id'] = $occupation_id;
            if ($add_occupation_id > 0) {
                $update['add_occupation'] = $this->input->post('add_occupation', TRUE);
                $update['add_occupation_id'] = $add_occupation_id;
            }
        //    $update['province'] = $this->input->post('province', TRUE);
        //    $update['province_id'] = $province_id;

            ///////////////// --> Statement of Need Fields <------ /////////////////
        //    $update['ecfmg_no'] = $this->input->post('ecfmg_no', TRUE);
        //    $update['pmc_no'] = $this->input->post('pmc_no', TRUE);
            ///////////////// --> Statement of Need Fields End <-- /////////////////

            $update['updated'] = strtotime(date("Y-m-d H:i:s", time()));
         //   pre($update);
            $updateWhere['id'] = $id;
            $this->common_model->update('tbl_users', $update, $updateWhere);
          //  pre($this->db->last_query(),1);
            //$this->_send_email($username, $email, $password, $usertype);
            $this->session->set_flashdata('success_response', "USER UPDATED SUCCESSFULLY ");
        //    redirect(site_url('user'));
            if ($user_role_id == 2){
                if ($is_son == 'Y') {
                    redirect(site_url('statement/request'));
                }else{
                    redirect(site_url('qualification'));
                }
            } else {
                redirect(site_url('user/edit/' . $id));
            }
        }
        $data['title'] = 'Update User';
        $data['is_qualification_entered'] = $is_qualification_entered > 0 ? 'Y' : 'N';
        $data['is_experience_entered'] = $is_experience_entered > 0 ? 'Y' : 'N';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['is_son_submitted'] = $this->common_model->counttotal('tbl_user_statement_of_need','user_id = "'.$id.'" AND (status != "sent_to_ecfmg")');
    //    pre($data['is_son_submitted'],1);
        $data['user_id'] = $id;
        $data['role_id'] = $user_role_id;
    //    $data['province_select'] = get_province($province_id);
        $data['user_occupation_id'] = $user_occupation_id;
        $data['role_select'] = get_role($role_id);
        $data['marital_status_select'] = get_marital_status($marital_status_id,'','marital_status_id');
        $data['add_occupation_select'] = get_occupation($add_occupation_id, '', $name = 'add_occupation_id', '', $placeholder = 'Select');
        $data['content'] = $this->load->view('user/edit', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _send_otp_email($full_name = "", $to = '', $otp_number = '', $user_id = ''){
        //pre($user_id,1);
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'otp_verify'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        //pre($EmailTemp,1);
        $subject = 'New User Register';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{otp_number}");
        $replace = array($full_name, $to, $otp_number);
        //pre($replace, 1);
        $message = str_replace($find, $replace, $message);
        $message = "".$message."";
        // pre($message, 1);
        $From = "noreply@ppwnap.gov.pk";
        $From = "noreply@nhsrc.gov.pk";
    //    $From = "";
        $FromName = $full_name;
    //    echo $subject; die;
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email($to, $subject, $message, $From, $FromName);
        }
        $this->session->set_flashdata('success_response', 'OTP Has Been Sent! Please check your Email');
    //    redirect(site_url('user/add'));
        redirect(base_url('user/verify/'.$user_id));
    }

    function _send_email($fullname = "", $username = "", $to = ''){
        //pre($user_type,1);
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwhere('email_template', 'templatename', 'account_confirmation'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        //pre($EmailTemp,1);
        $subject = 'New User Register';  //load subject
        $message = $EmailTemp->template;
        $siteurl = site_url();
        $site_logo = site_url("assets/images/logo.png");
        $find = array("{site_url}", "{full_name}", "{username}", "{email}");
        $replace = array(site_url(), $fullname, $username, $to);
        //pre($replace, 1);
        $message = str_replace($find, $replace, $message);
        // pre($message, 1);
        $From = "noreply@ppwnap.gov.pk";
        $From = "noreply@nhsrc.gov.pk";
    //    $From = "";
        $FromName = $fullname;
        //echo $subject; die;
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email($to, $subject, $message, $From, $FromName);
        }
        $this->session->set_flashdata('success_response', 'Account Has Been Created Successfully! Login Details sent via Email');
        redirect(site_url('dashboard'));
    }

    function _ValidateUser(){
        $username = $this->input->post('username', TRUE);
        $clinicid = $this->input->post('clinic_name', TRUE);
        $result = $this->user_model->unique_check($username, $clinicid);
        if ($result) {
            $this->form_validation->set_message('_ValidateUser', 'Username Already Exits');
            return false;
        } else {
            return TRUE;
        }
    }

    function _ValidateCNIC(){
        $cnic = $this->input->post('cnic', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
        $result = $this->user_model->unique_cnic_check($cnic, $user_id);
        if ($result) {
        //    $this->form_validation->set_message('_ValidateCNIC', 'CNIC Already Exits');
            $this->form_validation->set_message('_ValidateCNIC', 'This CNIC/Passport No. is already registered for another user...If its you, Please Go to login page and click forgot password...');
            return false;
        } else {
            return TRUE;
        }
    }

    function _ValidateEmail(){
        $email = $this->input->post('email', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
        $result = $this->user_model->unique_email_check($email, $user_id);
        if ($result) {
            $this->form_validation->set_message('_ValidateEmail', 'Email Already Exits');
            return false;
        } else {
            return TRUE;
        }
    }

    function _ValidateConfirmEmail(){
        $email = $this->input->post('email', TRUE);
        $confirm_email = $this->input->post('confirm_email', TRUE);
        if ($email != $confirm_email) {
            $this->form_validation->set_message('_ValidateConfirmEmail', 'Please enter the same confirm email.');
            return false;
        } else {
            return TRUE;
        }
    }

    function status_user($id, $status){
        if ($status == 'N') {
            $update['status'] = 'Y';
        } elseif ($status == 'Y') {
            $update['status'] = 'N';
        }
        $this->common_model->update('tbl_users', $update, 'id = ' . $id);
        redirect(base_url('user/listing_user'));
    }

    function listing_user(){
        $data = [];
        $roles = ['1'];
        checkUserAccess($roles);
        $data['title'] = 'List Of Register Counter User';
        $role_name = $this->input->post('role_name', TRUE) ? $this->input->post('role_name', TRUE) : 0;
        $clinic_name = $this->input->post('clinic_name', TRUE) ? $this->input->post('clinic_name', TRUE) : 0;
        $data['get_role_name'] = get_role($role_name);
        $data['result'] = $this->user_model->get_admin_register_contents();
        //pre($data['result'],1);
        $data['content'] = $this->load->view('admin/register/view', $data, TRUE);
        $this->load->view('template', $data);
    }

    function view_details($id){
        $data = [];
        $roles = ['1'];
        $data['title'] = 'User Details';
        checkUserAccess($roles);
        $data['result'] = $this->user_model->get_all_details($id);
        $data['content'] = $this->load->view('user/detail', $data, true);
        $this->load->view('template', $data);
    }

    function admin_password($id) {
        $data = [];
        $roles = ['1','24'];
        checkUserAccess($roles);
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('new-password', 'Password', 'trim|required|matches[password_two]');
        $this->form_validation->set_rules('password_two', 'Confirm Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $update['password'] = md5($this->input->post('new-password', TRUE));
            $this->common_model->update('tbl_users', $update, 'id = ' . $id);
            $this->session->set_flashdata('success_response', "DATA UPDATED SUCCESSFULLY ");
            redirect(base_url('user/listing_user'));
        }
        $data['title'] = 'Change Password ';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('user/admin_change_password', $data, true);
        $this->load->view('template', $data);
    }

    function email_test(){
        $subject = 'New User Register';
        $message = "New \r\n User \r\n Registeration";
        $find = array("{fullname}", "{email}", "{otp_number}");
        $replace = array("User", "y2jsheikh@gmail.com", 123);
        $message = str_replace($find, $replace, $message);
        $message = "".$message."";
        $From = "noreply@nhsrc.gov.pk";
        $FromName = "MONHSRC";
		//pre($message,1);
      //  if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email("y2jsheikh@gmail.com", $subject, $message, $From, $FromName);
       // }
    }

    function email_test_2(){
        $subject = 'Application Submitted';
        $message ='Dear User,<br/> <br/> Your Application # 10000000021 has been submitted against CNIC/Passport# 3530168746846. Please send the valid documents as per mentioned in the SOPs to your nearest TCS center. <br/> Please visit any one of the following mentioned <b style="color: blue;"><a target="_blank" href="http://localhost/attestation/assets/docs/tcs_centers.pdf">TCS Centers</a></b> <br/> <br/> Thanks<br/> <br/> Regards,<br/> MONHSRC, Pakistan';
        $From = "noreply@nhsrc.gov.pk";
        $FromName = "MONHSRC";
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email("y2jsheikh@gmail.com", $subject, $message, $From, $FromName);
        }
    }

    function count_system_users(){
        $data = array();
        $count_1 = $this->common_model->counttotal('tbl_users');
        $count = $this->common_model->counttotal('tbl_users', 'role_id != "2"');
        if ($count > 0){
            $data = $this->common_model->GetDataByFields('tbl_users', 'username, role_id, fullname', 'role_id != "2"', 'object');
        }
        pre($count_1);
        pre($count);
        pre($data,1);
    }

    function reset_user_password($id){
        $roles = [1,4];
        checkUserAccess($roles);
        $user_cnic = getsinglefield('tbl_users','cnic','WHERE id = "'.$id.'"');
        $query = "UPDATE tbl_users SET password='".md5($user_cnic)."', password_reset='Y' WHERE (id='".$id."')";
        $this->common_model->SqlExec($query);
        $this->session->set_flashdata('success_response', "User Password Reset/Changed to His/Her CNIC/Passport#...");
        redirect(base_url('user'));
    }

    /*
    function xoxo($user_id){
        if ($user_id > 0) {
            $update['status'] = "Y";
            $updateWhr['id'] = $user_id;
            $this->common_model->update('tbl_users', $update, $updateWhr);
            echo "User Activated";
        }else{
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    */

    function xodo(){
    //    $is_table = table_exist('');
        $sql = "";
        if ($sql != '') {
            $this->common_model->SqlExec($sql);
            echo "Table Created";
        }else{
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
