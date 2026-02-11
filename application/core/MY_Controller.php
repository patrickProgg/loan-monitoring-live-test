<?php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Force session cookie settings
        if (!isset($_COOKIE[session_name()]) && php_sapi_name() !== 'cli') {
            ini_set('session.cookie_domain', '.loan-monitoring.alwaysdata.net');
            ini_set('session.cookie_secure', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_samesite', 'None');
        }
    }
}