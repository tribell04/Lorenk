<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencairan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    // Get all pencairan data
    public function get_all_pencairan() {
        $this->db->select('pengeluaran.*, programdonasi.judul');
        $this->db->from('pengeluaran');
        $this->db->join('programdonasi', 'programdonasi.id_program = pengeluaran.program_id', 'left');
        $this->db->order_by('pencairan.tanggal', 'DESC');
        return $this->db->get()->result();
    }
   
    
    // Get detailed pencairan by ID with program info
    public function get_pencairan_detail($id) {
        $this->db->select('pengeluaran.*, programdonasi.judul_program, programdonasi.deskripsi AS program_deskripsi');
        $this->db->from('pengeluaran');
        $this->db->join('programdonasi', 'programdonasi.id = pengeluaran.program_id', 'left');
        $this->db->where('pengeluaran.id', $id);
        return $this->db->get()->row();
    }
    
     public function add_pencairan($data) {
        $this->db->insert('pengeluaran', $data);
        return $this->db->insert_id();
    }
    
    public function get_pencairan_by_year($year) {
        return $this->db->select('
            p.id as id,
            pg.judul as judul_program,
            p.jumlah,
            p.tanggal,
            p.keterangan,
            p.created_at,
            p.created_by
        ')
        ->from('pengeluaran p')
        ->join('programdonasi pg', 'pg.id_program = p.program_id', 'left')
        ->where('YEAR(p.tanggal)', $year)
        ->order_by('p.tanggal', 'DESC')
        ->get()
        ->result();
    }
    
    public function get_total_pencairan($year) {
        $query = $this->db->select_sum('jumlah')
            ->where('YEAR(tanggal)', $year)
            ->get('pengeluaran');
        
        return $query->row()->jumlah ?? 0;
    }
    
    public function get_available_years() {
        return $this->db->query('
            SELECT DISTINCT YEAR(tanggal) as year 
            FROM pengeluaran 
            ORDER BY year DESC
        ')->result();
    }
    
    public function get_pencairan_by_id($id) {
    return $this->db->select('p.*')
        ->from('pengeluaran p')
        ->where('p.id', $id)
        ->get()
        ->row();
}
    

    public function update_pencairan($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('pengeluaran', $data);
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        log_message('error', 'Update gagal: ' . $this->db->last_query());
        return false;
    }
}

    
    public function delete_pencairan($id) {
        $this->db->where('id', $id);
        $this->db->delete('pengeluaran');
        return $this->db->affected_rows();
    }
    
    
    // Get pencairan by program ID
    public function get_pencairan_by_program($program_id) {
        $this->db->where('program_id', $program_id);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('pengeluaran')->result();
    }
    
    // Get total pencairan by program ID
    public function get_total_pencairan_by_program($program_id) {
        $this->db->select_sum('jumlah');
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('pengeluaran');
        
        return $query->row()->jumlah ?? 0;
    }
}