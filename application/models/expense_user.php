<?php

class Expense_user extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getNonValidateExpenses($id) {
        $query = $this->db->get_where('expense_users', array('user_id' => $id, 'validate' => '0'));

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    function getNonValidateCount($id) {
        $this->db->select('id');
        $query = $this->db->get_where('expense_users', array('user_id' => $id, 'validate' => '0'));
        return $query->num_rows();
    }

    function getExpenseDetails($expense_id, $user_id) {
        $query = $this->db->get_where('expense_users', array('expense_id' => $expense_id, 'user_id' => $user_id));

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    function getUsersNonPayerByExpenseId($id, $payer_id) {
        $this->db->select('user_id');
        $query = $this->db->query("SELECT user_id FROM expense_users WHERE expense_id=".$id." AND user_id!=".$payer_id);

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    // --------- DELETE --------- //

    function deleteWithUserId($id) {
        try {
            $this->db->delete('expense_users', array('user_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    function deleteWithExpenseId($id) {
        try {
            $this->db->delete('expense_users', array('expense_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    // --------- ADD --------- //
    
    function addExpenseUser($expense_id, $user_id) {
        try {
            $this->db->insert('expense_users', array('expense_id' => $expense_id, 'user_id' => $user_id, 'validate' => 0));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }

}