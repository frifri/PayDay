<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Friends extends CI_Controller{
    public function index() {
        $this->load->view('friends_view');
    }
    
    public function loadFriends() {
        $this->load->model('Friend');
        
        $data['friendsList'] = $this->Friend->loadFriendList();
        
        $this->load->view('friends_view', $data);
    }
}
