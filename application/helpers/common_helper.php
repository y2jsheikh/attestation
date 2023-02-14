<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function show_dropdown($table_name, $s_name, $o_name, $o_id = 'id', $selected = 0, $default_select = "", $attr = "", $where = "", $sort_order = "", $group_by = "", $other = '') {
    $output = "";
    $CI = &get_instance();
    $where = ($where != "") ? " WHERE $where" : "";
    $group_by = ($group_by != "") ? " GROUP BY $group_by" : "";
    $sort_order = ($sort_order != "") ? " ORDER BY $sort_order" : "";
    $sql = "SELECT * FROM " . $CI->db->dbprefix . $table_name . " $where $sort_order $group_by";
    $query = $CI->db->query($sql);
    // print $CI->db->last_query();die;
    //pre($selected,1);
    if (substr($s_name, -2) == '[]')
        $s_name_id = substr($s_name, 0, (strlen($s_name) - 2));
    else
        $s_name_id = $s_name;
    //	echo $default_select;die;
    $output .= "<select id=\"$s_name_id\" name=\"$s_name\" $attr >"; //die;
    //$output .= " < option value = '0' > Select</option > ";
    if ($default_select != "")
        $output .= "<option value=\"\">$default_select</option>";
    foreach ($query->result() as $o) {
        if (is_array($selected) && in_array($o->$o_id, $selected)) {
            $output .= "<option selected=\"selected\" value=\"" . $o->$o_id . "\" >" . ucfirst($o->$o_name) . "</option>";
        } else if ($o->$o_id == $selected)
            $output .= "<option selected=\"selected\" value=\"" . $o->$o_id . "\" >" . ucfirst($o->$o_name) . "</option>";
        else
            $output .= "<option value=\"" . $o->$o_id . "\" >" . ucfirst($o->$o_name) . "</option>";
    }
    if ($other != '') {
        $output .= "<option value=\"other\" >" . ($other) . "</option>";
    }
    $output .= '</select>';
    return $output;
}

#end of function

function pre($arr, $e = 0, $msg = '', $isHidden = 0) {
    if ($isHidden) {
        echo "<!--";
    }
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($msg != '') {
        echo $msg;
    }
    if ($e == 1) {
        exit;
    }
    if ($isHidden) {
        echo "-->";
    }
}

function my_date($date, $format = "Y-m-d") {
    return date($format, strtotime($date));
}

function admin_is_logged() {
    if (!isset($_SESSION['AdminId'])) {
        redirect('login');
    }
}

function is_admin_logged() {
    $CI = &get_instance();
    //pre($CI->session->userdata['logged_in']['role_id'],1,'here');
    if (isset($CI->session->userdata['logged_in'])) {
        $usersrole = $CI->session->userdata['logged_in']['role_id'];
        $user_id = $CI->session->userdata['logged_in']['id'];
        $password_reset = getsinglefield('tbl_users','password_reset','WHERE id = "'.$user_id.'"');
        if ($password_reset == 'Y'){
            redirect(base_url('change_password'));
        }else{
            if($usersrole == 1 || $usersrole == 2 || $usersrole == 4 || $usersrole == 6) {
                // Just for testing purpose...for now
                //redirect(base_url('user/edit/'.$user_id));
                redirect(base_url('dashboard'));
            } elseif ($usersrole == 3 || $usersrole == 5){
                redirect(base_url('attestation/user_submitted'));
            } elseif ($usersrole == 7){
                redirect(base_url('dashboard/db_backup_view'));
            }
        }
    }
}

function checkUserAccess($param) {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $session_data = $CI->session->userdata('logged_in');
        //pre($session_data,1);
        $user_role = $session_data['role_id'];
        if (!in_array($user_role, $param)) {
            $CI->session->set_flashdata('response', "ACCESS DENIED");
            redirect(base_url());
        }
    } else {
        redirect('login', 'refresh');
    }
}

