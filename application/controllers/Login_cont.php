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
        // 1. Get input
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // 2. Authenticate
        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // 3. Set session data
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id' => $user->id,
                'username' => $user->username
            ]);

            // 4. Return success
            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard'),
                'session_id' => session_id()
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid login']);
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

    public function test_db_session()
    {
        // Simple test - no CORS, no AJAX
        $this->session->set_userdata('test_time', date('H:i:s'));
        $this->session->set_userdata('test_value', 'Database Session Works!');

        echo "<h1>Session Test</h1>";
        echo "Session ID: " . session_id() . "<br>";
        echo "Test Value: " . $this->session->userdata('test_value') . "<br>";
        echo "Test Time: " . $this->session->userdata('test_time') . "<br><br>";

        echo "All Session Data:<br>";
        echo "<pre>";
        print_r($this->session->all_userdata());
        echo "</pre>";

        echo "<br>Cookies:<br>";
        echo "<pre>";
        print_r($_COOKIE);
        echo "</pre>";
    }
}
