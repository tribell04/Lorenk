<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donasi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Program_model');
        $this->load->model('Donasi_model');
        $this->load->library('session');
    }

    // Tampilkan form donasi berdasarkan program yang dipilih
    public function form($program_id = null) {
        if (!$program_id) {
            show_404();
        }

        $program = $this->Program_model->get_program_by_id($program_id);

        if (!$program) {
            show_404();
        }

        // Pastikan $program dikirim dalam bentuk objek, bukan array
        $data['program'] = (object) $program; 

        $this->load->view('user/donation', $data);
    }

    // Proses penyimpanan donasi
    public function proses() {
        $user_id = $this->session->userdata('user_id');
        $program_id = $this->input->post('id_program'); 

        if (!$program_id) {
            $this->session->set_flashdata('error', 'Program donasi tidak valid.');
            redirect('user/donasi'); 
        }

        // Ambil data dari request
        $user_id = $this->session->userdata('user_id');
        $program_id = $this->input->post('id_program');
        $nominal = $this->input->post('nominal');
        $metodePembayaran = $this->input->post('metodePembayaran');
        $status = 'pending';

        // Validasi data
        if (!$program_id || !$nominal || !$metodePembayaran) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            exit;
        }

        $data = [
            'program_id' => $program_id,
            'user_id' => $user_id,
            'nominal' => $nominal,
            'metode_pembayaran' => $metodePembayaran,
            'tanggal_donasi' => date('Y-m-d H:i:s'),
            'status' => 'pending'
            ];

        // Cek upload bukti
        if (!empty($_FILES['bukti']['name'])) {
            $upload_result = $this->_upload_bukti();
            if ($upload_result['status']) {
                $data['bukti_pembayaran'] = 'uploads/bukti/' . $upload_result['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload_result['error']);
                redirect('donasi/form/' . $program_id);
            }
        }

        if ($this->Donasi_model->insert_donasi($data)) {
            $this->session->set_flashdata('success', 'Donasi berhasil dikirim.');
            redirect('donation/terima_kasih');
        } else {
            $error = $this->db->error();
            log_message('error', 'Kesalahan DB: ' . json_encode($error));
            $this->session->set_flashdata('error', 'Gagal menyimpan donasi: ' . $error['message']);

            redirect('donasi/form/' . $program_id);
        }
    }

    // Fungsi upload bukti transfer
    private function _upload_bukti() {
        $config['upload_path'] = './uploads/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti')) {
            return ['status' => true, 'file_name' => $this->upload->data('file_name')];
        } else {
            return ['status' => false, 'error' => $this->upload->display_errors()];
        }
    }

    // Halaman setelah donasi berhasil
    public function terima_kasih() {
        $this->load->view('donation/terima_kasih');
    }
}
