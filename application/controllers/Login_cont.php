<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_cont extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('login');
    }

    public function authenticate()
    {
        // Simple debug
        error_log("=== AUTHENTICATE START ===");
        error_log("POST data: " . print_r($_POST, true));

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // Set session data
            $session_data = [
                'logged_in' => TRUE,
                'user_id' => $user->id,
                'username' => $user->username,
                'login_time' => time()
            ];

            $this->session->set_userdata($session_data);

            // Verify it was set
            error_log("Session set check: " . ($this->session->userdata('logged_in') ? 'TRUE' : 'FALSE'));
            error_log("Session ID: " . session_id());

            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard'),
                'session_id' => session_id()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid login'
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
