<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Komentar_model'); 
        $this->load->model('Donasi_model'); 
    }

    public function index()
    {
        $data['komentar'] = $this->Komentar_model->get_all_komentar();
        $this->load->view('home/index', $data);
    }


    public function tambahKomentar()
    {
        $nama = $this->input->post('nama', true);
        $komentar = $this->input->post('komentar', true);

        if (empty($nama) || empty($komentar)) {
            $this->session->set_flashdata('error', 'Nama dan komentar harus diisi!');
            redirect('home');
        }

        $data = [
            'nama' => $nama,
            'komentar' => $komentar,
            'tanggal_input' => date('Y-m-d H:i:s')
        ];

        $this->Komentar_model->insertKomentar($data);

        $this->session->set_flashdata('success', 'Komentar berhasil dikirim!');
        redirect('home');
    }

        public function visi_misi()
    {
        $this->load->view('home/visi_misi');
    }

   


}
