<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/third_party/tcpdf/tcpdf.php";

class Pdf extends TCPDF {

    function __construct() {
        parent::__construct();

//    $this->load->view('example_011');
    }

    function Header() {
        // if ($this->page == 1) {
        // Logo
//        <?php echo base_url('assets/layouts/layout/img/logo.png') 
        $image_file = K_PATH_IMAGES . 'logo.png';
        $this->Image($image_file, 5, 5, 28, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 18);
        $this->SetTextColor(3, 61, 106);
        $this->SetXY(25, 15);
        // Title
        $this->Cell(0, 15, 'COVID-19 ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 10);
        $this->SetTextColor(3, 61, 106);
        $this->SetXY('88', 25);

        /* Start Header Line */
        $style = array('width' => 1, 'color' => array(11, 74, 123), 'margin-bottom' => 2);
        $this->Line(0, 40, 220, 40, $style);
        /* End Header Line */
        // Title
        //$this->Cell(45, 5, 'CONTROL PROGRAM', '0', false, 'C', 0, '', 0, false, 'M', 'M');
        //}
    }

    function Footer() {
        $CI = &get_instance();
        // pre($_SESSION,1);
        $full_name = $CI->session->userdata['logged_in']['fullname'];
        // pre($user_id, 1);
//        $this->SetY(-20);
//        $this->SetFont('helvetica', '', 10);
//        $this->SetTextColor(255, 255, 255);
//        $this->SetFillColor(3, 61, 106);
//        $this->Cell(0, 10, $user_id, '', 2, 'C', '1', '', '', '', '', 'M');
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, '', 'T', false, '', 0, '', 0, false, 'T', 'M');
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Created By: ' . $full_name, 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Generated Date: ' . date("d-m-Y", time()), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}
