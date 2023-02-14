<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class common_model extends CI_Model{
    /* ------------------constructor goes here-------------- */

    function __construct(){
        parent::__construct();
    }

#End of function

    function update($tblname, $data, $where){
        $this->db->update($tblname, $data, $where);
        //echo $this->db->last_query();
        //echo '<pre>';print_r($data);
        //die;
        return true;
    }

#End of function

    function insert($tblname, $data){
        $this->db->insert($tblname, $data);
        //echo $this->db->last_query();
        //print_r($data);
        //die;
        return $this->db->insert_id();
    }

#End of function

    function getwhere($tbl, $fld, $val){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($fld, $val);
        $result = $this->db->get();

        return $result->result_array();
    }

    function getwherenew($tbl, $fld, $val){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($fld, $val);
        $result = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result;
    }

#End of function

    function counttotal($tbl, $where = ''){
        if ($where != '')
            $sql = "SELECT * FROM " . $this->db->dbprefix . $tbl . " WHERE " . $where . " ";
        else
            $sql = "SELECT * FROM " . $this->db->dbprefix . $tbl . " ";
        $result = $this->SqlExec($sql);
        if ($result->num_rows())
            return $result->num_rows();
        else
            return 0;
    }

#End of function

    function SqlExec($sql){
        return $this->db->query($sql);
    }

    function GetDetail($tbl, $where = ''){
        if ($where != '')
            $sql = "SELECT * FROM " . $this->db->dbprefix . $tbl . " WHERE " . $where . " ";
        else
            $sql = "SELECT * FROM " . $this->db->dbprefix . $tbl . " ";
        $result = $this->SqlExec($sql);
        return $result;
    }

    function delete($table, $where){
        //echo $this->db->last_query();
        //die;
        $this->db->delete($table, $where);
    }

    function truncate($table){
        $this->db->truncate($table);
    }

    function get_contents($tbl)
    {
        //$cplt_date = date("d-m-Y", time());
        $this->db->select('*');
        $this->db->from($tbl);
        //$this->db->join('patients_info_s1', 'patients_info_s1.id = scheduled_appointments.pid');
        $this->db->where('type', 'user');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $results = $query->result();
    }

    function get_last_exectime(){
        $this->db->select('to');
        $this->db->from('tbl_cron_backup_config');
        $this->db->limit(1);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->row();
        if ($result == NULL) {
            return strtotime("1 January 2018");
        } else {
            return $result->to;
        }
    }

    function GetDataRow($tbl = '', $field = '', $where = '', $group_by = '', $order_by = '', $limit = ''){
        // echo"here";
        $this->db->select($field);
        $this->db->from($tbl);
        if ($where != '') {
            $this->db->where($where);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }
        if ($order_by != '') {
            $this->db->order_by($order_by);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $results = $query->row();
    }

    function GetDataByFields($tbl, $field = '*', $where = '', $return_type = 'array', $order_by = 'ASC', $limit = ''){
        if ($limit != '')
            $limit = 'Limit ' . $limit;
        if ($where != '')
            $sql = "SELECT " . $field . " FROM " . $this->db->dbprefix . $tbl . " WHERE " . $where . " ORDER BY $tbl.id $order_by $limit";
        else
            $sql = "SELECT " . $field . " FROM " . $this->db->dbprefix . $tbl . " ORDER BY $tbl.id $order_by $limit";

        //echo $sql;

        $result = $this->SqlExec($sql);
        if ($return_type == 'object') {
            $results = $result->result();
        } elseif ($return_type == 'row') {
            $results = $result->row();
        } else {
            $results = $result->result_array();
        }

        return $results;
    }

    function getLMS($gender, $height, $tbl){
        $this->db->select("L,M,S");
        $this->db->where("height", $height);
        $this->db->where("gender", $gender);
        $this->db->from($tbl);
        $result = $this->db->get();
//		print $this->db->last_query();die;
        $results = $result->row();

        return $results;
    }

    function GetAllUnProcessedSQLFiles(){
        $this->db->select("*");
        $this->db->from("tbl_cron_sql_files");
        $this->db->where("is_processed", "N");
        $this->db->order_by("id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    function CheckRecord($tbl, $f_id){
        $this->db->select("*");
        $this->db->from($tbl);
        $this->db->where("filename", $f_id);
        return $this->db->count_all_results();
    }

    function validate_cnic($cnic, $u_id){
//        $this->load->database();
        //pre($u_id,1);
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('cnic', $cnic);
        $this->db->where('id!=', $u_id);
        $this->db->where('cnic_status ', 'Self');
        //$this->db->limit(1);
        $query = $this->db->get();
        //    echo $this->db->last_query();die;
        if ($query->num_rows() == 0) {
//            $this->db->close();
            return true;
        } else {
//            $this->db->close();
            return false;
        }
    }

    function file_upload($file_name = '', $path = '', $extra = ''){
        $unique_id = uniqid();
        $new_name = $unique_id;
        $config = [];
        $config['file_name'] = $new_name;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
        $this->load->library('upload', $config);
        unset($this->upload->upload_path);
        $this->upload->upload_path = $path;
        if ($this->upload->do_upload($file_name)) {
            $document = array('upload_data' => $this->upload->data());
            return $document['upload_data']['file_name'];
        } else {
            $this->session->set_userdata('response_error', $this->upload->display_errors());
            return false;
        }
    }

    function app_status_log($attest_id = '', $app_number = '', $cn_number = '', $status = '', $current_status = '', $user_id = '', $courier_role_id = '', $courier_role = '', $source = ''){
        $data['attest_id'] = $attest_id;
        $data['app_number'] = $app_number;
        ////////////////////////////////////////////////
        /// Role Information
        if ($courier_role_id > 0) {
            $data['courier_role_id'] = $courier_role_id;
            $data['courier_role'] = $courier_role;
        }
        ////////////////////////////////////////////////
        if ($cn_number != '') {
            $data['cn_number'] = $cn_number;
        }
        if ($status != '') {
            $data['status'] = $status;
        }
        if ($current_status != '') {
            $data['current_status'] = $current_status;
        }
        if ($source != '') {
            $data['source'] = $source;
        }
        $data['user_id'] = $user_id;
        $data['date'] = date('Y-m-d H:i:s');
        $log_id = $this->common_model->insert('tbl_app_status_log', $data);
        return $log_id;
    }

    function statement_status_log($statement_id = '', $app_number = '', $status = '', $current_status = '', $user_id = ''){
        $data['statement_id'] = $statement_id;
        $data['app_number'] = $app_number;
        if ($status != '') {
            $data['status'] = $status;
        }
        if ($current_status != '') {
            $data['current_status'] = $current_status;
        }
        $data['user_id'] = $user_id;
        $data['date'] = date('Y-m-d H:i:s');
        $log_id = $this->common_model->insert('tbl_user_statement_log', $data);
        return $log_id;
    }

    function app_status_email($user_id = '', $full_name = "", $to = '', $app_no = '', $user_cnic = '', $cn_number = '', $status = '', $email_template = ''){
        $this->load->library('email'); //load email library
        $EmailTemp = $this->common_model->getwherenew('email_template', 'templatename', $email_template); //load email tempelate
        $EmailTemp = $EmailTemp->row();
        $subject = 'Application Status';  //load subject
        $message = $EmailTemp->template;
        $find = array("{fullname}", "{email}", "{app_no}", "{courier_name}", "{user_cnic}", "{cn_number}", "{status}");
        $replace = array($full_name, $to, $app_no, 'TCS', $user_cnic, $cn_number, $status);
        $message = str_replace($find, $replace, $message);
        $message = "".$message."";
        $From = "noreply@ppwnap.gov.pk";
        $From = "noreply@nhsrc.gov.pk";
    //    $From = "";
        $FromName = $full_name;
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            common_send_email($to, $subject, $message, $From, $FromName);
        }
        $this->session->set_flashdata('success_response', 'Email has been sent!');
    //    redirect($_SERVER['HTTP_REFERER']);
    }

    function resend_email($email_log_id, $to, $subject, $message, $from, $from_name){
        $this->load->library('email');
        $user_id = isset($this->session->userdata['logged_in']['id']) ? $this->session->userdata['logged_in']['id'] : 0;
        $send_email = $this->config->item('send_email');
        /*
        $updateLog['send_status'] = "sent";
        $updateWhr['id'] = $email_log_id;
        $this->common_model->update('tbl_email_log', $updateLog, $updateWhr);
        return 'sent';
        */
        if ($send_email == TRUE) {
            if (!empty($to)) {
                $to = trim($to);
                $send_status = "sent";
                $this->load->library('email');
                $this->email->from($from, $from_name);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                if (!$this->email->send()) {
                    $send_status = "not_sent";
                    pre($this->email->print_debugger(), 1);
                }
                $updateLog['send_status'] = $send_status;
                $updateWhr['id'] = $email_log_id;
                $this->common_model->update('tbl_email_log', $updateLog, $updateWhr);
            }
        }
        return $send_status;
    }

    function email_log($subject, $message, $from, $to, $user_id, $send_status){
        $time = time();
        $insert['subject'] = $subject;
        $insert['message'] = $message;
        $insert['from'] = $from;
        $insert['to'] = $to;
        $insert['datetime'] = date('Y-m-d H:i:s', $time);
        $insert['send_status'] = $send_status;
        $insert['created'] = $time;
        $insert['created_by'] = $user_id;
        $this->db->insert('tbl_email_log', $insert);
        return $this->db->insert_id();
    }

}

#End of class