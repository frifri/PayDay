<?php

class User_plan extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getPlansByUserId($id) {
        $this->db->select('plan_id');
        $query = $this->db->get_where('user_plans', array('user_id' => $id));

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    function getUsersByPlanId($id) {
        $this->db->select('user_id');
        $query = $this->db->get_where('user_plans', array('plan_id' => $id));

        if($query->num_rows() >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
//    function getNbUserInPlan($id) {
//        $this->db->select('user_id');
//        $query = $this->db->get_where('user_plans', array('plan_id' => $id));
//
//        return $query->num_rows();
//    }

    // --------- DELETE --------- //

    function deleteWithUserId($id) {
        try {
            $this->db->delete('user_plans', array('user_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }
    
    function deleteWithPlanId($id) {
        try {
            $this->db->delete('user_plans', array('plan_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }

        return TRUE;
    }
    
    // --------- ADD --------- //

    function addUserPlan($user_id, $plan_id) {
        try {
            $data = array(
                'user_id' => $user_id,
                'plan_id' => $plan_id
            );
            
            $this->db->insert('user_plans', $data);
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }

}