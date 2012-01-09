<?php

class Expense extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function loadExpenseList($plan_id) {
        $this->load->model('Plan_expense');
        $this->load->model('Expense');
        
        $expensesList = array();
        $expensesIdList = $this->Plan_expense->getExpensesByPlanId($plan_id);
        
        if ($expensesIdList) {
            foreach($expensesIdList as $expenseId) {
                $expensesList[] = $this->Expense->getExpenseById($expenseId->expense_id);
            }
        }
        
        return $expensesList;
    }

    function getExpenseById($id) {
        $query = $this->db->query('SELECT id, amount, title, date, description, location FROM expenses WHERE id="'.$id.'"');
        //$query = $this->db->get_where('expenses', array('id' => $id));

        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }
    
    // --------- ADD --------- //
    
    function addExpense($array) {
        try {
            $this->db->insert('expenses', $array);
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return $this->db->insert_id();
    }

    // --------- DELETE --------- //
    
}