<?php

/**
 * @package TransactionLogger
 * @author Ali Cheema <ali.nawaz@pitb.gov.pk>
 * @version V1.0
 * This is hook to save transaction logs
 * It enables you to save your required transaction logs 
 */
class TransactionLogger {

    private $ci;

    /**
     * @method initialize
     * Set ci instance 
     * loader library
     * call save transaction function     
     */
    function initialize() {
        $this->ci = & get_instance();
        $this->ci->load->library('logger');
        $this->save_transaction_log();
    }

    /**
     * @method save_transaction_log
     * You just need to set followings
     * 1. Transaction data if any
     * 2. User details as per your requirements
     * 3. custom_message if any     
     *  
     */
    function save_transaction_log() {
        if ($this->ci->uri->segment(2) != 'append_csrf') {
            $jsonArray = $_REQUEST;
            if (isset($_REQUEST['password']) && $_REQUEST['password'] != '') {
                $password = $_REQUEST['password'];
                $jsonArray['password'] = base64_encode($password);
            }
            if (isset($_REQUEST['confirm_password']) && $_REQUEST['confirm_password'] != '') {
                $confirm_password = $_REQUEST['confirm_password'];
                $jsonArray['confirm_password'] = base64_encode($confirm_password);
            }
            if (isset($_REQUEST['old_password']) && $_REQUEST['old_password'] != '') {
                $old_password = $_REQUEST['old_password'];
                $jsonArray['old_password'] = base64_encode($old_password);
            }
            if (isset($_REQUEST['new_password']) && $_REQUEST['new_password'] != '') {
                $new_password = $_REQUEST['new_password'];
                $jsonArray['new_password'] = base64_encode($new_password);
            }
            $transaction_details = array(
            //    'transaction_data' => json_encode($_REQUEST),
                'transaction_data' => json_encode($jsonArray),
                'user_details' => json_encode($this->ci->session->userdata()),
                'custom_message' => ''
            );
            $this->ci->logger->log_transaction($transaction_details);
        }
    }

}
