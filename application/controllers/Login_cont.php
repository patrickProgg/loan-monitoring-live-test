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

    // public function authenticate()
    // {
    //     $username = $this->input->post('username');
    //     $password = $this->input->post('password');

    //     $user = $this->authenticateUser($username, $password);

    //     if ($user) {
    //         $this->session->set_userdata('logged_in', TRUE);
    //         $this->session->set_userdata('user_id', $user->id);
    //         $this->session->set_userdata('username', $user->username);

    //         echo json_encode(['success' => true]);
    //     } else {
    //         echo json_encode(['success' => false, 'message' => 'Invalid username/email or password.']);
    //     }
    // }


    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // Force session configuration
            ini_set('session.save_path', '/tmp');
            ini_set('session.cookie_secure', '1');
            ini_set('session.cookie_httponly', '1');

            // Restart session with proper settings
            if (session_id()) {
                session_write_close();
            }
            session_start();

            // Set session data manually
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;

            // Also set CI session
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);

            session_write_close();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid username/email or password.']);
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