function is_admin_logged_v1() {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $session_data = $CI->session->userdata('logged_in');
        $role_id = $session_data['role_id'];
        if ($role_id) {
            $landingPage = getFrontPage($role_id);
            if ($landingPage) {
                redirect(site_url($landingPage->class_name . '/' . $landingPage->method_name));
            } else {
                redirect(site_url('dashboard'));
            }
        } else {
            redirect(site_url());
        }
    }
}

function checkUserAccess_v1($param) {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $role_id = $CI->session->userdata['logged_in']['role_id'];
        $class = $CI->uri->segment(1);
        $method = $CI->uri->segment(2);
        if ($role_id != 1) {
            $permission = hasPermission($role_id, $class, $method);
            if (!$permission) {
                $CI->session->set_flashdata('failure_response', "ACCESS DENIED");
                redirect(site_url('welcome'));
            }
        }
    } else {
        redirect('login', 'refresh');
    }
}

function getFrontPage($role_id) {
    $CI = &get_instance();
    $CI->db->select('tbl_modules`.`class_name`,tbl_modules`.`method_name`');
    $CI->db->from('tbl_role_front_page');
    $CI->db->join('tbl_modules', 'tbl_modules.`id` = `tbl_role_front_page`.`landing_page`');
    $CI->db->where('tbl_role_front_page.`role_id`', $role_id);
    $query = $CI->db->get();
    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return false;
    }
}

function user_menu() {

    $CI = &get_instance();
//    pre($CI->session->userdata,1);
    $session_data = $CI->session->userdata('logged_in');
    $role_id = $session_data['role_id'];
    $CI->db->select('tbl_modules`.`module_name`,tbl_modules`.`id` as module_id, parent_id, `menu_class`');
    $CI->db->from('tbl_modules');

    $CI->db->where('tbl_modules.status', 'Y');
    $CI->db->where('tbl_modules.parent_id', 0);
    if ($role_id != 1) {
        $CI->db->join('tbl_role_mod_maping', 'tbl_modules.`id` = `tbl_role_mod_maping`.`module_id`');
        $CI->db->where('tbl_role_mod_maping.`role_id`', $role_id);
    }

    $CI->db->order_by('tbl_modules.sort', 'ASC');

    $results = $CI->db->get()->result();
    $menu = [];

    if (count($results) > 0) {

        foreach ($results as $link) {
            $j = 0;
            $i = $link->module_name;
            $menu[$i]['menu_class'] = $link->menu_class;
            $menu[$i]['menu_text'] = $link->module_name;

            $CI->db->select('`module_name`,method_name,class_name');
            $CI->db->from('tbl_modules');
            $CI->db->where('tbl_modules.status', 'Y');
            $CI->db->where('`show_in_menu`', 'Y');
            $CI->db->where('tbl_modules.parent_id', $link->module_id);
            $CI->db->order_by('tbl_modules.sort', 'ASC');
            $sublinks = $CI->db->get()->result();
            foreach ($sublinks as $sublink) {
                if (hasPermission($role_id, $sublink->class_name, $sublink->method_name)) {
                    $menu[$i]['sub_menu'][$j]['module'] = $sublink->module_name;
                    $menu[$i]['sub_menu'][$j]['method'] = $sublink->method_name;
                    $menu[$i]['sub_menu'][$j]['class'] = $sublink->class_name;
                    $j++;
                }
            }
        }
    }
    return $menu;
}

function hasPermission($role_id, $class, $method) {
    $CI = &get_instance();
    $total = 0;
    $CI->db->select('COUNT(*) as total');
    $CI->db->from('tbl_modules');
    if ($role_id != 1) {
        $CI->db->join('tbl_role_mod_maping', "tbl_role_mod_maping.module_id = tbl_modules.id");
        $CI->db->where('role_id', $role_id);
    }
    $CI->db->where('method_name', $method);
    $CI->db->where('class_name', $class);
    $total = $CI->db->get()->row()->total;
    if ($total == 0)
        return false;
    else
        return true;
}

