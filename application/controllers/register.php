<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index() {
        $data['errorDesc'] = '';

        $this->load->view('register_view', $data);
    }

    public function addUser() {
        $this->load->model('User');

        $login = $this->input->post('login');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $fullName = $this->input->post('fullName');

        if($this->User->addUser($login, $password, $email, $fullName)) {
            $this->session->set_userdata('user_login', $login);
            $this->load->view('home_view');
        }else{
            $data['errorDesc'] = "An Error occured while creating the user";

            $this->load->view('register_view', $data);
        }
    }

}

?>
