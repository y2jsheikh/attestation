<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attestation extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("attest_model");
    }

    function index($current_status = ""){
        $roles = array(1,3,4,5);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Attestation';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['current_status'] = $current_status;
        $data['content'] = $this->load->view('attestation/view', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function scheduled($search_date = ""){
        $roles = array(1,4);
        checkUserAccess($roles);
        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Scheduled for Attestation';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['from_date'] = date('m/d/Y');
        $data['to_date'] = date('m/d/Y', strtotime("+7 day", time()));
        $data['role_id'] = $role_id;
        $data['search_date'] = $search_date;
        $data['content'] = $this->load->view('attestation/scheduled', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function receive(){
        $roles = array(4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Receive Applications';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->input->post('occupation_id', TRUE) ? $this->input->post('occupation_id', TRUE) : 0;
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('attest_id[]', 'Application Select', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $attest_ids = $this->input->post('attest_id[]', TRUE);
            $app_numbers = $this->input->post('app_number[]', TRUE);
            $fullnames = $this->input->post('fullname[]', TRUE);
            $cnics = $this->input->post('cnic[]', TRUE);
            $emails = $this->input->post('email[]', TRUE);
        //    pre($this->input->post(),1);
            $time = time();
            $update = array();
            if (!empty($attest_ids) && count($attest_ids) > 0) {
                $i = 0;
                foreach ($attest_ids as $attest_id) {
                    $is_checked = $this->input->post('is_checked_'.$i, TRUE);
                    $update['current_status'] = 'ministry_received';
                    if ($is_checked == 'on') {
                        $updateWhr['id'] = $attest_id;
                        $this->common_model->update('tbl_user_attestation', $update, $updateWhr);

                        $source = getsinglefield('tbl_user_attestation','source','WHERE id = "'.$attest_id.'"');
                        $log_id = $this->common_model->app_status_log($attest_id, $app_numbers[$i], '', 'pending', 'ministry_received', $user_id, '', '', $source);

                        $this->_send_ministry_received_email($user_id, $fullnames[$i], $emails[$i], $app_numbers[$i], $cnics[$i]);
                    //    $this->common_model->app_status_email($user_id, $fullnames[$i], $emails[$i], $app_numbers[$i], $cnics[$i], '', '', 'ministry_app_received');
                    }
                    $i++;
                }
            }
            $this->session->set_flashdata('success_response', "SELECTED APPLICATIONS RECEIVED SUCCESSFULLY");
            redirect(site_url('attestation/receive'));
        }
        $data['role_id'] = $role_id;
        $data['app_status'] = 'pending';
        $data['current_status'] = 'courier_received';
        $data['occupation_select'] = get_occupation($occupation_id);
        $data['content'] = $this->load->view('attestation/receive_and_dispatch', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function dispatch(){
        $roles = array(4);
        checkUserAccess($roles);

        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Receive Applications';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->input->post('occupation_id', TRUE) ? $this->input->post('occupation_id', TRUE) : 0;
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('attest_id[]', 'Application Select', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $attest_ids = $this->input->post('attest_id[]', TRUE);
            $app_numbers = $this->input->post('app_number[]', TRUE);
            $fullnames = $this->input->post('fullname[]', TRUE);
            $cnics = $this->input->post('cnic[]', TRUE);
            $emails = $this->input->post('email[]', TRUE);
            $statuses = $this->input->post('status[]', TRUE);
            $sources = $this->input->post('source[]', TRUE);
        //    pre($this->input->post(),1);
            $time = time();
            $update = array();
            if (!empty($attest_ids) && count($attest_ids) > 0) {
                $i = 0;
                foreach ($attest_ids as $attest_id) {
                    $update['current_status'] = 'ministry_dispatched';
                    $is_checked = $this->input->post('is_checked_'.$i, TRUE);

                /*
                    $source = getsinglefield('tbl_user_attestation','source','WHERE id = "'.$attest_id.'"');
                    if ($source == 'self') {
                        $update['current_status'] = "courier_dispatched";
                    }else{
                        $update['current_status'] = 'ministry_dispatched';
                    }
                */

                    if ($is_checked == 'on') {
                        $updateWhr['id'] = $attest_id;
                        $this->common_model->update('tbl_user_attestation', $update, $updateWhr);

                        $source = getsinglefield('tbl_user_attestation','source','WHERE id = "'.$attest_id.'"');
                        $log_id = $this->common_model->app_status_log($attest_id, $app_numbers[$i], '', $statuses[$i], 'ministry_dispatched', $user_id, '', '', $source);

                        $this->_send_ministry_dispatched_email($user_id, $fullnames[$i], $emails[$i], $app_numbers[$i], $cnics[$i], $sources[$i]);
                    //    $this->common_model->app_status_email($user_id, $fullnames[$i], $emails[$i], $app_numbers[$i], $cnics[$i], '', '', 'ministry_app_dispatched');
                    }
                    $i++;
                }
            }
            $this->session->set_flashdata('success_response', "SELECTED APPLICATIONS DISPATCHED SUCCESSFULLY");
            redirect(site_url('attestation/dispatch'));
        }
        $data['role_id'] = $role_id;
        $data['app_status'] = 'processed';
        $data['current_status'] = 'ministry_received';
        $data['occupation_select'] = get_occupation($occupation_id);
        $data['content'] = $this->load->view('attestation/receive_and_dispatch', $data, true); //true for return
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
        $is_request_pending = $this->common_model->counttotal("tbl_user_attestation","user_id = '".$user_id."' AND (status = 'pending')");
        if ($is_request_pending > 0){
            $this->session->set_flashdata('success_response', "Your Application for Attestation is Already Submitted. Please Check your Application Status.");
        //    redirect(site_url('attestation'));
            redirect(site_url('dashboard'));
        }
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
    //    $this->form_validation->set_rules('province_id', 'Province', 'trim|required');
        $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : 0;
        $slot_id = $this->input->post('slot_id', TRUE) ? $this->input->post('slot_id', TRUE) : 0;

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $doc_types = $this->input->post('doc_type[]', TRUE);
            $doc_exps = $this->input->post('doc_exp[]', TRUE);
            $source = $this->input->post('source', TRUE);
        //    $qualification_ids = $this->input->post('qualification_id[]', TRUE);
            $qualifications = $this->input->post('qualification[]', TRUE);
            $other_docs = $this->input->post('other_doc[]', TRUE);
            $insert['user_id'] = $this->input->post('user_id', TRUE);
        //    $insert['is_application_form'] = $this->input->post('is_application_form', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_affidavit_attested'] = $this->input->post('is_affidavit_attested', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_degree'] = $this->input->post('is_copy_of_degree', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_pmc'] = $this->input->post('is_copy_of_pmc', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_pmdc'] = $this->input->post('is_copy_of_pmdc', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_pnc'] = $this->input->post('is_copy_of_pnc', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_crc'] = $this->input->post('is_copy_of_crc', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_cnic'] = $this->input->post('is_copy_of_cnic', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_passport'] = $this->input->post('is_copy_of_passport', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_copy_of_experience'] = $this->input->post('is_copy_of_experience', TRUE) == 'on' ? 'Y' : 'N';
            $insert['is_orignal_doc_attached'] = $this->input->post('is_orignal_doc_attached', TRUE) == 'on' ? 'Y' : 'N';
            $insert['province'] = $this->input->post('province', TRUE);
            $insert['province_id'] = $province_id;
            $insert['source'] = $source;
            if ($source == 'self') {
                $insert['current_status'] = 'courier_received';
            } else {
                $insert['current_status'] = 'user_submitted';
            }
            /////////////////////////////////////////////////
            if ($province_id == 4 || $province_id == 8){
                $insert['courier_receive_role'] = 5;
                $insert['courier_receive_role_name'] = 'M&P';
            }else{
                $insert['courier_receive_role'] = 3;
                $insert['courier_receive_role_name'] = 'TCS';
            }
            /////////////////////////////////////////////////
            $insert['created'] = $time;
            $insert['created_by'] = $user_id;
            $insert['updated'] = $time;
            $insert['updated_by'] = $user_id;
            $insert_id = $this->common_model->insert('tbl_user_attestation', $insert);
            $app_number = "1".str_pad($insert_id,10,"0",STR_PAD_LEFT);
        //    $app_number = str_pad($insert_id,10,"0",STR_PAD_LEFT);

            ////////////////////////////////////////////////////////////////////////////////////////
            if ($source == 'self') {
                $insertSchedule['visit_date'] = $this->input->post('visit_date', TRUE);
                $insertSchedule['slot_id'] = $slot_id;
                $insertSchedule['slot'] = $this->input->post('slot', TRUE);
                $insertSchedule['user_id'] = $user_id;
                $insertSchedule['created_date'] = date('Y-m-d H:i:s');
                $schedule_id = $this->common_model->insert('tbl_schedular', $insertSchedule);
            }
            ////////////////////////////////////////////////////////////////////////////////////////

            if (!empty($doc_types) && count($doc_types) > 0){
                $i = 0;
                foreach ($doc_types as $doc_type){
                    $insertA['user_attestation_id'] = $insert_id;
                    $insertA['user_id'] = $insert['user_id'];
                    $insertA['doc_type'] = $doc_type;
                    $insertA['doc_exp'] = $doc_exps[$i];
                //    $insertA['user_qualification_id'] = $qualification_ids[$i];

                //    $insertA['qualification'] = $qualifications[$i];
                //    $insertA['other_doc'] = $other_docs[$i];
                    $insertA['qualification'] = $other_docs[$i] != '' ? $other_docs[$i] : $qualifications[$i];

                    $insertA['status'] = 'pending';
                    $insertA['created'] = $time;
                    $insertA['created_by'] = $user_id;
                    $insertA['updated'] = $time;
                    $insertA['updated_by'] = $user_id;
                    $this->common_model->insert('tbl_user_attestation_document',$insertA);

                    /*
                    $update['status'] = 'in_process';
                    $updateWhr = "user_id = '".$insert['user_id']."' AND qualification_id = '".$qualification_ids[$i]."'";
                    $this->common_model->update('tbl_user_qualification', $update, $updateWhr);
                    */

                    $i++;
                }

                $updateAttest['no_of_docs'] = $i;
                $updateAttest['app_number'] = $app_number;
                $updateAttestWhr['id'] = $insert_id;

                // Attestation App number and No. of Docs Updated...
                $this->common_model->update('tbl_user_attestation', $updateAttest, $updateAttestWhr);
            }
            if ($source == 'courier'){
                $this->session->set_flashdata('success_response', "Your Application has been saved as Draft. Click Save Application to Save Or Click Back to Edit. Please Confirm your all entered Documents should be equal to Physical Copies, otherwise Courier will not accept the application.");
            }else{
                $this->session->set_flashdata('success_response', "Your Application has been saved as Draft. Click Save Application to Save Or Click Back to Edit.");
            }
            redirect(site_url('attestation/print_form/'.$insert_id.'/'.$insert['user_id']));
        }
        $data['title'] = 'Request Attestation';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_id'] = $occupation_id;
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['province_select'] = get_province($province_id);
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['user_doc_select'] = $this->_userDocuments($user_id);
        $data['time_slot_select'] = get_time_slot($slot_id, 'status = "Y"');
        $data['content'] = $this->load->view('attestation/request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit_request($attest_request_id){
        $data = [];
        $roles = [2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $user_data = $this->common_model->GetDataByFields('tbl_users', '*', 'id = "'.$user_id.'"', 'row');

        $data['result'] = $this->attest_model->get_attest_document_details($attest_request_id);
        $data['scheduler_data'] = $this->common_model->GetDataByFields('tbl_schedular', 'visit_date, slot_id, slot', 'user_id = "'.$user_id.'"', 'row', 'DESC', 1);
        //    pre($data['scheduler_data'],1);
        $is_user = $this->common_model->counttotal("tbl_user_attestation","user_id = '".$user_id."' AND id = '".$attest_request_id."'");
        if ($is_user == 0){
            $this->session->set_flashdata('success_response', "ACCESS DENIED...");
            redirect(site_url('dashboard'));
        }
        $slot_id = !empty($data['scheduler_data']->slot_id) ? $data['scheduler_data']->slot_id : 0;
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : $data['result'][0]['province_id'];
        $slot_id = $this->input->post('slot_id', TRUE) ? $this->input->post('slot_id', TRUE) : $slot_id;

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $doc_types = $this->input->post('doc_type[]', TRUE);
            $doc_exps = $this->input->post('doc_exp[]', TRUE);
            $source = $this->input->post('source', TRUE);
            $qualifications = $this->input->post('qualification[]', TRUE);
            $other_docs = $this->input->post('other_doc[]', TRUE);
            $update['user_id'] = $this->input->post('user_id', TRUE);
            //    $update['is_application_form'] = $this->input->post('is_application_form', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_affidavit_attested'] = $this->input->post('is_affidavit_attested', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_degree'] = $this->input->post('is_copy_of_degree', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_pmc'] = $this->input->post('is_copy_of_pmc', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_pmdc'] = $this->input->post('is_copy_of_pmdc', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_pnc'] = $this->input->post('is_copy_of_pnc', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_crc'] = $this->input->post('is_copy_of_crc', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_cnic'] = $this->input->post('is_copy_of_cnic', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_passport'] = $this->input->post('is_copy_of_passport', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_copy_of_experience'] = $this->input->post('is_copy_of_experience', TRUE) == 'on' ? 'Y' : 'N';
            $update['is_orignal_doc_attached'] = $this->input->post('is_orignal_doc_attached', TRUE) == 'on' ? 'Y' : 'N';
            $update['province'] = $this->input->post('province', TRUE);
            $update['province_id'] = $province_id;
            ////////////////////////////////////////////////////
            $update['source'] = $source;
            if ($source == 'self') {
                //    $update['current_status'] = 'ministry_received';
                $update['current_status'] = 'courier_received';
            } else {
                $update['current_status'] = 'user_submitted';
            }
            ////////////////////////////////////////////////////
            $update['created'] = $time;
            $update['created_by'] = $user_id;
            $update['updated'] = $time;
            $update['updated_by'] = $user_id;
            $updateAttestWhr['id'] = $attest_request_id;
            $this->common_model->update('tbl_user_attestation', $update, $updateAttestWhr);
            $app_number = $data['result'][0]['app_number'];
            ////////////////////////////////////////////////////////////////////////////////////////
            if ($source == 'self') {
                $visit_date = $this->input->post('visit_date', TRUE);
                $scheduleWhr = 'user_id = "'.$user_id.'" AND visit_date = "'.$visit_date.'"';
                $is_schedule = $this->common_model->counttotal('tbl_schedular', $scheduleWhr);
                if ($is_schedule > 0){
                    $this->common_model->delete('tbl_schedular', $scheduleWhr);
                }
                $insertSchedule['visit_date'] = $visit_date;
                $insertSchedule['slot_id'] = $slot_id;
                $insertSchedule['slot'] = $this->input->post('slot', TRUE);
                $insertSchedule['user_id'] = $user_id;
                $insertSchedule['created_date'] = date('Y-m-d H:i:s');
                $schedule_id = $this->common_model->insert('tbl_schedular', $insertSchedule);
            }
            ////////////////////////////////////////////////////////////////////////////////////////

            if (!empty($doc_types) && count($doc_types) > 0){
                // First Delete the older record before entering the new one...
                $this->common_model->delete('tbl_user_attestation_document','user_attestation_id = "'.$attest_request_id.'"');
            //    pre($doc_types);
            //    pre($attest_request_id,1);

                $i = 0;
                foreach ($doc_types as $doc_type){
                    $insertA['user_attestation_id'] = $attest_request_id;
                    $insertA['user_id'] = $update['user_id'];
                    $insertA['doc_type'] = $doc_type;
                    $insertA['doc_exp'] = $doc_exps[$i];
                    $insertA['qualification'] = $other_docs[$i] != '' ? $other_docs[$i] : $qualifications[$i];

                    $insertA['status'] = 'pending';
                    $insertA['created'] = $time;
                    $insertA['created_by'] = $user_id;
                    $insertA['updated'] = $time;
                    $insertA['updated_by'] = $user_id;
                    $this->common_model->insert('tbl_user_attestation_document',$insertA);
                    $i++;
                }

                $updateAttest['no_of_docs'] = $i;
                $updateAttest['app_number'] = $app_number;
                $updateAttestWhr['id'] = $attest_request_id;

                // Attestation App number and No. of Docs Updated...
                $this->common_model->update('tbl_user_attestation', $updateAttest, $updateAttestWhr);
            }

        //    $this->session->set_flashdata('success_response', "Your Application has been saved as Draft. Click Save Application to Save Or Click Back to Edit.");
            if ($source == 'courier'){
                $this->session->set_flashdata('success_response', "Your Application has been saved as Draft. Click Save Application to Save Or Click Back to Edit. Please Confirm your all entered Documents should be equal to Physical Copies, otherwise Courier will not accept the application.");
            }else{
                $this->session->set_flashdata('success_response', "Your Application has been saved as Draft. Click Save Application to Save Or Click Back to Edit.");
            }
        //    $this->session->set_flashdata('success_response', "YOUR APPLICATION NO. IS ".$app_number.". PLEASE PRINT OUT YOUR FORM AND ATTACH IT WITH THE DOCUMENT(S)");
            redirect(site_url('attestation/print_form/'.$attest_request_id.'/'.$update['user_id']));
        }
        $data['title'] = 'Edit Request';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_id'] = $occupation_id;
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['province_select'] = get_province($province_id);
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['user_doc_select'] = $this->_userDocuments($user_id);
        $data['time_slot_select'] = get_time_slot($slot_id, 'status = "Y"');
        $data['content'] = $this->load->view('attestation/edit_request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function save_application($attest_request_id){
        $data = [];
        $roles = [2];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $user_data = $this->common_model->GetDataByFields('tbl_users', 'id, fullname, email, cnic', 'id = "'.$user_id.'"', 'row');
        $attest_data = $this->common_model->GetDataByFields('tbl_user_attestation', 'app_number, courier_receive_role, courier_receive_role_name, status, source, current_status', 'id = "'.$attest_request_id.'"', 'row');

        $updateAttest['application_submitted'] = "Y";
        $updateAttest['updated'] = time();
        $updateAttest['updated_by'] = $user_id;
        $updateAttestWhr['id'] = $attest_request_id;

        // Attestation Final Submission Updated...
        $this->common_model->update('tbl_user_attestation', $updateAttest, $updateAttestWhr);
        // Current Status log Entered...
        $log_id = $this->common_model->app_status_log($attest_request_id, $attest_data->app_number, '', 'pending', $attest_data->current_status, $user_id, $attest_data->courier_receive_role, $attest_data->courier_receive_role_name, $attest_data->source);
        // Email sent on successful application submission...

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $courier = getsinglefield('tbl_user_attestation','courier_receive_role','WHERE id = "'.$attest_request_id.'"');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($attest_data->source == 'courier') {
            // For Courier
            $this->_send_submitted_email($user_data->id, $user_data->fullname, $user_data->email, $attest_data->app_number, $user_data->cnic, $courier);
        }elseif ($attest_data->source == 'self'){
            // For Self
            $this->_send_submitted_email_self($user_data->id, $user_data->fullname, $user_data->email, $attest_data->app_number, $user_data->cnic);
        }

        $this->session->set_flashdata('success_response', "Your Application No. is ".$attest_data->app_number.". Please Print Out Your Form and Attach it with the Document(s). A Confirmation Email has also been sent to your provided Email ID.");
    //    redirect(site_url('dashboard'));
        redirect(site_url('attestation/print_form/'.$attest_request_id.'/'.$user_data->id));
    }

    function _send_submitted_email($user_id = '', $full_name = "", $to = '', $app_no = '', $user_cnic = '', $courier_role = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'application_submitted'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;

        $courier_name = "TCS";
        $courier_url = base_url('assets/docs/tcs_centers.pdf');
        if ($courier_role == 3){
            $courier_name = "TCS";
            $courier_url = base_url('assets/docs/tcs_centers.pdf');
        } elseif ($courier_role == 5){
            $courier_name = "MnP";
            $courier_url = base_url('assets/docs/mnp_centers.pdf');
        }

        $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}", "{courier_name}", "{url}");
        $replace = array($full_name, $to, $app_no, $user_cnic, $courier_name, $courier_url);
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

    function _send_submitted_email_self($user_id = '', $full_name = "", $to = '', $app_no = '', $user_cnic = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'application_submitted_self'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}");
        $replace = array($full_name, $to, $app_no, $user_cnic);
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

    function _send_status_email($status = '', $full_name = "", $to = '', $app_no = '', $user_cnic = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'ministry_app_status'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}", "{status}");
        $replace = array($full_name, $to, $app_no, $user_cnic, $status);
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

    function _send_ministry_received_email($user_id = '', $full_name = "", $to = '', $app_no = '', $user_cnic = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', 'ministry_app_received'); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}");
        $replace = array($full_name, $to, $app_no, $user_cnic);
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

    function _send_ministry_dispatched_email($user_id = '', $full_name = "", $to = '', $app_no = '', $user_cnic = '', $source = ''){
        $this->load->library('email'); //load email library
        $template_value = $source == 'self' ? 'ministry_app_dispatched_self' : 'ministry_app_dispatched';
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', $template_value); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        if ($source == 'self') {
            $find = array("{fullname}", "{email}", "{app_no}", "{user_cnic}");
            $replace = array($full_name, $to, $app_no, $user_cnic);
        }elseif ($source == 'courier'){
            $find = array("{fullname}", "{email}", "{app_no}", "{courier_name}", "{user_cnic}");
            $replace = array($full_name, $to, $app_no, 'TCS', $user_cnic);
        }
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

    function _userDocuments($user_id){
        $this->load->model('qualification_model');
        $result = $this->qualification_model->get_user_qualifications('', $user_id);
        $html = '';
        $html .= '<select class="form-control input-paf qualification-class" name="qualification_id[]" required>';
        $html .= '<option value="">Select Document</option>';
        if (!empty($result) && count($result) > 0){
            $i = 0;
            foreach ($result as $row){
                $html .= '<option value="'.$row->id.'">'.$row->qualification.'</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    function attestation_request(){
        $data = [];
        $roles = [1,4];
        checkUserAccess($roles);
        $data['title'] = 'Attestation Requests';
        $data['content'] = $this->load->view('attestation/attest_request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function print_form($attest_id, $user_id){
        $roles = array(1,2,3,4,5);
        checkUserAccess($roles);
        $data = array();
        $data['title'] = 'Print';
        $role_id = $this->session->userdata['logged_in']['role_id'];
    //    $user_id = $this->session->userdata['logged_in']['id'];
        $data['role_id'] = $role_id;
        $data['result'] = $this->attest_model->get_attest_user_details($attest_id, $user_id);
        $data['qualification'] = $this->common_model->GetDataByFields('tbl_user_qualification', '*', 'user_id = "'.$user_id.'"', 'object');
        $data['experience'] = $this->common_model->GetDataByFields('tbl_user_experience', '*', 'user_id = "'.$user_id.'"', 'object');
        $data['overseas_experience'] = $this->common_model->GetDataByFields('tbl_user_overseas_experience', '*', 'user_id = "'.$user_id.'"', 'object');
        $data['attest'] = $this->attest_model->get_attest_document_details($attest_id, $user_id);
        //pre($data['attest'],1);
        $this->load->view('attestation/print_form', $data); //true for return
    }

    function status_update($app_number = '', $attest_request_id = '', $cnic = ''){
        $roles = array(1,2,4);
        checkUserAccess($roles);
        $where = "";
        $data = array();
    //    $this->load->helper('form');
        $data['title'] = 'Attestation';
    //    $source = "courier";
    //    $data['result'] = $this->common_model->GetDataByFields('tbl_user_attestation_document', '*', $where);
        $data['result'] = $this->attest_model->get_attest_document_details($attest_request_id, '', $cnic, 'pending', $app_number);
        if (!empty($data['result']) && count($data['result']) > 0){
            $attest_request_id = $data['result'][0]['user_attestation_id'];
        //    $source = $data['result'][0]['source'];
        }else{
            $this->session->set_flashdata('success_response', "NO PENDING APPLICATION FOUND");
        //    redirect(site_url('attestation'));
            redirect(site_url('attestation/ministry_received'));
        }
        $data['attest_request_id'] = $attest_request_id;
        // For status change request
        $request_status = 'pending';

        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];

        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('status[]', 'Status', 'trim');

        if ($this->form_validation->run() == TRUE) {
        //    pre($this->input->post(),1);
            $time = time();
            $no_of_docs = $this->input->post('no_of_docs', TRUE);
            $record = $this->input->post('rec[]', TRUE);
            $user_qualification_ids = $this->input->post('user_qualification_id[]', TRUE);
            $statuses = $this->input->post('status[]', TRUE);
            $remarkss = $this->input->post('remarks[]', TRUE);

            if (!empty($record) && count($record) > 0){
                $i = 0;
                $pending_count = 0;
                $accepted_count = 0;
                $rejected_count = 0;
                $not_received_count = 0;
                foreach ($record as $rec){
                //    $id = $rec;
                    $user_qualification_id = $user_qualification_ids[$i];
                    $update['status'] = $statuses[$i];
                    $update['remarks'] = $remarkss[$i];
                    $update['updated'] = $time;
                    $update['updated_by'] = $user_id;
                    $updateWhr['id'] = $rec;
                    $this->common_model->update('tbl_user_attestation_document', $update, $updateWhr);

                    $updateQualify['status'] = 'pending';

                    if ($statuses[$i] == 'pending'){
                        $pending_count = $pending_count + 1;
                        $updateQualify['status'] = 'pending';
                    }
                    if ($statuses[$i] == 'accepted'){
                        $accepted_count = $accepted_count + 1;
                        $updateQualify['status'] = 'completed';
                    }
                    if ($statuses[$i] == 'not_received'){
                        $not_received_count = $not_received_count + 1;
                        $updateQualify['status'] = 'rejected';
                    }
                    if ($statuses[$i] == 'rejected'){
                        $rejected_count = $rejected_count + 1;
                        $updateQualify['status'] = 'rejected';
                    }

                    $updateQualifyWhr = "id = '".$user_qualification_ids[$i]."'";
                    $this->common_model->update('tbl_user_qualification', $updateQualify, $updateQualifyWhr);

                    $i++;
                }

                if ($pending_count > 0){
                    $request_status = "pending";
                    $display_status = "Pending";
                }else {
                    if ($no_of_docs == $accepted_count) {
                        $request_status = "attested";
                        $display_status = "Attested";
                    } elseif ($no_of_docs == $rejected_count) {
                        $request_status = "rejected";
                        $display_status = "Rejected";
                    } elseif ($no_of_docs == $not_received_count) {
                        $request_status = "rejected";
                        $display_status = "Rejected";
                    } else {
                        $request_status = "partially_attested";
                        $display_status = "Partially Attested";
                    }
                }

                $updateRequest['status'] = $request_status;
                /*
                if ($source == 'self') {
                    $updateRequest['current_status'] = "courier_dispatched";
                }
                */
                $updateRequestWhr['id'] = $attest_request_id;
                $this->common_model->update('tbl_user_attestation', $updateRequest, $updateRequestWhr);

                $source = getsinglefield('tbl_user_attestation','source','WHERE id = "'.$attest_request_id.'"');
                $log_id = $this->common_model->app_status_log($attest_request_id, $app_number, '', $request_status, '', $user_id, '', '', $source);

                if ($request_status != '' && $request_status != 'pending'){
                    $this->_send_status_email($display_status, $data['result'][0]['user_name'], $data['result'][0]['email'], $data['result'][0]['app_number'], $data['result'][0]['cnic']);
                //    $this->common_model->app_status_email('', $data['result'][0]['user_name'], $data['result'][0]['email'], $data['result'][0]['app_number'], $data['result'][0]['cnic'], '', $display_status, 'ministry_app_status');
                }
            }

            $this->session->set_flashdata('success_response', "PROCESS COMPLETED SUCCESSFULLY ");
        //    redirect(site_url('attestation'));
            redirect(site_url('attestation/ministry_received'));
        }

        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $role_id;
        $data['content'] = $this->load->view('attestation/status_update', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function call_barcode($number = ''){
        $user_cnic = $this->session->userdata['logged_in']['cnic'];
        echo barcode("", $number);
        exit;
    }

    function courier_receive_documents(){
        $roles = [3, 5];
        checkUserAccess($roles);
        $data = array();
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];

        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('attest_document_id[]', 'Document(s)', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $attest_request_id = $this->input->post('attest_request_id', TRUE);
            $attest_document_ids = $this->input->post('attest_document_id[]', TRUE);
            //    pre($this->input->post(),1);
            $time = time();
            $update = array();
            if (!empty($attest_document_ids) && count($attest_document_ids) > 0) {
                $i = 0;
                foreach ($attest_document_ids as $attest_document_id) {
                    $is_courier_recieved = $this->input->post('is_courier_recieved_'.$i, TRUE);
                    $update['is_courier_recieved'] = 'Y';
                    if ($is_courier_recieved == 'on') {
                        $updateWhr['id'] = $attest_document_id;
                        $this->common_model->update('tbl_user_attestation_document', $update, $updateWhr);
                    }
                    $i++;
                }
            }
            $this->session->set_flashdata('success_response', "SELECTED DOCUMENT(S) RECEIVED SUCCESSFULLY");
            redirect(site_url('report/attest_detail/'.$attest_request_id));
        }else{
            $this->session->set_flashdata('success_response', "PLEASE SELECT DOCUMENT(s) TO PROCEED");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function self_add($user_attestation_id){
        $data = [];
        $roles = [2];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $user_data = $this->common_model->GetDataByFields('tbl_users', '*', 'id = "'.$user_id.'"', 'row');
        $is_request_pending = $this->common_model->counttotal("tbl_user_attestation","user_id = '".$user_id."' AND (status = 'pending')");
        if ($is_request_pending > 0){
            $this->session->set_flashdata('success_response', "YOUR APPLICATION FOR ATTESTATION IS ALREADY SUBMITTED. PLEASE CHECK YOU APPLICATION STATUS.");
            //    redirect(site_url('attestation'));
            redirect(site_url('dashboard'));
        }
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        //    $this->form_validation->set_rules('province_id', 'Province', 'trim|required');
        $province_id = $this->input->post('province_id', TRUE) ? $this->input->post('province_id', TRUE) : 0;
        $slot_id = $this->input->post('slot_id', TRUE) ? $this->input->post('slot_id', TRUE) : 0;

        if ($this->form_validation->run() == TRUE) {
            //    pre($this->input->post(),1);
            $time = time();
            $doc_types = $this->input->post('doc_type[]', TRUE);
            $doc_exps = $this->input->post('doc_exp[]', TRUE);
            $source = $this->input->post('source', TRUE);
            //    $qualification_ids = $this->input->post('qualification_id[]', TRUE);
            $qualifications = $this->input->post('qualification[]', TRUE);
            $other_docs = $this->input->post('other_doc[]', TRUE);

            ////////////////////////////////////////////////////////////////////////////////////////
            if ($source == 'self') {
                $insertSchedule['visit_date'] = $this->input->post('visit_date', TRUE);
                $insertSchedule['slot_id'] = $slot_id;
                $insertSchedule['slot'] = $this->input->post('slot', TRUE);
                $insertSchedule['user_id'] = $user_id;
                $insertSchedule['created_date'] = date('Y-m-d H:i:s');
                $schedule_id = $this->common_model->insert('tbl_schedular', $insertSchedule);
            }
            ////////////////////////////////////////////////////////////////////////////////////////
            $this->session->set_flashdata('success_response', "Application Updated Successfully");
            //    redirect(site_url('attestation'));
            //    redirect(site_url('dashboard'));
            redirect(site_url('attestation/ministry_received'));
        }
        $data['title'] = 'Add Document';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['occupation_id'] = $occupation_id;
        $data['role_id'] = $user_role_id;
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;
        $data['province_select'] = get_province($province_id);
        $data['user_select'] = get_user(0, '', 'user_id', 'required', 'Select User');
        $data['user_doc_select'] = $this->_userDocuments($user_id);
        $data['time_slot_select'] = get_time_slot($slot_id, 'status = "Y"');
        $data['content'] = $this->load->view('attestation/self_add_request', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function delete($attest_request_id){
        $data = [];
        $roles = [1];
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $updateAttest['deleted'] = "Y";
        $updateAttest['deleted_by'] = $user_id;
        $updateAttestWhr['id'] = $attest_request_id;

        // Attestation Final Submission Updated...
        $this->common_model->update('tbl_user_attestation', $updateAttest, $updateAttestWhr);
        $this->session->set_flashdata('success_response', "Application is deleted Successfully.");
        redirect(site_url('report'));
    }

    /*
    function delete_user_application($user_id){
        $is_user = 0;
        $where = 'user_id = "'.$user_id.'"';
        $is_user = $this->common_model->counttotal('tbl_app_status_log', $where);
        if ($is_user > 0){
            $this->common_model->delete('tbl_app_status_log',$where);
        }

        $is_user = $this->common_model->counttotal('tbl_schedular', $where);
        if ($is_user > 0){
            $this->common_model->delete('tbl_schedular',$where);
        }

        $is_user = $this->common_model->counttotal('tbl_user_attestation', $where);
        if ($is_user > 0){
            $this->common_model->delete('tbl_user_attestation',$where);
        }

        $is_user = $this->common_model->counttotal('tbl_user_attestation_document', $where);
        if ($is_user > 0){
            $this->common_model->delete('tbl_user_attestation_document',$where);
        }
    }
    */

    function reset_application($attest_id){
        $is_app = $this->common_model->counttotal('tbl_user_attestation', 'id = "'.$attest_id.'"');
        if ($is_app > 0){
            $update['cn_number'] = null;
            $update['status'] = 'pending';
            $update['current_status'] = 'user_submitted';
            $update['application_submitted'] = 'N';
            $update['deleted'] = 'N';
            $update['deleted_by'] = null;
            $updateWhr['id'] = $attest_id;
            $this->common_model->update('tbl_user_attestation', $update, $updateWhr);

            $updateDoc['status'] = 'pending';
            $updateDoc['is_courier_recieved'] = 'N';
            $updateDocWhr['user_attestation_id'] = $attest_id;
            $this->common_model->update('tbl_user_attestation_document', $updateDoc, $updateDocWhr);
            $this->session->set_flashdata('success_response', "Application Reset Successfully.");
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('success_response', "Application Not Found.");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function cancel_application($attest_id, $user_id){
        $roles = array(2);
        checkUserAccess($roles);
        $is_app = $this->common_model->counttotal('tbl_user_attestation', 'id = "'.$attest_id.'" AND user_id = "'.$user_id.'"');
        if ($is_app > 0){
            $update['status'] = 'cancelled';
            $update['current_status'] = 'cancelled';
            $updateWhr['id'] = $attest_id;
            $this->common_model->update('tbl_user_attestation', $update, $updateWhr);

            $updateDoc['status'] = 'cancelled';
            $updateDocWhr['user_attestation_id'] = $attest_id;
            $this->common_model->update('tbl_user_attestation_document', $updateDoc, $updateDocWhr);

            $attest_data = $this->common_model->GetDataByFields('tbl_user_attestation', 'app_number, source', 'id = "'.$attest_id.'"', 'row');
            $log_id = $this->common_model->app_status_log($attest_id, $attest_data->app_number, '', 'cancelled', 'cancelled', $user_id, '', '', $attest_data->source);

            $this->session->set_flashdata('success_response', "Application Cancelled Successfully.");
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('success_response', "Application Not Found.");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
