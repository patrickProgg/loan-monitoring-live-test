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
            // DEBUG: Before setting
            error_log("User found: " . $user->username);

            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);

            // DEBUG: After setting
            error_log("Session logged_in: " . ($this->session->userdata('logged_in') ? 'TRUE' : 'FALSE'));
            error_log("Session user_id: " . $this->session->userdata('user_id'));
            error_log("Session username: " . $this->session->userdata('username'));

            // DEBUG: Get all session data
            error_log("All session data: " . print_r($this->session->all_userdata(), true));

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
