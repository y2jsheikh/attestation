<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Experience extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("experience_model");
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

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $insert['user_id'] = $this->input->post('user_id', TRUE);
            $emp_types = $this->input->post('emp_type[]', TRUE);
            $designation = $this->input->post('designation[]', TRUE);
            $institute = $this->input->post('institute[]', TRUE);
            $start_date = $this->input->post('start_date[]', TRUE);
            $end_date = $this->input->post('end_date[]', TRUE);
            $is_currently_working = $this->input->post('is_currently_working[]', TRUE);
            $time = time();
            if (!empty($emp_types) && count($emp_types)) {
                $i = 0;
                foreach ($emp_types as $emp_type) {
                    $insert['emp_type'] = $emp_type;
                    $insert['designation'] = $designation[$i];
                    $insert['institute'] = $institute[$i];
                    $insert['start_date'] = $start_date[$i];
                    $insert['end_date'] = $end_date[$i];
                    $insert['is_currently_working'] = $is_currently_working[$i];
                    $insert['created'] = $time;
                    $insert['created_by'] = $user_id;
                    $insert['updated'] = $time;
                    $insert['updated_by'] = $user_id;
                    $this->common_model->insert('tbl_user_experience', $insert);
                    $i++;
                }
                $this->session->set_flashdata('success_response', "EXPERIENCE ADDED SUCCESSFULLY ");
                redirect(site_url('experience/overseas'));
            }
        }
        $data['title'] = 'Experience';
        $data['is_qualification_entered'] = $is_qualification_entered > 0 ? 'Y' : 'N';
        $data['is_experience_entered'] = $is_experience_entered > 0 ? 'Y' : 'N';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['content'] = $this->load->view('experience/add', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function overseas(){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $user_data = $this->common_model->GetDataByFields('tbl_users', 'id, fullname, email, cnic, ecfmg_no, pmc_no', 'id = "'.$user_id.'"', 'row');
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $insert['user_id'] = $this->input->post('user_id', TRUE);
            $countries = $this->input->post('country[]', TRUE);
            $institute = $this->input->post('institute[]', TRUE);
            $position = $this->input->post('position[]', TRUE);
            $joining_date = $this->input->post('joining_date[]', TRUE);
            $purpose = $this->input->post('purpose[]', TRUE);
            ////////////////////// Statement of Need Fields //////////////////////
        //    $specialities = $this->input->post('speciality[]', TRUE);
        //    $yearss = $this->input->post('years[]', TRUE);
            ////////////////////// Statement of Need Fields //////////////////////

            $time = time();
            if (!empty($countries) && count($countries)) {
                $i = 0;
                foreach ($countries as $country) {
                    $insert['country'] = $country;
                    $insert['institute'] = $institute[$i];
                    $insert['position'] = $position[$i];
                    $insert['joining_date'] = $joining_date[$i];
                    $insert['purpose'] = $purpose[$i];
                    //////// Statement of Need Fields ////////
                //    $insert['speciality'] = $specialities[$i];
                //    $insert['years'] = $yearss[$i];
                    //////// Statement of Need Fields ////////
                    $insert['created'] = $time;
                    $insert['created_by'] = $user_id;
                    $insert['updated'] = $time;
                    $insert['updated_by'] = $user_id;
                    $this->common_model->insert('tbl_user_overseas_experience', $insert);
                    $i++;
                }
                $this->session->set_flashdata('success_response', "OVERSEAS EXPERIENCE ADDED SUCCESSFULLY ");
                redirect(site_url('attestation/request'));
            }
        }
        $data['title'] = 'Overseas Experience';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['filter_country_select'] = get_country('', '', 'filter_country', 'required', 'Select Country');
        $data['country_select'] = get_country('', '', 'country[]', 'required', 'Select Country');
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['content'] = $this->load->view('experience/add_overseas', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit($id){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $data['result'] = $this->experience_model->get_details($id);
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('emp_type', 'Employment Type', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $update['emp_type'] = $this->input->post('emp_type', TRUE);
            $update['designation'] = $this->input->post('designation', TRUE);
            $update['institute'] = $this->input->post('institute', TRUE);
            $update['start_date'] = $this->input->post('start_date', TRUE);
            $update['end_date'] = $this->input->post('end_date', TRUE);
            $update['updated'] = time();
            $update['updated_by'] = $user_id;
            $updateWhr['id'] = $id;
            $this->common_model->update('tbl_user_experience', $update, $updateWhr);
            $this->session->set_flashdata('success_response', "RECORD UPDATED SUCCESSFULLY ");
            redirect(site_url('experience'));
        }
        $data['title'] = 'Edit Experience';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['content'] = $this->load->view('experience/edit', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit_overseas($id){
        $data = [];
        $roles = [1,2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['result'] = $this->experience_model->get_overseas_details($id);
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $country = $this->input->post('country', TRUE) ? $this->input->post('country', TRUE) : $data['result']->country;

        if ($this->form_validation->run() == TRUE) {
            $update['country'] = $country;
            $update['institute'] = $this->input->post('institute', TRUE);
            $update['position'] = $this->input->post('position', TRUE);
            $update['joining_date'] = $this->input->post('joining_date', TRUE);
            $update['purpose'] = $this->input->post('purpose', TRUE);
            $update['updated'] = time();
            $update['updated_by'] = $user_id;
            $updateWhr['id'] = $id;
            $this->common_model->update('tbl_user_overseas_experience', $update, $updateWhr);
            $this->session->set_flashdata('success_response', "RECORD UPDATED SUCCESSFULLY ");
            redirect(site_url('experience/overseas'));
        }
        $data['title'] = 'Edit Overseas Experience';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['country_select'] = get_country($country);
        $data['content'] = $this->load->view('experience/edit_overseas', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function isExperienceEntered(){
        $user_id = $this->input->post('user_id', TRUE);
        $is_added = $this->common_model->counttotal('tbl_user_experience', 'user_id = "'.$user_id.'"');
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

    function isOverseasExperienceEntered(){
        $user_id = $this->input->post('user_id', TRUE);
        $is_added = $this->common_model->counttotal('tbl_user_overseas_experience', 'user_id = "'.$user_id.'"');
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
