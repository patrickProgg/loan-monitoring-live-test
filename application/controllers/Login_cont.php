<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_cont extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        header('Access-Control-Allow-Origin: https://loan-monitoring.alwaysdata.net');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
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
        // FORCE cookie parameters
        ini_set('session.cookie_domain', '.loan-monitoring.alwaysdata.net');
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_samesite', 'None');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // Set session
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id' => $user->id,
                'username' => $user->username,
                'login_time' => time()
            ]);

            // Manually set the cookie to ensure it's sent
            $session_id = session_id();
            $cookie_params = session_get_cookie_params();

            setcookie(
                $this->config->item('sess_cookie_name'),
                $session_id,
                [
                    'expires' => time() + $this->config->item('sess_expiration'),
                    'path' => $cookie_params['path'],
                    'domain' => $this->config->item('cookie_domain'),
                    'secure' => $this->config->item('cookie_secure'),
                    'httponly' => $this->config->item('cookie_httponly'),
                    'samesite' => $this->config->item('cookie_samesite')
                ]
            );

            // Debug output
            error_log("=== LOGIN SUCCESS ===");
            error_log("Session ID: " . $session_id);
            error_log("Cookie set: " . $this->config->item('sess_cookie_name') . "=" . $session_id);

            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard'),
                'session_id' => $session_id,
                'cookie_set' => true
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
}