function is_session() {
    $CI = &get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('login', 'refresh');
    }
}

function is_logged_username() {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $session_data = $CI->session->userdata('logged_in');
        return $full_name = $session_data['name'];
    }
}

function curlRequest($url = '', $data = '', $username = '', $password = '') {
//echo $data; die;
    if ($url != '') {
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$username:$password")
        );

        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($data != '') {
            $jsonDataEncoded = $data;
            // Option
//            $this->curl->option(CURLOPT_HTTPHEADER, array('Content-type: application/json; Charset=UTF-8'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            // Post - If you do not use post, it will just run a GET request
//            $this->curl->post($jsonDataEncoded);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        }
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $response = curl_exec($ch);
//        pre($response,0);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         pre(CURLINFO_HTTP_CODE,1);
//        curl_close($ch);
        if ($httpCode != 200) {
            return false;
//            curlRequest($url);
        } else {
            return $response;
        }
    }
}

#end of function

function call_curl($url) {
    //  Initiate curl
    $ch = curl_init($url);
    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL, $url);
    // Execute
    $result = curl_exec($ch);
    $return = @json_decode($result);
    // Closing
    curl_close($ch);
}

function is_admin() {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $session_data = $CI->session->userdata('logged_in');
        if ($session_data['role_id'] == 1) {
            return TRUE;
        }
    }
    return FALSE;
}

function sort_links($str_links) {
    $links = explode('&nbsp;', $str_links);
    //pre($links);
    if (count($links) > 0) {
        $html = '<ul class="pagination m-0" style="visibility: visible;">';
        foreach ($links as $link) {
            $html .= "<li class='page-item'>" . $link . "</li>";
        }
        $html .= "</ul>";
    }
    return $html;
}

function humanTiming($time) {
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}

function getsinglefield($tbl, $field, $where = '') {
    $CI = &get_instance();
    $result = $CI->db->query("SELECT $field FROM " . $CI->db->dbprefix . $tbl . " $where");
    if ($result->num_rows() > 0) {
        $result = $result->row();
        return $result->$field;
    } else {
        return false;
    }
}

function get_role($default = 0, $whr = '', $name = 'role_id', $attr = 'required', $placeholder = 'Select Role') {
    $where = "id !='1' ";
    if (!empty($whr))
        $where .= $whr;
    $html = show_dropdown('tbl_roles', $name, 'role_name', 'id', $default, $placeholder, "class='select2 form-control input-paf' style='width:100%' $attr ", $where, " role_name");
    return $html;
}

function get_modules($default = 0, $where = '', $name = 'modules', $multiple = '', $required = '') {
    $html = show_dropdown('tbl_modules', $name, 'module_name', 'id', $default, "Select Module", "class='select2 form-control' $multiple $required", $where, " module_name");
    return $html;
}

function get_sub_modules($default = 0, $where = '', $name = 'sub_module', $multiple = '') {
    $html = show_dropdown('tbl_sub_modules', $name, 'sub_module_name', 'id', $default, "Select Sub Module", "class='select2 form-control' $multiple", $where, " sub_module_name");
    return $html;
}

function get_users($name, $where = '') {
    $where .= " AND status = 'active' AND id!='1'";
    //echo $where;die;
    $html = show_dropdown('tbl_users', $name . '[]', 'fullname', 'id', '', "", "class='select2 form-control' multiple", $where, " fullname");
    return $html;
}

function get_user($default = 0, $whr = '', $name = 'user_id', $attr = 'required', $placeholder = 'Select') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_users', $name, 'fullname', 'id', $default, $placeholder, 'class="form-control input-paf" '.$attr.'', $where);
    return $html;
}

function get_province($default = 0, $whr = '', $name = 'province_id', $attr = 'required', $placeholder = 'Select Province') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_province', $name, 'name', 'id', $default, $placeholder, 'class="form-control open_field select2" '.$attr.'', $where);
    return $html;
}

