<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plans extends CI_Controller {

    public function index() {
        $this->load->model('Expense');
        $this->load->model('Plan');

        $plan_id = $this->input->get('id', TRUE);
        $plan = $this->Plan->getPlanById($plan_id);
        
        $data['expenseslist'] = $this->Expense->loadExpenseList($plan_id);
        
        $data['plan_name'] = $plan->name;
        
        $this->session->set_userdata('plan_id', $plan_id);
        
        $this->load->view('plans_view', $data);
    }

    public function indexAdd() {
        $this->load->model('Friend');

        $data['friendsList'] = $this->Friend->loadFriendList();

        $this->load->view('create_plan_view', $data);
    }
    
    public function getSummary() {
        $this->load->model('User_plan');
        $this->load->model('Plan_expense');
        $this->load->model('Expense');
        $this->load->model('Expense_payer');
        $this->load->model('Expense_user');
        
        $plan_id = $this->session->userdata('plan_id');
        $masterSummary = array();
        //$nbUserInPlan = $this->User_plan->getNbUserInPlan($plan_id);
        
        // Loading the users in this plan
        $userIds = $this->User_plan->getUsersByPlanId($plan_id);
        
        // Generating the master array
        foreach($userIds as $user_id) {
            $curUser_id = $user_id->user_id;
            
            $subSummary = array();
            foreach($userIds as $id) {
                if($id->user_id != $curUser_id) {
                    $subSummary[$id->user_id] = 0;
                }
            }
            
            // Adding the sub summary to the master
            $masterSummary[$curUser_id] = $subSummary;
        }

        // Getting all the expenses for this plan
        $expensesPlanIds = $this->Plan_expense->getExpensesByPlanId($plan_id);
        
        foreach($expensesPlanIds as $expenseId) {
            // Getting the current expense infos
            $curExpense = $this->Expense->getExpenseById($expenseId->expense_id);
            // Getting the current expense payer
            $curExpensePayer = $this->Expense_payer->getExpensePayer($curExpense->id);
            // Getting the current expense amount
            $curExpenseAmount = $curExpense->amount;
            // Getting the users in the expense BUT NOT the payer
            $curExpenseUsers = $this->Expense_user->getUsersNonPayerByExpenseId($curExpense->id, $curExpensePayer->user_id);
            // Getting the number of user in the expense
            $nbUserInExpense = count($curExpenseUsers) + 1;
            
            foreach($curExpenseUsers as $expenseUser) {
                $masterSummary[$curExpensePayer->user_id][$expenseUser->user_id] = ((1/$nbUserInExpense)*$curExpense->amount);
            }
        }
        
        echo "<pre>";
        print_r($masterSummary);
        echo "</pre>";
        
        //$this->load->view('summary_view', $data);
    }

    public function addPlan() {
        $this->load->model('Plan');
        $this->load->model('User_plan');

        $name = $this->input->post('name');
        $friends = $this->input->post('friends');

        $plan_id = $this->Plan->addPlan($name);

        if($plan_id != FALSE) {
            $curUserId = $this->session->userdata('user_id');
            
            // Adding the current plan for the current user
            $this->User_plan->addUserPlan($curUserId, $plan_id);
            
            // Adding the current plan for the current user's friend(s)
            if(count($friends) >= 1) {
                foreach($friends as $friend_id) {
                    $this->User_plan->addUserPlan($friend_id, $plan_id);
                }
            }

            $data['planList'] = $this->Plan->loadPlanList();

            $this->load->view('home_view', $data);
        }
    }

    public function deletePlan() {
        $this->load->model('Plan');

        $plan_id = $this->input->get('id', TRUE);

        $this->Plan->deletePlan($plan_id);

        $data['planList'] = $this->Plan->loadPlanList();

        $this->load->view('home_view', $data);
    }
    
}

?>
