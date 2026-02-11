<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_cont extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Login_mod');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // $this->load->view('templates/login_css');
        $this->load->view('login');
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // Only destroy session if you want to clear previous data
            // Consider removing this line if not needed
            $this->session->sess_destroy();

            // Start fresh session for the new user
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);

            // Add redirect URL
            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard') // Change to your actual dashboard URL
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username/email or password.'
            ]);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
    private function authenticateUser($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_admin');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}