function get_district_dropdown($default = 0, $where = '', $name = 'districts', $required = 'yes', $multiple = '') {
    if ($required == 'yes') {
        $required = 'required';
    } else {
        $required = '';
    }
    $html = show_dropdown('tbl_district', $name, 'district_name', 'id', $default, "Select District", "class='form-control select2 district' $required $multiple", $where, 'district_name');
    return $html;
}

function get_tehsil_dropdown($default = 0, $where = '', $name = 'tehsil', $required = 'yes', $multiple = '') {
    if ($required == 'yes') {
        $required = 'required';
    } else {
        $required = '';
    }
    $html = show_dropdown('tbl_tehsil', $name, 'name', 'id', $default, "Select Tehsil", "class='form-control select2 tehsil' $required $multiple", $where, 'name');
    return $html;
}

function get_uc_dropdown($default = 0, $where = '', $name = 'uc') {
    $html = show_dropdown('tbl_uc', $name, 'uc_name', 'id', $default, "Select UC", "class='form-control select2'", $where, 'uc_name');
    return $html;
}

function get_country($default = '', $whr = '', $name = 'country', $attr = 'required', $placeholder = 'Select Country') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_country', $name, 'name', 'name', $default, $placeholder, 'class="form-control input-paf open_field select2" '.$attr.'', $where);
    return $html;
}

function get_gender($default = 0, $where = '', $name = 'gender') {
    $html = show_dropdown('tbl_gender', $name, 'name', 'id', $default, "Select Gender", "class='select2 form-control input-paf' required ", $where);
    return $html;
}

function get_marital_status($default = 0, $whr = '', $name = 'marital_status', $attr = 'required', $placeholder = 'Select') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_marital_status', $name, 'name', 'id', $default, $placeholder, "class='form-control input-paf' $attr", $where);
    return $html;
}

function get_occupation($default = 0, $whr = '', $name = 'occupation_id', $attr = 'required', $placeholder = 'Select') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_occupation', $name, 'name', 'id', $default, $placeholder, "class='form-control input-paf' $attr", $where);
    return $html;
}

function get_qualification($default = 0, $whr = '', $name = 'qualification_id', $attr = 'required', $placeholder = 'Select') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_qualification', $name, 'name', 'id', $default, $placeholder, 'class="form-control input-paf qualification-class" '.$attr.'', $where);
    return $html;
}

function get_time_slot($default = 0, $whr = '', $name = 'slot_id', $attr = 'required', $placeholder = 'Select') {
    $where = "slot IS NOT NULL";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_time_slot', $name, 'slot', 'id', $default, $placeholder, 'class="form-control input-paf" '.$attr.'', $where);
    return $html;
}

function get_signatory($default = 0, $whr = '', $name = 'signatory_id', $attr = 'required', $placeholder = 'Select') {
    $where = "status = 'Y'";
    if ($whr != ''){
        $where .= " AND ".$whr;
    }
    $html = show_dropdown('tbl_signatory', $name, 'name', 'id', $default, $placeholder, "class='form-control input-paf select2' $attr", $where);
    return $html;
}

function dbDateFormat($date) {
    if (isset($date) && $date != NULL) {
        $date = date('m/d/Y', strtotime($date));
    }
    return $date;
}

function check_user_role() {
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in')) {
        $session_data = $CI->session->userdata('logged_in');
        return $session_data['role_id'];
    }
    return FALSE;
}

function log_api($data = '', $method = '', $res = '', $s = '', $e = '') {
    $CI = &get_instance();
    $insert = [];
    $insert['data'] = $data;
    $insert['response'] = $res;
    $insert['method'] = $method;
    $insert['start_time'] = $s;
    $insert['end_time'] = $e;
    $insert['created'] = time();
    $CI->common_model->insert('tbl_api_log', $insert);
}

