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
            // FIRST: Check if session exists, if not start one
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            // SECOND: Manually set a session ID if none exists
            if (empty(session_id())) {
                $new_session_id = bin2hex(random_bytes(16));
                session_id($new_session_id);
            }

            // THIRD: Set session data BEFORE trying to regenerate
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id' => $user->id,
                'username' => $user->username,
                'login_time' => time()
            ]);

            // FOURTH: Now regenerate (optional)
            // $this->session->sess_regenerate(TRUE);

            echo json_encode([
                'success' => true,
                'redirect' => site_url('dashboard'),
                'session_id' => session_id(),
                'user' => $user->username
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

    public function cookie_check()
    {
        echo "<pre>";
        echo "=== COOKIE STATUS ===\n\n";

        echo "1. Current Session ID: " . session_id() . "\n\n";

        echo "2. All Cookies in PHP:\n";
        print_r($_COOKIE);
        echo "\n";

        echo "3. Raw Cookie Header:\n";
        echo $_SERVER['HTTP_COOKIE'] ?? 'No cookie header';
        echo "\n\n";

        echo "4. Database Sessions for this user:\n";
        $this->load->database();
        $session_id = session_id();
        $this->db->where('id', $session_id);
        $session = $this->db->get('ci_sessions')->row();

        if ($session) {
            echo "   Found in database: YES\n";
            echo "   Session data:\n";
            $data = unserialize($session->data);
            print_r($data);
        } else {
            echo "   Found in database: NO\n";
        }

        echo "\n=== END CHECK ===\n";
        echo "</pre>";
    }
}
