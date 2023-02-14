<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $data = [];
        $data['title'] = 'Welcome to CCMS';
        $data['role_id'] = $this->session->userdata['logged_in']['role_id'];
        $data['content'] = $this->load->view('welcome', $data, TRUE);
        $this->load->view('template', $data);
    }
}
