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
        // DEBUG: Check current session state
        error_log("=== AUTHENTICATE START ===");
        error_log("Session ID before: " . session_id());
        error_log("Existing session data: " . print_r($this->session->userdata(), true));

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authenticateUser($username, $password);

        if ($user) {
            // CLEAR any existing session first
            $this->session->sess_destroy();

            // Create NEW session
            $this->session->sess_regenerate(TRUE);

            // Set user data
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id' => $user->id,
                'username' => $user->username
            ]);

            // DEBUG: Verify session was saved
            error_log("Session ID after: " . session_id());
            error_log("New session data: " . print_r($this->session->userdata(), true));

            // Check if session exists in database
            $this->db->where('id', session_id());
            $db_session = $this->db->get('ci_sessions')->row();
            error_log("Session in DB: " . ($db_session ? 'YES' : 'NO'));

            // Return session ID for debugging
            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard'),
                'session_id' => session_id() // For debugging
            ]);

            // Force output
            $this->output->_display();
            exit();

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
