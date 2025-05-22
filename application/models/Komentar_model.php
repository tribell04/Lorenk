<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function insertKomentar($data)
    {
        // Ini buat insert data ke tabel 'komentar'
        return $this->db->insert('komentar', $data);
    }

    public function get_all_komentar()
    {
        // Ini buat ambil semua komentar (kalau dipakai di index)
        return $this->db->get('komentar')->result();
    }
}
