<?php

// Turn off all error reporting
// error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('login_model', '', TRUE);
    }

    //start: login user
    function index(){
        //$this->run_quries();
        is_admin_logged();
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback__ValidateLogin');
        if ($this->form_validation->run() == FALSE) {
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('login', $data);
        } else {
            redirect(site_url());
        }
    }

    function _ValidateLogin(){
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE); // XSS cleaning by true
        $pass = md5($password);
        //pre($pass,1);
        $row = $this->login_model->login($username, $pass);
        if ($row) {
            if ($row->status == 'Y') {
                $sess_array = array();
                $sess_array = array(
                    'id' => $row->id,
                    'fullname' => $row->fullname,
                    'role_id' => $row->role_id,
                    'gender' => $row->gender,
                    'email' => $row->email,
                    'cnic' => $row->cnic,
                    'occupation_id' => $row->occupation_id
                );
                $this->session->set_userdata('logged_in', $sess_array);
                //pre($sess_array,1);

                return TRUE;
            } else {
                $this->form_validation->set_message('_ValidateLogin', 'Your account is inactive');
                $this->session->set_flashdata('success_response', 'Your account is inactive! Please Enter the OTP Sent by Email');
            //    $this->session->set_flashdata('user/verify/'.$row->id, 5);//time to be redirected (in seconds)
            //    $this->session->set_flashdata('user/verify/'.$row->id, base_url('user/verify/'.$row->id));//url to be redirected
                redirect('user/verify/'.$row->id, 'refresh');

                return false;
            }
        } else {
            $this->form_validation->set_message('_ValidateLogin', 'Invalid Username or Password');
            return false;
        }
    }

//end: login user
//start: forget password
    function forgetpassword($redirect_flag = 0){
        is_admin_logged();
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
    //    $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_Validateemail');
        $this->form_validation->set_rules('cnic', 'CNIC', 'trim|required|callback__Validatecnic');
        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $cnic = $this->input->post('cnic', TRUE);
            $clean = $this->security->xss_clean($cnic);
            $userInfo = $this->login_model->getUserInfoByCnic($clean);
        /*
            $email = $this->input->post('email', TRUE);
            if (isset($email)) {
                $clean = $this->security->xss_clean($email);
                $userInfo = $this->login_model->getUserInfoByEmail($clean);
            }
        */
            $token = $this->login_model->insertToken($userInfo->id);
            $qstring = $this->base64url_encode($token);
            $link = site_url('reset-password/token/' . $qstring);
            //email tempalte
            $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'forgot_password'); //load temmpelate from table
            $EmailTemp = $EmailTemp->row();
            $subject = isset($EmailTemp->subject) ? $EmailTemp->subject : "Reset Password";  // subject of email
            $message = $EmailTemp->template; // template load
            $site_logo = site_url('assets/images/logo.png');
            $sitename = "Document Attestation";
            $find = array("{site_logo}", "{site_name}", "{link}", "{user_name}", "{username}");
            $replace = array($site_logo, $sitename, $link, $userInfo->fullname, $userInfo->username);
            $message = str_replace($find, $replace, $message);
            $From = "noreply@nhsrc.gov.pk"; //admin email for setting table
            $FromName = "Ministry of Health"; ////admin name for setting table
            if ($_SERVER['HTTP_HOST'] != 'localhost') {
            //    common_send_email($email, $subject, $message, $From, $FromName);
                common_send_email($userInfo->email, $subject, $message, $From, $FromName);
            }
            $this->session->set_flashdata('success_response', 'Help is on the way! Please check your email');
        //    redirect(site_url());
            redirect(site_url('forgetpassword/1'));
        }
        $data['title'] = "Forgot Password";
        $data['redirect_flag'] = $redirect_flag;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('forget_password', $data);
    }

    public function base64url_encode($data){
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function Validateemail(){
        $email = $this->input->post('email');
        //pre($email,1);
        $result = $this->common_model->getwherenew('tbl_users', 'email', $email);
        //pre($result,1);
        if ($result->num_rows() > 0) {
            $row = $result->row();
            if ($row->status == 'N') {
                $this->form_validation->set_message('Validateemail', 'Your account is not in approved status.');
                return false;
            }
            return true;
        } else {
            $this->form_validation->set_message('Validateemail', 'We cant find your email address.');
            return false;
        }
    }

    function _Validatecnic(){
        $cnic = $this->input->post('cnic');
        //pre($cnic,1);
        $result = $this->common_model->getwherenew('tbl_users', 'cnic', $cnic);
        if ($result->num_rows() > 0) {
            $row = $result->row();
            if ($row->status == 'N') {
            //    $this->form_validation->set_message('_Validatecnic', 'Your account is not in approved status.');
            //    return false;
                $this->form_validation->set_message('_Validatecnic', 'Your account is not in approved status. Please enter OTP sent to you on your Email ID to activate.');
                $this->session->set_flashdata('error_response', "Your account is not in approved status. Please enter OTP sent to you on your Email ID to activate.");
                redirect(site_url('user/verify/'.$row->id));
            }
            return true;
        } else {
            $this->form_validation->set_message('_Validatecnic', 'We cant find your cnic.');
            return false;
        }
    }

    public function reset_password($token = ''){
        $token = $this->base64url_decode($this->uri->segment(3));
        $cleanToken = $this->security->xss_clean($token);
        $user_info = $this->login_model->isTokenValid($cleanToken); //either false or array();
        // pre($user_info,1);
        if (!$user_info) {
            $this->session->set_flashdata('error_response', 'Token is invalid or expired');
            redirect(site_url());
        }
        $data = array(
            'firstName' => $user_info->fullname,
            'email' => $user_info->email,
            'token' => $this->base64url_encode($token),
            'title' => 'Reset Password'
        );
        // pre($data, 1);
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('reset_password', $data);
            //$this->load->view('includes/templates', $data);
        } else {
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = md5($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            $cleanPost['user_id'] = $user_info->id;
            unset($cleanPost['confirm_password']);
            if (!$this->login_model->updatePassword($cleanPost)) {
                $this->session->set_flashdata('error_response', 'There was a problem updating your password');
            } else {
                $this->session->set_flashdata('success_response', 'Your password has been updated. You may now login');
            }
            redirect(site_url());
        }
    }

    function base64url_decode($data){
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

//end: forget password
    function logout(){
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('login', 'refresh');
    }
}

//end bracket of main function
