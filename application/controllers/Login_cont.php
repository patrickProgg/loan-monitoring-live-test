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
            // Set session data
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_flashdata('welcome_toast', 'Welcome back, ' . ucfirst($user->username) . '!');

            // Return success response with redirect
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => base_url('dashboard')
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
        $query = $this->db->get('tbl_admin');

        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }
}

