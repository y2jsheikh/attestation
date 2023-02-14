<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signatory extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("signatory_model");
    }

    function index(){
        $roles = array(1,4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Signatory';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['content'] = $this->load->view('signatory/view', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function delete($id){
        $roles = [1];
        checkUserAccess($roles);
        $where = ['id' => $id];
        $this->common_model->delete("tbl_signatory", $where);
        $this->session->set_flashdata('success_response', "Signatory Deleted Successfully");
        redirect(base_url('signatory'));
    }

    function add(){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
    //    $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
    //    $this->form_validation->set_rules('department', 'Department', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $insert['name'] = $this->input->post('name', TRUE);
            $insert['designation'] = $this->input->post('designation', TRUE);
            $insert['department'] = $this->input->post('department', TRUE);
            $insert['created'] = $time;
            $insert['created_by'] = $user_id;
            $insert['updated'] = $time;
            $insert['updated_by'] = $user_id;
            $insert_id = $this->common_model->insert('tbl_signatory', $insert);
            $this->session->set_flashdata('success_response', "Signatory has been added successfully.");
            redirect(site_url('signatory'));
        }
        $data['title'] = 'Signatory';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['content'] = $this->load->view('signatory/add', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit($id){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
    //    $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $data['result'] = $this->signatory_model->get_signatory_details($id);
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
    //    $this->form_validation->set_rules('department', 'Department', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $update['name'] = $this->input->post('name', TRUE);
            $update['designation'] = $this->input->post('designation', TRUE);
            $update['department'] = $this->input->post('department', TRUE);
            $update['status'] = $this->input->post('status', TRUE);
            $update['updated'] = $time;
            $update['updated_by'] = $user_id;
            $updateWhr['id'] = $id;
            $this->common_model->update('tbl_signatory', $update, $updateWhr);
            redirect(site_url('signatory'));
        }
        $data['title'] = 'Edit Signatory';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['content'] = $this->load->view('signatory/edit', $data, true); //true for return
        $this->load->view('template', $data);
    }

}
