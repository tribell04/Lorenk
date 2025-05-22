<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donasi_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_program() {
    return $this->db->select('programdonasi.*, 
        (SELECT IFNULL(SUM(nominal), 0) 
         FROM donation 
         WHERE donation.program_id = programdonasi.id_program 
         AND donation.status = "completed") AS terkumpul')  // Only completed donations
        ->from('programdonasi')
        ->get()
        ->result_array();
}

public function program_by_id($id) {
    $this->db->select('programdonasi.*, 
        (SELECT IFNULL(SUM(nominal), 0) 
         FROM donation 
         WHERE donation.program_id = programdonasi.id_program 
         AND donation.status = "completed") AS terkumpul, 
        (SELECT COUNT(*) 
         FROM donation 
         WHERE donation.program_id = programdonasi.id_program 
         AND donation.status = "completed") AS jumlah_donasi,
         (SELECT COUNT(*) 
         FROM pengeluaran 
         WHERE pengeluaran.program_id = programdonasi.id_program) AS jumlah_pencairan');

    $this->db->from('programdonasi');
    $this->db->where('id_program', $id);
    return $this->db->get()->row_array();
}



    // Ambil semua program donasi
    public function get_all_donasi() {
    $this->db->select('d.id, u.name as nama_donatur, 
                       d.nominal, d.tanggal, d.status, d.buktiPembayaran, 
                       p.judul, p.id_program, p.deskripsi, p.targetDonasi'); 
    $this->db->from('donation d'); 
    $this->db->join('user u', 'd.user_id = u.id', 'left');  // Perbaiki alias
    $this->db->join('programdonasi p', 'd.program_id = p.id_program', 'left');  // Perbaiki alias
    $this->db->where('d.status !=', 'completed');
    $this->db->order_by('d.tanggal', 'DESC');
    return $this->db->get()->result_array();
    }

    public function get_terima($id)
{
    $this->db->select('donation.*, programdonasi.judul'); // sesuaikan nama kolom
    $this->db->from('donation');
    $this->db->join('programdonasi', 'programdonasi.id_program = donation.program_id', 'left'); // sesuaikan nama tabel & kolom
    $this->db->where('donation.id', $id);
    return $this->db->get()->row_array();
}


    // Ambil detail program donasi berdasarkan ID
    public function get_donasi_by_id($id) {
    $id = intval($id); // Pastikan ID adalah integer
    
    $query = $this->db->where('id_program', $id)
                      ->get('programdonasi');
    
    return ($query->num_rows() > 0) ? $query->row_array() : NULL;
    }

    // Menghitung total donasi untuk program tertentu
    public function get_total_donasi_by_program($program_id) {
        return $this->db->select_sum('nominal', 'total_donasi')
                        ->where(['program_id' => $program_id, 'status' => 'completed'])
                        ->get('donation')
                        ->row()->total_donasi ?? 0;
    }

    // Mengecek apakah program memiliki donasi
    public function check_program_has_donations($program_id) {
        return $this->db->where('program_id', $program_id)
                        ->count_all_results('donation') > 0;
    }

    public function add_donation($data) {
        return $this->db->insert('donation', $data);
    }


    public function hapus_donasi($id)
{
    // Optional: hapus juga file bukti pembayaran jika diperlukan
    $donasi = $this->db->get_where('donation', ['id' => $id])->row();
    if ($donasi && !empty($donasi->buktiPembayaran)) {
        $path = FCPATH . 'uploads/' . $donasi->buktiPembayaran;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    // Hapus dari database
    $this->db->where('id', $id);
    $this->db->delete('donation');
}


    // Tambah donasi baru
    public function insert_donasi($data) {
        return $this->db->insert($this->donation, $data);
    }

    

    // Upload bukti transfer
    public function upload_bukti_transfer($id, $buktiPembayaran) {
        return $this->db->where('id', $id)
                        ->update('donation', ['buktiPembayaran' => $buktiPembayaran]);
    }

    // Perbarui status donasi
    public function update_donation_status($id, $status) {
        return $this->db->where('id', $id)
                        ->update('donation', ['status' => $status]);
    }

    // Menghapus donasi tertentu
    public function delete_donation($id) {
        return $this->db->delete('donation', ['id' => $id]);
    }

    // Ambil riwayat donasi berdasarkan user
    public function get_donasi_by_user($user_id)
{
    return $this->db->select('d.*, p.judul as program_judul')
        ->from('donation d')
        ->join('programdonasi p', 'p.id_program = d.program_id', 'left')
        ->where('d.user_id', $user_id)
        ->order_by('d.tanggal', 'DESC')
        ->get()
        ->result();
}


    public function getLaporanByTahun($tahun) {
        $this->db->select('donation.*, user.name AS nama_donatur, programdonasi.judul AS judul_program');
        $this->db->from('donation');
        $this->db->join('user', 'user.id = donation.user_id', 'left');
        $this->db->join('programdonasi', 'programdonasi.id_program = donation.program_id', 'left');
        $this->db->where('YEAR(donation.tanggal)', $tahun);
        $this->db->where('donation.status', 'completed');
        $query = $this->db->get();
        return $query->result();
    }

    // Total donasi yang diberikan oleh user tertentu
    public function get_total_donasi_by_user($user_id) {
        return $this->db->select_sum('nominal', 'total_donasi')
                        ->where(['user_id' => $user_id, 'status' => 'completed'])
                        ->get('donation')
                        ->row()->total_donasi ?? 0;
    }

    public function get_laporan_donasi($tahun)
    {
    $this->db->where('YEAR(tanggal)', $tahun);
    $this->db->where('status', 'completed');
    return $this->db->get('donation')->result();
    }

    public function get_total_donasi($tahun)
    {
        $this->db->select_sum('nominal');
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('status', 'completed');
        return $this->db->get('donation')->row()->nominal ?? 0;
    }
    public function get_total_pengeluaran($tahun)
    {
        return 0; // atau ambil dari tabel pengeluaran terpisah kalau ada
    }

    public function get_monthly_transaction_growth()
{
    $this->db->select('MONTH(tanggal) as bulan, COUNT(id) as jumlah');
    $this->db->from('donation');
    $this->db->where('YEAR(tanggal)', date('Y'));
    $this->db->group_by('MONTH(tanggal)');
    $this->db->order_by('MONTH(tanggal)', 'ASC');
    $query = $this->db->get();

    $result = $query->result();

    // Inisialisasi array 12 bulan
    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    $values = array_fill(0, 12, 0);

    foreach ($result as $row) {
        $bulan_index = (int)$row->bulan - 1;
        $values[$bulan_index] = (int)$row->jumlah;
    }

    return [
        'labels' => $labels,
        'values' => $values
    ];
}


}
