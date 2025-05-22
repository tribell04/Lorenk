<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTotalDonasi() {
        $this->db->select_sum('jumlah');
        $this->db->where_in('status', ['completed', 'verification']);
        $query = $this->db->get('donation');
        
        return $query->row()->jumlah ?? 0;
    }
    
    public function getJumlahDonatur() {
        return $this->db->count_all('donatur');
    }
    
    public function getJumlahKampanyeAktif() {
        $this->db->where('status', 'active');
        $this->db->where('tanggal_selesai >=', date('Y-m-d'));
        return $this->db->count_all_results('program_donasi');
    }
    
    public function getLastUpdated() {
        $this->db->select_max('tanggal');
        $query = $this->db->get('donation');
        
        return $query->row()->tanggal;
    }
    
    public function getStatistikDonatur() {
        $this->db->select('MONTH(tanggal) as month, COUNT(DISTINCT user_id) as jumlah_donatur');
        $this->db->where('YEAR(tanggal)', date('Y'));
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('MONTH(tanggal)');
        $query = $this->db->get('donation');
        
        return $query->result();
    }
    
    public function getProgressKampanye() {
        $this->db->select('program_donasi.id, program_donasi.judul, program_donasi.targetDonasi');
        $this->db->from('program_donasi');
        $this->db->where('program_donasi.status', 'active');
        $this->db->where('program_donasi.tanggal_selesai >=', date('Y-m-d'));
        $query = $this->db->get();
        $programs = $query->result();
        
        $progress_data = [];
        foreach($programs as $program) {
            // Get current donations
            $this->db->select_sum('jumlah');
            $this->db->where('program_id', $program->id);
            $this->db->where_in('status', ['completed', 'verification']);
            $donation = $this->db->get('donation')->row();
            
            $current = $donation->jumlah ?? 0;
            
            // Calculate percentage
            $percentage = 0;
            if($program->targetDonasi > 0) {
                $percentage = min(100, ($current / $program->targetDonasi) * 100);
            }
            
            $progress_data[] = (object)[
                'id' => $program->id,
                'judul' => $program->judul,
                'target' => $program->targetDonasi,
                'current' => $current,
                'percentage' => $percentage
            ];
        }
        
        return $progress_data;
    }
    
    public function getGrafikDonasiPerBulan() {
        $this->db->select('MONTH(tanggal) as month, SUM(jumlah) as total');
        $this->db->where('YEAR(tanggal)', date('Y'));
        $this->db->where_in('status', ['completed', 'verification']);
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('MONTH(tanggal)');
        $query = $this->db->get('donation');
        
        return $query->result();
    }
    
    public function getRiwayatDonasi($limit) {
        $this->db->select('donation.*, donatur.nama as nama_donatur, program_donasi.judul as judul_program');
        $this->db->from('donation');
        $this->db->join('donatur', 'donatur.user_id = donation.user_id', 'left');
        $this->db->join('program_donasi', 'program_donasi.id = donation.program_id');
        $this->db->where_in('donation.status', ['completed', 'verification']);
        $this->db->order_by('donation.tanggal', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result();
    }
}
