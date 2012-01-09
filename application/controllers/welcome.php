<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->view('login_view');
    }

    public function login() {
        $this->load->model('User_plan');
        $this->load->model('Plan');
        
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $this->load->Model('User');
        if($this->User->isUser($login, $password)) {
            $this->session->set_userdata('user_login', $login);

            // Getting the id
            $resId = $this->User->getUserByLogin($login);
            $this->session->set_userdata('user_id', $resId->id);

            $data['planList'] = $this->Plan->loadPlanList();

            $this->load->view('home_view', $data);
        }else{
            $this->load->view('login_view');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->load->view('login_view');
    }

}