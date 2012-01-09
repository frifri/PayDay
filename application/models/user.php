<?php

class User extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function loginExist($login) {
        $query = $this->db->get_where('users', array('login' => $login));

        if($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    function emailExist($email) {
        $query = $this->db->get_where('users', array('email' => $email));

        if($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    function isUser($login, $mdp) {
        $query = $this->db->get_where('users', array('login' => $login, 'password' => sha1($mdp)));

        if($query->num_rows() == 1)
            return TRUE;
        else{
            log_message('info', 'Trying to log with login:'.$login.' failed');
            return FALSE;
        }
    }

    // ---------- GET ---------- //

    function getAllUsers() {
        $query = $this->db->get('users');
        return $query->result();
    }

    function getUserById($id) {
        $query = $this->db->get_where('users', array('id' => $id));

        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    function getUserByLogin($login) {
        $this->db->select('id');
        $query = $this->db->get_where('users', array('login' => $login));

        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    // ---------- ADD ---------- //

    function addUser($login, $password, $email, $fullName) {
        try {
            // If login AND email do not exist
            if(!$this->loginExist($login) && !$this->emailExist($email)) {
                $data = array(
                    'login' => $login,
                    'password' => sha1($password),
                    'email' => $email,
                    'fullname' => $fullName
                );

                $this->db->insert('users', $data);
            } else
                return FALSE;
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }

    // ---------- UPDATE ---------- //

    function updateUser($column, $value) {
        try {
            if($column == 'password')
                $this->db->set('password', sha1($value));
            else
                $this->db->set($column, sha1($value));
            
            $this->db->where('id', $user_id);
            $this->db->update('users');
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }
    
    // --------- DELETE --------- //
    
    function deleteUser($id) {
        $this->load->model('expense_payer');
        $this->load->model('expense_user');
        $this->load->model('user_plan');
        $this->load->model('friend');
        
        if ($this->expense_payer->deleteWithUserId($id)) {
            if($this->expense_user->deleteWithUserId($id)) {
                if($this->user_plan->deleteWithUserId($id)) {
                    if($this->friend->deleteWithUserId($id)) {
                        try {
                            $this->db->delete('users', array('id' => $id));
                        } catch(Exception $e) {
                            log_message('error', $e->getMessage());
                            return FALSE;
                        }
                    } else 
                        return FALSE;
                } else
                    return FALSE;
            } else 
                return FALSE;
        } else
            return FALSE;

        return TRUE;
    }

}
