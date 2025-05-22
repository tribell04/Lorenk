<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencairan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        parent::__construct();
        is_logged_in();
        if ($this->session->userdata('role_id') != 1) {
            redirect('auth/blocked');
        }
        
        $this->load->model('Pencairan_model');
        $this->load->helper('text');
    }

    public function index()
{
    $tahun = $this->input->get('tahun') ?? date('Y');

    $this->db->select('pengeluaran.*, programdonasi.judul AS judul_program');
    $this->db->from('pengeluaran');
    $this->db->join('programdonasi', 'programdonasi.id_program = pengeluaran.program_id');
    $this->db->where('YEAR(pengeluaran.tanggal)', $tahun);
    $this->db->order_by('pengeluaran.tanggal', 'DESC');
    $data['pengeluaran'] = $this->db->get()->result();

    // Perhitungan total
    
    $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($program_id);  // Total donasi untuk program_id
    $data['total_pengeluaran'] = $this->Keuangan_model->get_total_pengeluaran($program_id);  // Total pengeluaran untuk program_id
    $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];

    $data['years'] = $this->ModelDonasi->get_tahun_pencairan();
    $data['selected_year'] = $tahun;

    $this->load->view('admin/pencairan', $data);
}


    public function pencairan() {
        $data['title'] = 'Laporan Pencairan Dana';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
        
        // Default tahun adalah tahun sekarang
        $year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_year($year);
        $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
        $data['years'] = $this->Pencairan_model->get_available_years();
        $data['selected_year'] = $year;
        
        // Get total pemasukan/donasi for comparison
        $this->load->model('Laporan_model'); // Assuming this model exists for donation data
        $data['total_pemasukan'] = $this->Laporan_model->get_total_pemasukan($year);
        
        // Calculate saldo akhir
        $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/pencairan', $data);
        $this->load->view('templates/footer');
    }
    
    public function tambah() {
        $data['title'] = 'Tambah Data Pencairan';
        
        // Load programs for dropdown
        $this->load->model('Program_model');
        $data['programs'] = $this->Program_model->get_all_programs();
        
        // Form validation rules
        $this->form_validation->set_rules('program_id', 'Program', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pencairan', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tambah_pencairan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'program_id' => $this->input->post('program_id'),
                'jumlah' => $this->input->post('jumlah'),
                'tanggal' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ];
            
            $this->Pencairan_model->add_pencairan($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil ditambahkan!</div>');
            redirect('admin/pencairan');
        }
    }
    
    public function hapus($id) {
        // Check if the record exists
        $pencairan = $this->Pencairan_model->get_pencairan_by_id($id);
        
        if (!$pencairan) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
            redirect('admin/pencairan');
        }
        
        // Delete the record
        $this->Pencairan_model->delete_pencairan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil dihapus!</div>');
        redirect('admin/pencairan');
    }
    
    public function edit($id) {
        $data['title'] = 'Edit Data Pencairan';
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_id($id);
        
        if (!$data['pencairan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
            redirect('admin/pencairan');
        }
        
        // Load programs for dropdown
        $this->load->model('Program_model');
        $data['programs'] = $this->Program_model->get_all_programs();
        
        // Form validation rules
        $this->form_validation->set_rules('program_id', 'Program', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pencairan', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit_pencairan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'program_id' => $this->input->post('program_id'),
                'jumlah' => $this->input->post('jumlah'),
                'tanggal' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];
            
            $this->Pencairan_model->update_pencairan($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil diperbarui!</div>');
            redirect('admin/pencairan');
        }
    }
    
    public function detail($id) {
        $data['title'] = 'Detail Pencairan';
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_detail($id);
        
        if (!$data['pencairan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
            redirect('admin/pencairan');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/detail_pencairan', $data);
        $this->load->view('templates/footer');
    }
    
    public function cetak() {
        $data['title'] = 'Cetak Laporan Pencairan';
        
        // Get year from query params
        $year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_year($year);
        $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
        $data['selected_year'] = $year;
        
        // Get total pemasukan/donasi for comparison
        $this->load->model('Laporan_model');
        $data['total_pemasukan'] = $this->Laporan_model->get_total_pemasukan($year);
        
        // Calculate saldo akhir
        $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];
        
        $this->load->view('admin/cetak_pencairan', $data);
    }
}