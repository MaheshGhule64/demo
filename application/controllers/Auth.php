<?php

class Auth extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }


    public function index(){
         $this->load->helper('url');
        $this->load->view('form');
    }
}