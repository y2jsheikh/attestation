<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qualification extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("qualification_model");
    }

    function index(){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $is_qualification_entered = $this->common_model->counttotal('tbl_user_qualification','user_id = "'.$user_id.'"');
        $is_experience_entered = $this->common_model->counttotal('tbl_user_experience','user_id = "'.$user_id.'"');
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
    //    $this->form_validation->set_rules('qualification_id', 'Qualification', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $insert['user_id'] = $this->input->post('user_id', TRUE);
            $qualification_areas = $this->input->post('qualification_area[]', TRUE);
            $qualifications = $this->input->post('qualification[]', TRUE);
            $institute = $this->input->post('institute[]', TRUE);
            $completion_year = $this->input->post('completion_year[]', TRUE);
            $time = time();
            if (!empty($qualification_areas) && count($qualification_areas)) {
                $i = 0;
                foreach ($qualification_areas as $qualification_area) {
                    $insert['qualification_area'] = $qualification_area;
                    $insert['qualification'] = $qualifications[$i];
                    $insert['institute'] = $institute[$i];
                    $insert['completion_year'] = $completion_year[$i];
                    $insert['created'] = $time;
                    $insert['created_by'] = $user_id;
                    $insert['updated'] = $time;
                    $insert['updated_by'] = $user_id;
                    $insert['status'] = 'pending';
                    $this->common_model->insert('tbl_user_qualification', $insert);
                    $i++;
                }
                $this->session->set_flashdata('success_response', "QUALIFICATIONS ADDED SUCCESSFULLY ");
                redirect(site_url('experience'));
            }
        }
        $data['title'] = 'Academics';
        $data['is_qualification_entered'] = $is_qualification_entered > 0 ? 'Y' : 'N';
        $data['is_experience_entered'] = $is_experience_entered > 0 ? 'Y' : 'N';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['qualification_select'] = get_qualification(0, '', 'qualification_id[]', 'required', 'Select Qualification');
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['content'] = $this->load->view('qualification/add', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit($id){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $data['result'] = $this->qualification_model->get_details($id);
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('qualification_area', 'Qualification Area', 'trim|required');
        $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $update['qualification_area'] = $this->input->post('qualification_area', TRUE);
            $update['qualification'] = $this->input->post('qualification', TRUE);
            $update['institute'] = $this->input->post('institute', TRUE);
            $update['completion_year'] = $this->input->post('completion_year', TRUE);
            $update['updated'] = time();
            $update['updated_by'] = $user_id;
            $updateWhr['id'] = $id;
            $this->common_model->update('tbl_user_qualification', $update, $updateWhr);
            $this->session->set_flashdata('success_response', "RECORD UPDATED SUCCESSFULLY ");
            redirect(site_url('qualification'));
        }
        $data['title'] = 'Edit Academics';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
    //    $data['rec_id'] = $id;
        $data['content'] = $this->load->view('qualification/edit', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _ValidateQualification(){
        $qualification_id = $this->input->post('qualification_id', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
    //    $id = $this->input->post('id', TRUE) ? $this->input->post('id', TRUE) : 0;
    //    pre($this->input->post(),1);
        $result = $this->qualification_model->unique_check($qualification_id, $user_id);
        if ($result) {
            $this->form_validation->set_message('_ValidateQualification', 'Degree/Transcript Already Added');
            return false;
        } else {
            return TRUE;
        }
    }

    function isQualificationEntered(){
        $user_id = $this->input->post('user_id', TRUE);
        $is_added = $this->common_model->counttotal('tbl_user_qualification', 'user_id = "'.$user_id.'"');
        if ($is_added > 0){
            $data['status'] = "success";
            $data['message'] = "Record Already Exists";
        }else{
            $data['status'] = "error";
            $data['message'] = "No Record Found";
        }
        $result = json_encode($data);
        echo $result;
        exit;
    }

}
