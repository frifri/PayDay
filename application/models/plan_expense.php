<?php

class Plan_expense extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getExpensesByPlanId($id) {
        $this->db->select('expense_id');
        $query = $this->db->get_where('plan_expenses', array('plan_id' => $id));

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    // --------- DELETE --------- //
    
    function deleteWithPlanId($id) {
        try {
            $this->db->delete('plan_expenses', array('plan_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }
    
    function deleteWithExpenseId($id) {
        try {
            $this->db->delete('plan_expenses', array('expense_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    // --------- ADD --------- //

    function addPlanExpense($expense_id, $plan_id) {
        try {
            $this->db->insert('plan_expenses', array('plan_id' => $plan_id, 'expense_id' => $expense_id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }
}