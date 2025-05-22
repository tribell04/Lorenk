<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Donasi_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['riwayat'] = $this->Donasi_model->get_riwayat_donasi($user_id);
        
        $this->load->view('user/riwayat_donasi', $data);
    }
}
