<?php

class Plan extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function loadPlanList() {
        $this->load->model('User_plan');

        $user_id = $this->session->userdata('user_id');
        $planList = array();

        $planIdList = $this->User_plan->getPlansByUserId($user_id);

        if($planIdList) {
            foreach($planIdList as $planId) {
                $planList[] = $this->Plan->getPlanById($planId->plan_id);
            }

            $ret = $planList;
        }else{
            $ret = array();
        }

        return $ret;
    }

    function getPlanById($id) {
        $query = $this->db->get_where('plans', array('id' => $id));

        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    // --------- ADD --------- //
    
    function addPlan($name) {
        try {
            $this->db->insert('plans', array('name' => $name));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return $this->db->insert_id();
    }
    
    // --------- DELETE --------- //

    function deletePlan($id) {
        $this->load->model('User_plan');
        $this->load->model('Plan_expense');

        if($this->User_plan->deleteWithPlanId($id)) {
            if($this->Plan_expense->deleteWithPlanId($id)) {
                try {
                    $this->db->delete('plans', array('id' => $id));
                } catch(Exception $e) {
                    log_message('error', $e->getMessage());
                    return FALSE;
                }
            } else
                return FALSE;
        } else
            return FALSE;

        return TRUE;
    }

}

