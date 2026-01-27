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
        // if (!$this->session->userdata('urc_user')) {
        //     redirect('View_ui_cont');
        // }

        // $data['show_greeting'] = $this->session->userdata('show_greeting');
        // $data['greeting'] = $this->session->userdata('greeting');
        // $data = $this->Dashboard_mod->count_txt_files();

        // $this->session->unset_userdata('show_greeting');
        // $this->session->unset_userdata('greeting');

        // $id = $this->session->userdata('emp_id');
        // $user = $this->Dashboard_mod->get_user_img($id);
        // $img['img'] = isset($user->photo) ? $user->photo : base_url('assets/images/user.png');

        // $data = array_merge($data, $this->Dashboard_mod->get_totals());

        $this->load->view('layouts/header');
        $this->load->view('dashboard');
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
