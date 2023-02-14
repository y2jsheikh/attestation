<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('login_model');
    }

    function index(){
        is_session();
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $password_reset = getsinglefield('tbl_users','password_reset','WHERE id = "'.$user_id.'"');
        $this->load->helper(array('form'));
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback__ValidatePassword');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
        if ($this->form_validation->run() == TRUE) {
            $newpass = $this->input->post('new_password', TRUE);
            $update['password'] = md5($newpass);
            $update['password_reset'] = 'N';
            $update['updated'] = strtotime(date("Y-m-d H:i:s", time()));
            $this->common_model->update('tbl_users', $update, 'id = ' . $user_id);
            $this->session->set_flashdata('response', "PASSWORD CHANGE SUCCESSFULLY ");
            redirect(site_url('change_password'));
        }
        $data['title'] = 'Change Password ';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('user/change_password', $data, true); //true for return
        if ($password_reset == 'Y'){
            $this->load->view('template_2', $data);
        }else{
            $this->load->view('template', $data);
        }
    }

    function _ValidatePassword(){
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $password = md5($this->input->post('old_password', TRUE));
        $result = $this->login_model->check_password($password, $user_id);
        if ($result) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_ValidatePassword', 'Please Enter Correct Existing Password');
            return false;
        }
    }

}

?>