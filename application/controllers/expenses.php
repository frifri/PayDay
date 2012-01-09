<?php

/**
 * Description of expenses
 *
 * @author frifri
 */
class Expenses extends CI_Controller {
    
    public function index() {
        $this->load->view('expense_detail_view');
    }
    
    public function indexAdd() {
        $this->load->model('Friend');

        $data['friendsList'] = $this->Friend->loadFriendList();
        $data['user_id'] = $this->session->userdata['user_id'];

        $this->load->view('create_expense_view', $data);
    }
    
    public function addExpense() {
        $this->load->model('Expense');
        $this->load->model('Expense_payer');
        $this->load->model('Plan_expense');
        $this->load->model('Expense_user');
        $this->load->model('Plan');
        
        $plan_id = $this->session->userdata('plan_id');
        $payer_id = $this->input->post('payer');
        $friends = $this->input->post('friends');
                
        $expenseArr = array(
            "amount" => $this->input->post('amount'),
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "location" => $this->input->post('location'),
            "date" => now()
        );
        
        // Adding the expense
        $expense_id = $this->Expense->addExpense($expenseArr);
                
        if($expense_id >= 1) {
            // Adding the expense in the plan
            $this->Plan_expense->addPlanExpense($expense_id, $plan_id);
            
            // Adding the payer
            $this->Expense_payer->addExpensePayer($expense_id, $payer_id);
            
            // Adding the friends in this expense
            if(count($friends) >= 1) {
                foreach($friends as $friend_id) {
                    $this->Expense_user->addExpenseUser($expense_id, $friend_id);
                }
            }
            
        }
        
        $plan_id = $this->session->userdata('plan_id');
        
        $data['expenseslist'] = $this->Expense->loadExpenseList($plan_id);
        
        $plan = $this->Plan->getPlanById($plan_id);
        $data['plan_name'] = $plan->name;
        
        $this->load->view('plans_view', $data);
    }
    
    public function deleteExpense() {
        $this->load->model('Expense_payer');
        $this->load->model('Expense_user');
        $this->load->model('Plan_expense');
        $this->load->model('Plan');
        $this->load->model('Expense');
        
        $expense_id = $this->input->get('id', TRUE);
        
        if($this->Expense_payer->deleteWithExpenseId($expense_id)) {
            if($this->Expense_user->deleteWithExpenseId($expense_id)) {
                if($this->Plan_expense->deleteWithExpenseId($expense_id)) {
                    try {
                        $this->db->delete('expenses', array('id' => $expense_id));
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
        
        $plan_id = $this->session->userdata('plan_id');
        
        $data['expenseslist'] = $this->Expense->loadExpenseList($plan_id);
        
        $plan = $this->Plan->getPlanById($plan_id);
        $data['plan_name'] = $plan->name;
        
        $this->load->view('plans_view', $data);
    }
}

?>
