<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    
    public function get_total_pemasukan(){
        $this->db->select_sum('nominal');
        $this->db->from('donation');
        $this->db->where('status', 'Diterima'); // Ubah sesuai status valid di sistemmu
        $query = $this->db->get();

        return $query->row()->nominal ?? 0;
    }

    public function get_all_donatur() {
    $this->db->select('u.id, u.name, u.email, SUM(d.nominal) AS total_donasi');
    $this->db->from('user u');
    $this->db->join('donation d', 'd.user_id = u.id AND d.status = "completed"', 'left');
    $this->db->where('u.role_id', 2); // Tambahkan ini untuk filter hanya donatur
    $this->db->group_by('u.id');
    $this->db->order_by('total_donasi', 'DESC');

    return $this->db->get()->result_array();
    }

    public function tambah_donatur()
    {
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'role_id' => 2, // Misalnya, 2 untuk donatur
            'is_active' => 1,
            'date_created' => time()
        ];
        $this->db->insert('user', $data);
    }

    public function hapus_donatur($id){
        $this->db->delete('user', ['id' => $id]);
    }

    public function get_donatur_by_id($id){
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    public function edit_donatur($id){
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
        ];
        $this->db->update('user', $data, ['id' => $id]);
    }

    public function count_donatur() {
        $this->db->where('role_id', 2);
        return $this->db->count_all_results('user');
    }


    public function aktivasi_donatur($id) {
        $this->db->set('is_active', 1);
        $this->db->where('id', $id);
        $this->db->update('user');
    }

    // kelola admin
    public function get_all_users() {
        $this->db->from('user');
        $this->db->where('role_id', 2); // hanya ambil customer dengan role_id 2
        return $this->db->get()->result();
    }

    public function get_admin_aktif() {
        return $this->db->get_where('user', ['role_id' => 1, 'is_active' => 1])->result();
    }

    public function insert_user($data) {
        return $this->db->insert('user', $data);
    }

    public function delete_admin($id) {
        return $this->db->delete('user', ['id' => $id, 'role_id' => 1]);
    } //kelola admin
}