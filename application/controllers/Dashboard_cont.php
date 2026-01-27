<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Dashboard_cont extends CI_Controller
class Dashboard_cont extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/navbar');
        $this->load->view('user/dashboard');
        $this->load->view('templates/footer');
    }

}
