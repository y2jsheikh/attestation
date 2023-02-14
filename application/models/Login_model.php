<?php

class Login_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    function login($username, $password)
    {
    //    if (!array($username) && !array($password)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return $query->row();
            } else {
                return false;
            }

    //    } else {
    //        return false;
    //    }

    }

    function login_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('id', $id);
        $this->db->where('status', 'Y');
        //$this->db->where('is_firstlogin', 'N');
        //    $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function check_password($password, $id)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('password', $password);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //for forget pass
    public function getUserInfoByEmail($email)
    {
        //ok
        $q = $this->db->get_where('tbl_users', array('email' => $email), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $email . ')');
            return false;
        }
    }

    //for forget pass (cnic)
    public function getUserInfoByCnic($cnic)
    {
        //ok
        $q = $this->db->get_where('tbl_users', array('cnic' => $cnic), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $cnic . ')');
            return false;
        }
    }

    public function insertToken($user_id)
    {   //ok
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');
        $string = array(
            'token' => $token,
            'user_id' => $user_id,
            'created' => $date
        );
        $query = $this->db->insert_string('tokens', $string);
        $this->db->query($query);
        //echo $this->db->last_query();
        //die;
        return $token . $user_id;
    }

    public function isTokenValid($token)
    {//ok
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn,
            'tokens.user_id' => $uid
        ), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);
            if ($createdTS != $todayTS) {
                return false;
            }
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    public function getUserInfo($id)
    {
        $q = $this->db->get_where('tbl_users', array('id' => $id), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function updatePassword($post)
    {   //ok
        $this->db->where('id', $post['user_id']);
        $updated = strtotime(date("Y-m-d H:i:s", time()));
        $this->db->update('tbl_users', array('password' => $post['password'], 'updated' => $updated));
        $success = $this->db->affected_rows();
        if (!$success) {
            error_log('Unable to updatePassword(' . $post['user_id'] . ')');
            return false;
        }
        return true;
    }

}

?>