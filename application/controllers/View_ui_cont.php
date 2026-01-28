<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_ui_cont extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // if ($this->session->userdata('urc_user')) {
        //     redirect('dashboard');
        // }

        $this->load->view('auth/login');
        //$this->load->view('dashboard');
        //$this->load->view('layouts/footer');
    }

    public function dashboard()
    {
        $data['total_client'] = $this->db->count_all('tbl_client');
        $data['total_loan_amt'] = $this->db
            ->select_sum('total_amt')
            ->get('tbl_loan')
            ->row()
            ->total_amt;

        $data['total_loan_payment'] = $this->db
            ->select_sum('amt')
            ->get('tbl_payment')
            ->row()
            ->amt;

        $data['total_pull_out'] = $this->db
            ->select_sum('total_pull_out')
            ->get('tbl_pull_out')
            ->row()
            ->total_pull_out;


        $this->load->view('layouts/header');
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer');
    }


    public function monitoring()
    {
        $this->load->view('layouts/header');
        $this->load->view('monitoring');
        $this->load->view('layouts/footer');
    }

    public function pull_out()
    {
        $this->load->view('layouts/header');
        $this->load->view('pull_out');
        $this->load->view('layouts/footer');
    }

    public function expenses()
    {
        $this->load->view('layouts/header');
        $this->load->view('expenses');
        $this->load->view('layouts/footer');
    }

    public function receiving()
    {
        $this->load->view('layouts/header');
        $this->load->view('receiving');
        $this->load->view('layouts/footer');
    }

    public function releasing()
    {
        $this->load->view('layouts/header');
        $this->load->view('releasing');
        $this->load->view('layouts/footer');
    }

}
