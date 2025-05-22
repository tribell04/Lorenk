<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    protected function is_logged_in() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    protected function is_admin() {
        return $this->session->userdata('role') === 'admin';
    }

    protected function is_donatur() {
        return $this->session->userdata('role') === 'donatur';
    }
}