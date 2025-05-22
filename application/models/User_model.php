<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function updateUser($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        
        return $this->db->affected_rows();
    }
    
    public function countUsers() {
        return $this->db->count_all('user');
    }

    public function get_chart_data()
    {
        $this->db->select("DATE_FORMAT(tanggal, '%Y-%m') AS bulan, COUNT(DISTINCT user_id) AS jumlah");
        $this->db->from('donation');
        $this->db->group_by('bulan');
        $this->db->order_by('bulan', 'ASC');
        return $this->db->get()->result_array();
    }

    
    public function register_user($data)
    {
        return $this->db->insert('user', $data);
    }

    public function insert_user_token($data)
    {
        return $this->db->insert('user_token', $data);
    }

    public function get_user_by_email($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function get_token($token)
    {
        return $this->db->get_where('user_token', ['token' => $token])->row_array();
    }

    public function activate_user($email)
    {
        $this->db->where('email', $email);
        return $this->db->update('user', ['is_active' => 1]);
    }

    public function delete_user($email)
    {
        return $this->db->delete('user', ['email' => $email]);
    }

    public function delete_token($email)
    {
        return $this->db->delete('user_token', ['email' => $email]);
    }

}
