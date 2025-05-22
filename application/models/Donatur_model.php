<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donatur_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function getAllDonatur() {
        $this->db->select('user.id, user.name, user.email, user.telepon');
        $this->db->from('user');
        $this->db->join('donatur', 'donatur.user_id = user.id', 'left');
        $this->db->where('user.role_id', 2); // Hanya user dengan role_id = 2
        return $this->db->get()->result_array();        
    }
    
    // Ambil donatur berdasarkan ID, hanya jika user bukan admin
    public function getDonaturById($id) {
        $this->db->select('donatur.*, user.name as username, user.email');
        $this->db->from('donatur');
        $this->db->join('user', 'user.id = donatur.user_id');
        $this->db->where('donatur.id', $id);
        $this->db->where('user.role_id', 2); // Hanya user dengan role_id = 2
        $query = $this->db->get();

        return $query->row();
    }
    
    // Ambil donatur berdasarkan user_id, hanya jika bukan admin
    public function getDonaturByUserId($user_id) {
        $this->db->select('donatur.*, user.name as username, user.email');
        $this->db->from('donatur');
        $this->db->join('user', 'user.id = donatur.user_id');
        $this->db->where('user.id', $user_id);
        $this->db->where('user.role_id', 2); // Hanya user dengan role_id = 2
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            // Pastikan user bukan admin sebelum membuat profil donatur
            $this->db->select('role_id');
            $this->db->where('id', $user_id);
            $role_query = $this->db->get('user');

            if ($role_query->row()->role_id == 2) {
                // Buat profil donatur jika belum ada
                $donatur_data = array(
                    'user_id' => $user_id,
                    'nama' => '',
                    'alamat' => '',
                    'noTelp' => ''
                );
                
                $this->db->insert('donatur', $donatur_data);
                
                // Ambil data donatur yang baru dibuat
                $this->db->where('user_id', $user_id);
                $query = $this->db->get('donatur');
            }
        }
        
        return $query->row();
    }
    
    // Update donatur berdasarkan ID
    public function updateDonatur($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('donatur', $data);
        
        return $this->db->affected_rows();
    }
    
    // Hitung jumlah donatur yang bukan admin
    public function countDonatur() {
        $this->db->from('donatur');
        $this->db->join('user', 'user.id = donatur.user_id');
        $this->db->where('user.role_id', 2); // Hanya hitung user dengan role_id = 2
        return $this->db->count_all_results();
    }

}
