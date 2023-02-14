<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends CI_Controller{

    function __construct(){
        parent::__construct();
    }

    function centers($courier = ''){
        $data = [];
        $roles = [3,5];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $center_name = $courier."_centers";
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('file', 'File', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $filename = $this->security->sanitize_filename('file');
            if ($_FILES['file']['size'] > 0) {
                $real_filename = $_FILES['file']['name'];
            //    $file = fopen("assets/docs/tcs_centers.pdf","w");
                $file = fopen("assets/docs/".$courier."_centers.pdf","w");
            //    echo fwrite($file,"Hello World. Testing!");
                fclose($file);
            //    unlink("assets/docs/tcs_centers.pdf");
                unlink("assets/docs/".$courier."_centers.pdf");

                $this->_docUpload($filename, $center_name);
                $insert['real_filename'] = $real_filename;
                $insert['user_id'] = $user_id;
                $insert['date'] = date('Y-m-d H:i:s');
                $insert_id = $this->common_model->insert('tbl_courier_centers_log', $insert);
                $this->session->set_flashdata('success_response', "FILE UPLOADED SUCCESSFULLY ");
            }else{
                $this->session->set_flashdata('success_response', "SOMETHING WENT WRONG ");
            }
        //    redirect(site_url('courier/centers'));
            redirect(site_url('courier/centers/'.$courier));
        }
        $data['title'] = 'Upload';
        $data['role_id'] = $user_role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('courier/centers', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _docUpload($file_name = '', $center_name = '') {
    //    $unique_id = uniqid();
    //    $curr_time = time();
    //    $new_name = $unique_id . '_' . $curr_time;
    //    $config['file_name'] = $new_name;

        $config['file_name'] = $center_name;
        $config['upload_path'] = 'assets/docs';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $document = array('upload_data' => $this->upload->data());
            return $document['upload_data']['file_name'];
        } else {
            //    pre(getcwd());
            //    $errors = $CI->upload->display_errors();
            //    $tempDir = sys_get_temp_dir();
            //    pre($tempDir);
            //    pre($errors,1);
            return false;
        }
    }

}
