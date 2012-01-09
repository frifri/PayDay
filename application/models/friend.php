<?php

class Friend extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getFriendsByUserId($id) {
        $this->db->select('friend_id');
        $query = $this->db->get_where('friends', array('user_id' => $id));

        if($query->num_rows >= 1)
            return $query->result();
        else
            return FALSE;
    }
    
    // --------- DELETE --------- //

    function deleteWithUserId($id) {
        try {
            $this->db->delete('friends', array('user_id' => $id));
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return FALSE;
        }
        
        return TRUE;
    }
    
    function loadFriendList() {
        $this->load->model('User');
        $user_id = $this->session->userdata('user_id');
        
        $friendsListId = $this->getFriendsByUserId($user_id);
        
        if ($friendsListId) {
            foreach($friendsListId as $friendId) {
                $friend = $this->User->getUserById($friendId->friend_id);
                $friendsList[] = $friend;
            }
        } else {
            $friendsList = array();
        }
        
        return $friendsList;
    }

}