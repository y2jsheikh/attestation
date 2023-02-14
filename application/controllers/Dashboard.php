<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("dashboard_model");
        $this->load->model("user_model");
        $this->load->model("qualification_model");
    }

    function index()
    {
        $roles = array(1, 2, 3, 4, 5, 6);
        checkUserAccess($roles);

        $data = array();
        $data['title'] = 'Dashboard';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $occupation_id = $this->session->userdata['logged_in']['occupation_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $user_fullname = $this->session->userdata['logged_in']['fullname'];
        $search_param = array();

        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $view = '';
        if ($role_id == 1 || $role_id == 4 || $role_id == 6) {
            //    $data['users_count'] = $this->common_model->counttotal('tbl_users','status = "Y" AND role_id = 2');
            $data['users_count'] = $this->common_model->counttotal('tbl_users', 'role_id = "2"');
            $data['total_application_count'] = $this->common_model->counttotal('tbl_user_attestation');

            $data['total_tcs_application_count'] = $this->common_model->counttotal('tbl_user_attestation', 'source = "courier" AND courier_receive_role = "3"');
            $data['total_mnp_application_count'] = $this->common_model->counttotal('tbl_user_attestation', 'source = "courier" AND courier_receive_role = "5"');
            $data['total_self_application_count'] = $this->common_model->counttotal('tbl_user_attestation', 'source = "self"');

            //        $data['courier_not_submitted_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'user_submitted', 'courier');
            $data['tcs_not_submitted_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'user_submitted', 'courier', '3');
            $data['mnp_not_submitted_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'user_submitted', 'courier', '5');
            $data['self_not_submitted_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'user_submitted', 'self');

            $data['tcs_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'courier_received', 'courier', '3');
            $data['mnp_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'courier_received', 'courier', '5');
            $data['self_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'courier_received', 'self');

            $data['ministry_to_be_dispatched_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'ministry_received');
            $data['tcs_to_be_collected_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'ministry_received', 'courier', '3');
            $data['mnp_to_be_collected_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'ministry_received', 'courier', '5');
            //    $data['ministry_dispatched_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'ministry_dispatched');

            $data['tcs_returned_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'courier_dispatched', 'courier', '3');
            $data['mnp_returned_application_count'] = $this->dashboard_model->get_application_count($search_param, '', 'courier_dispatched', 'courier', '5');

            $data['pending_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'ministry_received');
            $data['not_received_application_count'] = $this->dashboard_model->get_application_count($search_param, 'pending', 'courier_received');
            $data['in_process_application_count'] = $this->dashboard_model->get_application_count($search_param);

            $data['tcs_received_until_returned_count'] = $this->dashboard_model->get_courier_received_until_returned_count($search_param, '3');
            $data['mnp_received_until_returned_count'] = $this->dashboard_model->get_courier_received_until_returned_count($search_param, '5');

            $data['pending_document_count'] = $this->dashboard_model->get_application_document_count($search_param, 'pending', 'ministry_received');
            $data['attested_document_count'] = $this->dashboard_model->get_application_document_count($search_param, 'accepted');
            $data['rejected_document_count'] = $this->dashboard_model->get_application_document_count($search_param, 'rejected');
            $occupation_users_data = $this->dashboard_model->get_occupation_count($search_param);
            $data['occupation_users_data'] = $this->_occupation_user_graph_data($occupation_users_data);
            //    pre($data['occupation_users_data'],1);
            /*
            if ($role_id == 6){
                $view = 'view_dashboard';
            }else {
                $view = 'dashboard';
            }
            */
            $view = 'dashboard';

        } elseif ($role_id == 3 || $role_id == 5) {
            $view = 'courier_dashboard';
        } else {
            $data['result'] = $this->user_model->get_all_details($user_id);
            $data['is_edu'] = $this->common_model->counttotal('tbl_user_qualification', 'user_id = "' . $user_id . '"');
            $view = 'user_dashboard';
        }
        // pre($data,1);
        $data['role_id'] = $role_id;
        $data['occupation_id'] = $occupation_id;
        $data['user_fullname'] = $user_fullname;
        $data['content'] = $this->load->view($view, $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _occupation_user_graph_data($data)
    {
        $html = "";
        if (!empty($data) && count($data) > 0) {
            foreach ($data as $rec) {
                $html .= "['" . $rec->occupation . "', " . $rec->count . "],";
            }
            $html = rtrim($html, ',');
        }
        return $html;
    }

    function _occupation_user_graph_data_________Older_________($data)
    {
        $html = "";
        if (!empty($data) && count($data) > 0) {
            foreach ($data as $rec) {
                $html .= "{name: '" . $rec->occupation . "', data: [" . $rec->count . "]},";
            }
            $html = rtrim($html, ',');
        }
        return $html;
    }

    function xoxo()
    {
        $data = [];
        $roles = [1];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->load->helper('file');
        $user_role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $this->form_validation->set_error_delimiters('<div style="color:#F00;">', '</div>');
        $this->form_validation->set_rules('file', 'File', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $filename = $this->security->sanitize_filename('file');
            if ($_FILES['file']['size'] > 0) {
                $real_filename = $_FILES['file']['name'];
                $file = fopen("assets/docs/queries.txt", "w");
                fclose($file);
                unlink("assets/docs/queries.txt");
                $uploadedFile = $this->_fileUpload($filename);
                //    readfile(base_url('assets/docs/'.$uploadedFile));
                //    $res = fopen($uploadedFile, 'r');
                //    $MyFile = file_get_contents(base_url()."assets/docs/".$uploadedFile);

                $file = fopen("assets/docs/" . $uploadedFile, "r");
                $MyFile = fread($file, filesize("assets/docs/" . $uploadedFile));
                var_dump($MyFile);


                $file = fopen("assets/docs/" . $uploadedFile, 'r') or die($php_errormsg);
                $people = fread($file, filesize("assets/docs/" . $uploadedFile));
                if (preg_match('/Names:.*(David|Susannah)/i', $people)) {
                    print "people.txt matches.";
                }
                fclose($file) or die($php_errormsg);


                die('File Uploaded Successfully...');
            } else {
                die('No file Uploaded...');
            }
        }
        $data['title'] = 'Upload';
        $data['role_id'] = $user_role_id;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['content'] = $this->load->view('report/queries', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function _fileUpload($file_name = '')
    {
        $config['file_name'] = 'queries';
        $config['upload_path'] = 'assets/docs';
        $config['allowed_types'] = 'txt';
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

    function db_backup_view()
    {
        $roles = array(1, 7);
        checkUserAccess($roles);

        $data = array();
        $data['title'] = 'Dashboard';
        $role_id = $this->session->userdata['logged_in']['role_id'];
        $user_id = $this->session->userdata['logged_in']['id'];
        $user_fullname = $this->session->userdata['logged_in']['fullname'];

        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['role_id'] = $role_id;
        $data['user_fullname'] = $user_fullname;
        $data['content'] = $this->load->view('backup', $data, true); //true for return
        $this->load->view('template_2', $data);
    }

    function backup(){
        $this->db_backup();
        $this->_uploads_backup();
    }

    function db_backup(){
        date_default_timezone_set('GMT');
        // Load the file helper in codeigniter
        $this->load->helper('file');
        $this->load->helper('download');
	ini_set("memory_limit", "-1");
        $con = mysqli_connect("localhost", "user_das", "Nne@U2uJlmV3x7v9", "attestation");
        $tables = array();
        $query = mysqli_query($con, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($query)) {
            $tables[] = $row[0];
        }

        $result = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";';
        $result .= 'SET time_zone = "+00:00";';

        foreach ($tables as $table) {
            $query = mysqli_query($con, 'SELECT * FROM `' . $table . '`');
            $num_fields = mysqli_num_fields($query);

            $result .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE `' . $table . '`'));
            $result .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($query)) {
                    $result .= 'INSERT INTO `' . $table . '` VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $result .= '"' . $row[$j] . '"';
                        } else {
                            $result .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $result .= ',';
                        }
                    }
                    $result .= ");\n";
                }
            }
            $result .= "\n\n";
        }

        //Create Folder
        $folder = 'database/';
/*
        if (!is_dir($folder))
            mkdir($folder, 0777, true);
        chmod($folder, 0777);
*/

        $date = date('m-d-Y');
        $filename = $folder . "db_attestation_" . $date;
        $handle = fopen($filename . '.sql', 'w+');
        fwrite($handle, $result);
        fclose($handle);

        $this->_uploads_backup();

        $file_url = $filename . '.sql';
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);

        return;

    //    redirect('dashboard/db_backup_view');
    //    redirect('dashboard/uploads_backup');
        // end Export_Database function
    }

    function _uploads_backup(){
        $this->load->library('zip');
        $date = date('m-d-Y');
    //    $path = FCPATH.'/assets/images';
    //    $path = FCPATH.'/uploads';
        $path = FCPATH;
        $this->zip->read_dir($path,FALSE);
        $this->zip->download('backup_'.$date.'.zip');
    //    redirect('dashboard/db_backup_view');
        return;
    }

}
