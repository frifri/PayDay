<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->model('Plan');
        
        $data['planList'] = $this->Plan->loadPlanList();
        
        $this->load->view('home_view', $data);
    }
}

?>