function common_send_email($to = '', $subject = '', $html = '', $from_email = 'noreply@nhsrc.gov.pk', $from_name = 'MONHSRC', $attachments = array()) {
//    pre($from_name,1);
//	return true;
    $CI = &get_instance();
    if($html != ''){
        $html .= '<br/><br/>Note: This is a system Generated email and cannot be replied at. For any queries, Please Contact 0519245692 or Email at attestation@nhsrc.gov.pk';
    }
    $user_id = isset($CI->session->userdata['logged_in']['id']) ? $CI->session->userdata['logged_in']['id'] : 0;
    $send_email = $CI->config->item('send_email');
    if ($send_email == TRUE) {
        if (!empty($to)) {
            $to = trim($to);
            $send_status = "sent";
            $CI = &get_instance();
            $CI->load->library('email');
            $CI->email->from($from_email, $from_name);
            $CI->email->to($to);
            $CI->email->subject($subject);
            $CI->email->message($html);

            if (!empty($attachments)) {
                $attachments= $_SERVER["DOCUMENT_ROOT"]."/uploads/".$attachments;
                $CI->email->attach($attachments);
               // $CI->email->attach(base_url().'/uploads/'.$attachments);
                if ($CI->email->send()) {
                    if (delete_files($attachments)) {
                        $send_status = "sent";
                    }
                } else {
                    if (delete_files($attachments)) {
                        $send_status = "not_sent";
                    //    pre($CI->email->print_debugger(), 1);
                    //    redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else {
                if (!$CI->email->send()) {
                    $send_status = "not_sent";
                    pre($CI->email->print_debugger(), 1);
                //    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            /*
            if (!$CI->email->send()) {
                $send_status = "not_sent";
                pre($CI->email->print_debugger(), 1);
            }
            */
            $CI->common_model->email_log($subject, $html, $from_email, $to, $user_id, $send_status);
            //pre($CI->email,1);
        }
    }
}

function getventilatorsApi($hopital_id) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://ventilator.punjab.gov.pk/api/stats/" . $hopital_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic Y292aWQtdXNlcjpQIXRiITIzNCU=",
            "Cookie: ci_session=f3362f975345b974a963ed454e1c83b7719c7b96"
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function pdf_generater($html = '') {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    $CI = &get_instance();

    $CI->load->library('pdf');
    $CI->pdf->SetSubject('PHCP PMIS');
    $CI->pdf->SetKeywords('PHCP, PHCP PMIS');
    $CI->pdf->SetAuthor('PHCP PMIS');
    // set font
    $CI->pdf->SetFont('times', 'BI', 16);
    // add a page
    $CI->pdf->AddPage();
    // pre($row,1);
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // set auto page breaks
//    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->SetPrintFooter(false);
    $pdf->SetPrintHeader(false);
    $pdf->SetTitle('Receipt');
    // ---------------------------------------------------------
    //pre('here ',1);
    // set font
    $pdf->SetFont('helvetica', '', 9);
    // add a page

    $pdf->AddPage('P', 'A4'); //P
    /* Start Header Line */
    $style = array('width' => 1, 'color' => array(11, 74, 123));
    //$pdf->Line(0, 40, 220, 40, $style);
    /* End Header Line */
    $pdf->Ln(6);
    /* Start First Table */
    // create some HTML content
    $pdf->SetFont('helvetica', '', 10, '', true);
    $pdf->SetFillColor(79, 90, 103);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->setCellPaddings(2, 2, 2, 2);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 9);
    //pre($CI->input->post(),1);
    //$html = $CI->input->post('table_data');

    //echo $html; die;
    $pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, false, true, 'L', true);

    $pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
// ---------------------------------------------------------
//Close and output PDF document
    $file_name = ($CI->input->post('file_name', true) != '' ? $CI->input->post('file_name', true) : 'pdf-report') . '.pdf';
    //pre($file_name ,1);
    $pdf->Output($file_name, 'I');
}

function word_generater($html = '') {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    $CI = &get_instance();

    $CI->load->library('doc');
    $CI->doc->setDocFileName('Ministry');
    $CI->doc->setTitle('Ministry of Health Document');
    $CI->doc->getHeader();
    $CI->doc->getFotter();
    header('Content-Type: image/jpeg');
    $doc = new Html_to_doc();
//    echo $html; die;
//    $doc->createDoc($html, "document");
    $doc->createDoc($html, "ministry_document", 1);
}

function byte_to_image($data = '', $path = 'uploads') {
    if ($data != '') {
        $file_name = time() . '_' . rand() . '.png';
        $file_path = $path . '/' . $file_name;
        file_put_contents($file_path, base64_decode($data));
    } else {
        $file_name = '';
    }
    return $file_name;
}

function table_exist($table_name){
    $CI = &get_instance();
    $query = "SELECT COUNT(*) as count FROM information_schema.TABLES WHERE TABLE_NAME = '" . $table_name . "'";
    $result = $CI->db->query($query);
    $result = $result->row();
    if (is_object($result)) {
        return $result->count;
    } else {
        return false;
    }
}

function file_upload($file_name = '', $path = '') {
    $CI = &get_instance();
    $unique_id = uniqid();
    $curr_time = time();
    $new_name = $unique_id . '_' . $curr_time;
    $config['file_name'] = $new_name;
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpg|png|jpeg|pdf';
    $CI->load->library('upload', $config);
    if ($CI->upload->do_upload($file_name)) {
        $document = array('upload_data' => $CI->upload->data());
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

function get_application_documents($attest_id) {
    $CI = &get_instance();
    $result = $CI->db->query("SELECT qualification, doc_type FROM tbl_user_attestation_document WHERE user_attestation_id = '".$attest_id."'");
    if ($result->num_rows() > 0) {
        $result = $result->result();
        return $result;
    } else {
        return false;
    }
}

function barcode( $filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ) {
    $code_string = "";
    // Translate the $text into barcode the correct $code_type
    if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code128a" ) {
        $chksum = 103;
        $text = strtoupper($text); // Code 128A doesn't support lower case
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211412" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code39" ) {
        $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
        }

        $code_string = "1211212111" . $code_string . "121121211";
    } elseif ( strtolower($code_type) == "code25" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
        $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

        for ( $X = 1; $X <= strlen($text); $X++ ) {
            for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
                if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
                    $temp[$X] = $code_array2[$Y];
            }
        }

        for ( $X=1; $X<=strlen($text); $X+=2 ) {
            if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
                $temp1 = explode( "-", $temp[$X] );
                $temp2 = explode( "-", $temp[($X + 1)] );
                for ( $Y = 0; $Y < count($temp1); $Y++ )
                    $code_string .= $temp1[$Y] . $temp2[$Y];
            }
        }

        $code_string = "1111" . $code_string . "311";
    } elseif ( strtolower($code_type) == "codabar" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
        $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
                if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
                    $code_string .= $code_array2[$Y] . "1";
            }
        }
        $code_string = "11221211" . $code_string . "1122121";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    if ($print) {
        $text_height = 30;
    } else {
        $text_height = 0;
    }

    for ( $i=1; $i <= strlen($code_string); $i++ ){
        $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
    }

    if ( strtolower($orientation) == "horizontal" ) {
        $img_width = $code_length*$SizeFactor;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length*$SizeFactor;
    }

    $image = imagecreate($img_width, $img_height + $text_height);
    $black = imagecolorallocate ($image, 0, 0, 0);
    $white = imagecolorallocate ($image, 255, 255, 255);

    imagefill( $image, 0, 0, $white );
    if ( $print ) {
        imagestring($image, 5, 31, $img_height, $text, $black );
    }

    $location = 10;
    for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
        $cur_size = $location + ( substr($code_string, ($position-1), 1) );
        if ( strtolower($orientation) == "horizontal" )
            imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
        else
            imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
        $location = $cur_size;
    }

    // Draw barcode to the screen or save in a file
    if ( $filepath=="" ) {
        header ('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    } else {
        imagepng($image,$filepath);
        imagedestroy($image);
    }
}
