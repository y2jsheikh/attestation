<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('roles_model');
    }

    function index()
    {
        $data = [];
        $roles = [1];
        checkUserAccess($roles);
        $data['title'] = 'List Of Roles';
        $data['content'] = $this->load->view('roles/view', $data, TRUE);
        $this->load->view('template', $data);
    }

    function add()
    {
        $data = array();
        $roles = array(1);
        checkUserAccess($roles);
        $user_id = $this->session->userdata['logged_in']['id'];
        $data['title'] = 'Roles';
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|is_unique[tbl_roles.role_name]');

        if ($this->form_validation->run() == TRUE) {
            $insert['role_name'] = $this->input->post('role_name', TRUE);
            $insert['created'] = time();
            $this->common_model->insert("tbl_roles", $insert);
            $this->session->set_flashdata('success_response', "ROLE SAVED SUCCESSFULLY ");
            redirect(site_url('Roles'));
        }
        $data['content'] = $this->load->view('roles/add', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function edit($id)
    {
        $data = [];
        $roles = ['1'];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|callback__ValidateRole');
        if ($this->form_validation->run() == TRUE) {
            $update['role_name'] = $this->input->post('role_name', TRUE);
            $update['status'] = $this->input->post('status', TRUE);
            $update['updated'] = strtotime(date("Y-m-d H:i:s", time()));
            //pre($update,1);
            $this->common_model->update('tbl_roles', $update, 'id = ' . $id);
            $this->session->set_flashdata('success_response', "DATA UPDATED SUCCESSFULLY ");
            redirect(site_url('Roles'));
        }
        $data['result'] = $this->roles_model->get_all_details($id);
        $data['title'] = 'Update Role';
        $data['role_id'] = $id;
        $data['content'] = $this->load->view('roles/edit', $data, true); //true for return
        $this->load->view('template', $data);
    }

    function delete($id)
    {
        if ($id != 1) {
            $this->common_model->delete("tbl_roles", array('id' => $id));
            $this->session->set_flashdata('success_response', "ROLE DELETED SUCCESSFULLY.");
        } else {
            $this->session->set_flashdata('failure_response', "You cannot delete Super Admin!");
        }
        redirect(site_url('Roles'));
    }

    function _ValidateRole()
    {
        $role_name = $this->input->post('role_name', TRUE);
        $id = $this->input->post('role_id', TRUE);
        $result = $this->roles_model->unique_check($role_name, $id);
        if ($result) {
            $this->form_validation->set_message('_ValidateRole', 'Role Name Already Exits');
            return false;
        } else {
            return TRUE;
        }
    }

    function content($page = 0)
    {
        $this->load->library('pagination');
        $action = $this->input->post('action');
        $output = array();
        switch ($action) {
            case 'roles_content':
                $keyword = $this->input->post('search_text', TRUE);
                $limit = $this->input->post('select_limit', TRUE);
                $count = $this->roles_model->total_count($keyword);
                //    pre($this->db->last_query(),1);
                $config = array(
                    'base_url' => base_url("Roles/content"),
                    'total_rows' => $count,
                    'use_page_numbers' => TRUE,
                    'first_link' => "First Page",
                    'last_link' => "Last Page",
                    'per_page' => $limit != '' ? $limit : $count,
                    'uri_segment' => 3,
                    'cur_tag_open' => "<a class='current'>",
                    'prev_link' => "Previous Page",
                    'next_link' => "Next Page",
                );
                if ($this->uri->segment(3)) {
                    $page = ($this->uri->segment(3)) * $config["per_page"] - $config["per_page"];
                } else {
                    $page = 0;
                }
                $this->pagination->initialize($config);
                $data["result"] = $this->roles_model->get_contents($keyword, $config["per_page"], $page);
                //pre($data);
                $str_links = $this->pagination->create_links();
                $start = $page + 1;
                $end = $config["per_page"] + $page;
                $output = array(
                    'content' => $this->load->view('roles/list', $data, true),
                    'links' => sort_links($str_links),
                    'start' => $start,
                    'end' => $end > $config["total_rows"] ? $config["total_rows"] : $end,
                    'total' => $config["total_rows"]
                );
                break;
            default:
                break;
        }
        echo json_encode($output);
    }

    function assign()
    {
        $data = [];
        $roles = [1];
        checkUserAccess($roles);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('modules[]', 'Modules', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            //  pre($this->input->post(), 1);
            $role_id = $this->input->post('role_name', TRUE);
            $module_id = $this->input->post('modules[]', TRUE);


            //$mods = array_merge($module_id, $pages);
            $mods = $module_id;
            //pre($mods,1);

            $this->common_model->delete("tbl_role_mod_maping", array('role_id' => $role_id));
            for ($i = 0; $i < count($mods); $i++) {
                $insert['role_id'] = $role_id;
                $insert['module_id'] = $mods[$i];
                //      pre($insert,1);
                $this->_addParent($mods[$i], $role_id);
                $this->common_model->insert('tbl_role_mod_maping', $insert);

            }
            $this->session->set_flashdata('success_response', "DATA UPDATED SUCCESSFULLY ");
            redirect(site_url('Roles/assign_main/'.$role_id));
        }

        $data['title'] = 'Assign Modules';
        $data['roles'] = get_role_name(0, " AND status = 'Y'");
        $data['modules'] = get_modules(0, 'parent_id = 0', 'modules[]', 'multiple', 'required');
        $data['content'] = $this->load->view('roles/assign', $data, TRUE);
        $this->load->view('template', $data);
    }

    function _addParent($m_id, $role_id)
    {
        $parent = getsinglefield("tbl_modules", "parent_id", "WHERE id = " . $m_id);
        $insert['role_id'] = $role_id;
        $insert['module_id'] = $parent;
        $exist = $this->common_model->counttotal("tbl_role_mod_maping", " module_id = $parent AND  role_id = $role_id");
        if ($exist == 0)
        {
            //pre($insert,1);
            $this->common_model->insert('tbl_role_mod_maping', $insert);
        }

        return true;
    }

    /**
     *
     */
    function assign_main($role_id){

        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->form_validation->set_rules('is_landing_page', 'Landing Page Select', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $landing_page = $this->input->post('is_landing_page', TRUE);
            $this->common_model->delete("tbl_role_front_page", array('role_id' => $role_id));
            $this->common_model->insert("tbl_role_front_page", array('role_id' => $role_id, "landing_page" => $landing_page));
            $this->session->set_flashdata('success_response', "DATA UPDATED SUCCESSFULLY ");
            redirect(site_url('Roles/assign/'));
        }

        $results = $this->roles_model->getRoleMapping($role_id);
        $data['roles'] = [];
        $menu = [];
        if ($results) {
            foreach ($results as $link) {
                $j = 0;
                $i = $link->module_name;
                $sublinks = $this->roles_model->getRoleMapping($role_id, $link->m_id);
                if ($sublinks) {
                    foreach ($sublinks as $sublink) {
                        if (hasPermission($role_id, $sublink->class_name, $sublink->method_name)) {
                            $menu[$i]['assigned'][$j]['module'] = $sublink->module_name;
                            $menu[$i]['assigned'][$j]['method'] = $sublink->method_name;
                            $menu[$i]['assigned'][$j]['class'] = $sublink->class_name;
                            $menu[$i]['assigned'][$j]['module_id'] = $sublink->m_id;
                            $j++;
                        }
                    }
                }
            }
        }
        $data['landingPage'] = '';
        $data['landingPage'] = getsinglefield("tbl_role_front_page", "landing_page", " WHERE role_id = " . $role_id);

        $data['menu'] = $menu;
        $data['content'] = $this->load->view('roles/assign_main', $data, TRUE);
        $this->load->view('template', $data);
    }

    function get_sub_modules()
    {
        $id = $this->input->post('module', TRUE);
        $multiple = $this->input->post('multiple', TRUE);
        $id = implode(',', $id);
        $where = " parent_id IN(" . $id . ")";
        if (empty($multiple))
            $html = get_modules(0, $where, 'pages', '', 'required');
        else
            $html = get_modules(0, $where, 'pages[]', 'multiple', 'required');
        //pre($this->db->last_query(),1);
        echo $html;
        exit;
    }

    function loadRights()
    {
        $role_id = $this->input->post('role_id', TRUE);
        $results = $this->roles_model->getRoleMapping($role_id);
        $data['roles'] = [];
        $menu = [];
        if ($results) {
            foreach ($results as $link) {
                $j = 0;
                $i = $link->module_name;
                $sublinks = $this->roles_model->getRoleMapping($role_id, $link->m_id);
                if ($sublinks) {
                    foreach ($sublinks as $sublink) {

                        $menu[$i]['sub_menu'][$j]['module'] = $sublink->module_name;
                        $menu[$i]['sub_menu'][$j]['method'] = $sublink->method_name;
                        $menu[$i]['sub_menu'][$j]['class'] = $sublink->class_name;
                        $menu[$i]['sub_menu'][$j]['module_id'] = $sublink->m_id;
                        $j++;
                    }


                }

            }
        }
        //pre($menu);
        $data['landingPage'] = '';
        $assigned = $this->roles_model->getAssigned($role_id);
        $data['landingPage'] = getsinglefield("tbl_role_front_page", "landing_page", " WHERE role_id = " . $role_id);

        $merged = [];
        $c = 0;
        foreach ($assigned as $key => $val) {
            $merged[$c] = $val['module_id'];
            $c++;
        }
        $data['menu'] = $menu;
        $data['merged'] = $merged;

        $content = $this->load->view('roles/assign_view', $data, TRUE);
        echo $content;
    }
}
