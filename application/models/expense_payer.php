<?php

class Expense_payer extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // ---------- GET ---------- //
    
    function getExpensePayer($id) {
        $this->db->select('user_id');
        $query = $this->db->get_where('expense_payers', array('expense_id' => $id));

        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }
    
    // --------- DELETE --------- //

    function deleteWithUserId($id) {
        try {
            $this->db->delete('expense_payers', array('user_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    function deleteWithExpenseId($id) {
        try {
            $this->db->delete('expense_payers', array('expense_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    // --------- ADD --------- //
    
    function addExpensePayer($expense_id, $payer_id) {
        try {
            $this->db->insert('expense_payers', array('expense_id' => $expense_id, 'user_id' => $payer_id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }

}