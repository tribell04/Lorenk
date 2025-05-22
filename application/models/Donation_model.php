<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donation_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Ambil semua donasi dengan detail user, donatur, dan program
    public function getAllDonations() {
        $this->db->select('donasi.id, donatur.nama as nama_donatur, donasi.jumlah, donasi.tanggal, donasi.status, p.judul');
        $this->db->from('donation');
        $this->db->join('donatur', 'donasi.user_id = donatur.user_id', 'left'); // Sesuaikan kolom user_id
        $this->db->join('programdonasi p', 'p.id_program = donasi.program_id', 'left'); // Perbaiki join
        $this->db->order_by('donasi.tanggal', 'DESC'); // Perbaiki alias tabel
        return $this->db->get()->result_array();
    }

    // Simpan data donasi baru
    public function insertDonation($data) {
        return $this->db->insert('donasi', $data);
    }

    // Update status donasi
    public function updateDonationStatus($donasi_id, $status) {
        $this->db->where('id_donasi', $donasi_id);
        return $this->db->update('donasi', ['status' => $status]);
    }  



    // Ambil detail donasi berdasarkan ID
    public function getDonationById($donasi_id) {
        $this->db->where('id_donasi', $donasi_id);
        return $this->db->get('donasi')->row_array();
    }

    // Hapus donasi berdasarkan ID
    public function deleteDonation($donasi_id) {
        $this->db->where('id_donasi', $donasi_id);
        return $this->db->delete('donasi');
    }

    public function get_tanggal_donasi_terawal() {
    return $this->db->select_min('tanggal')->get('programdonasi')->row()->tanggal;
    }

    public function get_tanggal_donasi_terakhir() {
        return $this->db->select_max('tanggal')->get('programdonasi')->row()->tanggal;
    }


    // Ambil donasi yang masih menunggu verifikasi
    public function getPendingDonations() {
        $this->db->where('status', 'pending');
        return $this->db->get('donasi')->result_array();
    }

    // Ambil donasi berdasarkan user_id
    public function getDonationsByDonatur($user_id) {
        if (!ctype_digit((string)$user_id)) return [];

        $this->db->select('d.*, p.judul as program_judul, mp.nama as metode_nama');
        $this->db->from('donation d');
        $this->db->join('programdonasi p', 'p.id_program = d.program_id', 'left');
        $this->db->join('metodePembayaran mp', 'mp.id = d.metodePembayaran', 'left');
        $this->db->where('d.user_id', $user_id);
        $this->db->order_by('d.tanggal', 'DESC');
        
        return $this->db->get()->result_array();
    }

    // Ambil donasi terbaru berdasarkan user_id dengan limit
    public function getRecentDonationsByDonatur($user_id, $limit = 5) {
        if (!ctype_digit((string)$user_id) || !ctype_digit((string)$limit)) return [];

        $this->db->select('d.*, p.judul as program_judul');
        $this->db->from('donasi d');
        $this->db->join('programdonasi p', 'p.id_program = d.program_id', 'left');
        $this->db->where('d.user_id', $user_id);
        $this->db->order_by('d.tanggal', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    // Menghitung total donasi berdasarkan user_id
    public function get_total_donasi_by_user($user_id) {
        if (!ctype_digit((string)$user_id)) return 0;

        $this->db->select_sum('jumlah', 'total_donasi');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('donasi');
        
        return $query->row()->total_donasi ?? 0;
    }

    // Menghitung total donasi berdasarkan program_id
    public function getTotalDonationsByProgram($program_id) {
        if (!ctype_digit((string)$program_id)) return 0;

        $this->db->select_sum('jumlah', 'jumlah_donasi');
        $this->db->where('program_id', $program_id);
        $this->db->where_in('status', ['completed', 'verification']);
        
        $query = $this->db->get('donasi');
        return $query->row()->jumlah_donasi ?? 0;
    }

    // Menghitung jumlah donasi berdasarkan program_id
    public function countDonationsByProgram($program_id) {
        if (!ctype_digit((string)$program_id)) return 0;

        $this->db->where('program_id', $program_id);
        return $this->db->count_all_results('donasi');
    }

    // Cek apakah program memiliki donasi
    public function checkProgramHasDonations($program_id) {
        if (!ctype_digit((string)$program_id)) return false;

        $this->db->where('program_id', $program_id);
        return $this->db->count_all_results('donasi') > 0;
    }
}
?>
