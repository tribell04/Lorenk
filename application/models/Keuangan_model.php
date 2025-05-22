<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load database
    }

    // Metode untuk mengambil semua data dari tabel keuangan
    public function get_data() {
        return $this->db->get('tabel_keuangan')->result(); // Ganti 'tabel_keuangan' sesuai nama tabel di database
    }

    public function get_total_pemasukan()
{
    $this->db->select_sum('nominal');
    $this->db->where('status', 'completed'); // Atau sesuai status "berhasil"
    $query = $this->db->get('donation');
    return $query->row()->nominal ?? 0;
}

public function get_total_pengeluaran($tahun)
{
    return $this->db->select_sum('jumlah')
        ->where('YEAR(tanggal)', $tahun)
        ->get('pengeluaran')->row()->jumlah ?? 0;
}

public function get_all_pengeluaran_by_year($tahun)
{
    return $this->db->where('YEAR(tanggal)', $tahun)
        ->order_by('tanggal', 'DESC')
        ->get('pengeluaran')->result();
}
// CRUD Pengeluaran
    public function get_all()
    {
        return $this->db->order_by('tanggal', 'DESC')->get('pengeluaran')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('pengeluaran', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('pengeluaran', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('pengeluaran', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('pengeluaran', ['id' => $id]);
    }

public function get_distribusi_dana()
{
    $this->db->select('kategori, SUM(nominal) AS total');
    $this->db->from('pengeluaran');
    $this->db->group_by('kategori');
    return $this->db->get()->result_array();
}



    //pencairan new

    // Mendapatkan data pencairan per program berdasarkan tahun
    public function get_pencairan_per_program($tahun) {
        $this->db->select('p.id_program, p.judul, COUNT(pc.id_pencairan) as jumlah_pencairan, 
                         COALESCE(SUM(pc.jumlah_dana), 0) as total');
        $this->db->from('program p');
        $this->db->join('pencairan pc', 'p.id_program = pc.id_program AND pc.status = "completed" AND YEAR(pc.tanggal_transfer) = ' . $this->db->escape($tahun), 'left');
        $this->db->group_by('p.id_program');
        $this->db->order_by('total', 'DESC');
        
        return $this->db->get()->result();
    }
    
    // Mendapatkan data ringkasan pencairan bulanan untuk tahun tertentu
    public function get_pencairan_bulanan($tahun) {
        $this->db->select('MONTH(tanggal_transfer) as bulan, 
                          COUNT(id_pencairan) as jumlah_pencairan, 
                          SUM(jumlah_dana) as total_pencairan');
        $this->db->from('pencairan');
        $this->db->where('status', 'completed');
        $this->db->where('YEAR(tanggal_transfer)', $tahun);
        $this->db->group_by('MONTH(tanggal_transfer)');
        $this->db->order_by('bulan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    // Mendapatkan total pencairan untuk tahun tertentu
    public function get_total_pencairan_tahun($tahun) {
        $this->db->select('COALESCE(SUM(jumlah_dana), 0) as total_pencairan, COUNT(id_pencairan) as jumlah_transaksi');
        $this->db->from('pencairan');
        $this->db->where('status', 'completed');
        $this->db->where('YEAR(tanggal_transfer)', $tahun);
        
        return $this->db->get()->row();
    }
    
    // Mendapatkan daftar tahun yang tersedia untuk filter
    public function get_tahun_pencairan() {
        $this->db->select('DISTINCT YEAR(tanggal_transfer) as tahun');
        $this->db->from('pencairan');
        $this->db->where('status', 'completed');
        $this->db->where('tanggal_transfer IS NOT NULL');
        $this->db->order_by('tahun', 'DESC');
        
        $query = $this->db->get();
        
        // Jika tidak ada data, kembalikan tahun sekarang
        if ($query->num_rows() == 0) {
            return [['tahun' => date('Y')]];
        }
        
        return $query->result();
    }
    
    // Mendapatkan detail pencairan berdasarkan ID program
    public function get_detail_pencairan_program($id_program, $tahun = null) {
        $this->db->select('pc.*, a.nama as nama_admin');
        $this->db->from('pencairan pc');
        $this->db->join('admin a', 'pc.id_admin = a.id_admin', 'left');
        $this->db->where('pc.id_program', $id_program);
        
        if ($tahun) {
            $this->db->where('YEAR(pc.tanggal_pengajuan)', $tahun);
        }
        
        $this->db->order_by('pc.tanggal_pengajuan', 'DESC');
        
        return $this->db->get()->result();
    }
    
    // Mendapatkan detail pencairan berdasarkan ID pencairan
    public function get_pencairan_by_id($id_pencairan) {
        $this->db->select('pc.*, p.judul, a.nama as nama_admin');
        $this->db->from('pencairan pc');
        $this->db->join('program p', 'pc.id_program = p.id_program');
        $this->db->join('admin a', 'pc.id_admin = a.id_admin', 'left');
        $this->db->where('pc.id_pencairan', $id_pencairan);
        
        return $this->db->get()->row_array();
    }
    
    // Mendapatkan daftar pencairan dengan filter dan pagination
    public function get_pencairan_list($limit, $start, $status = null, $id_program = null, $search = null) {
        $this->db->select('pc.*, p.judul, a.nama as nama_admin');
        $this->db->from('pencairan pc');
        $this->db->join('program p', 'pc.id_program = p.id_program');
        $this->db->join('admin a', 'pc.id_admin = a.id_admin', 'left');
        
        // Filter berdasarkan status
        if ($status) {
            $this->db->where('pc.status', $status);
        }
        
        // Filter berdasarkan program
        if ($id_program) {
            $this->db->where('pc.id_program', $id_program);
        }
        
        // Filter berdasarkan pencarian
        if ($search) {
            $this->db->group_start();
            $this->db->like('p.judul', $search);
            $this->db->or_like('pc.keterangan_pengajuan', $search);
            $this->db->or_like('pc.nomor_rekening', $search);
            $this->db->or_like('pc.nama_rekening', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('pc.tanggal_pengajuan', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        
        return $this->db->get()->result_array();
    }

    //baru
    
    
    public function get_pemasukan_by_month($year) {
        $query = $this->db->select('
                MONTH(payment_date) as month,
                SUM(nominal) as total
            ')
            ->where('status', 'completed')
            ->where('YEAR(payment_date)', $year)
            ->group_by('MONTH(payment_date)')
            ->order_by('MONTH(payment_date)', 'ASC')
            ->get('donation');
        
        return $query->result();
    }
    
    public function get_pemasukan_by_program($year) {
        $query = $this->db->select('
                p.id_program,
                p.judul,
                SUM(d.nominal) as total
            ')
            ->from('donation d')
            ->join('programdonasi p', 'p.id_program = d.program_id', 'left')
            ->where('d.status', 'completed')
            ->where('YEAR(d.payment_date)', $year)
            ->group_by(['p.id_program', 'p.judul'])
            ->order_by('total', 'DESC')
            ->get();
        
        return $query->result();
    }
    
    public function get_available_years() {
        $query_pemasukan = $this->db->query('
            SELECT DISTINCT YEAR(payment_date) as year 
            FROM donation 
            WHERE status = "completed"
            ORDER BY year DESC
        ');
        
        $query_pengeluaran = $this->db->query('
            SELECT DISTINCT YEAR(tanggal) as year 
            FROM pengeluaran 
            ORDER BY year DESC
        ');
        
        $years_pemasukan = $query_pemasukan->result();
        $years_pengeluaran = $query_pengeluaran->result();
        
        // Merge and get unique years
        $years = [];
        foreach ($years_pemasukan as $year) {
            $years[$year->year] = $year->year;
        }
        
        foreach ($years_pengeluaran as $year) {
            $years[$year->year] = $year->year;
        }
        
        // Sort years descending
        krsort($years);
        
        // Convert to objects
        $result = [];
        foreach ($years as $year) {
            $obj = new stdClass();
            $obj->year = $year;
            $result[] = $obj;
        }
        
        return $result;
    }


}
?>
