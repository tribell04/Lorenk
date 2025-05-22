<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTotalProgramAktif()
    {
        $this->db->where('status', 'active');
        return $this->db->count_all_results('programdonasi'); // Ganti 'program' dengan nama tabel program Anda
    }
    
public function getAllPrograms() {
    return $this->db->select('
            p.id_program, 
            p.judul, 
            p.deskripsi, 
            p.tanggal_mulai, 
            p.tanggal_selesai, 
            p.targetDonasi, 
            p.status, 
            p.foto,
            IFNULL(SUM(d.nominal), 0) AS total_terkumpul,
            CASE 
                WHEN SUM(d.nominal) >= p.targetDonasi THEN 1 
                ELSE 0 
            END AS is_completed
        ')
        ->from('programdonasi p')
        ->join('donation d', 'd.program_id = p.id_program AND d.status = "completed"', 'left')
        ->group_by([
            'p.id_program', 
            'p.judul', 
            'p.deskripsi', 
            'p.tanggal_mulai', 
            'p.tanggal_selesai', 
            'p.targetDonasi', 
            'p.status', 
            'p.foto'
        ])
        ->order_by('p.tanggal_mulai', 'DESC')
        ->get()
        ->result();
}


    
    // Mendapatkan semua program donasi yang masih aktif
    public function getAllActivePrograms() {
        return $this->db->select('id_program, judul, deskripsi, tanggal_mulai, tanggal_selesai, targetDonasi, status, foto')
                        ->from('programdonasi')
                        ->where('status', 'active')
                        ->where('tanggal_selesai >=', date('Y-m-d'))
                        ->order_by('tanggal_mulai', 'DESC')
                        ->get()
                        ->result();
    }
    
    // Mendapatkan program donasi berdasarkan ID
    public function getProgramById($id) {
        $program = $this->db->select('id_program, judul, deskripsi, tanggal_mulai, tanggal_selesai, targetDonasi, status, foto')
                            ->from('programdonasi')
                            ->where('id_program', $id)
                            ->get()
                            ->row();

        if ($program) {
            // Cek apakah foto tersedia, jika tidak gunakan default
            $program->foto = (isset($program->foto) && !empty($program->foto)) 
                ? base_url('uploads/program/' . $program->foto) 
                : base_url('assets/img/default.jpg');
        }

        return $program ?: NULL;
    }

    // dashboard
    public function get_distribusi_dana()
{
    // Ambil data distribusi dana berdasarkan kategori program
    $this->db->select('kategori, SUM(dana_tersalurkan) as total_dana');
    $this->db->from('programdonasi');
    $this->db->where('status', 'aktif');
    $this->db->group_by('kategori');
    $query = $this->db->get();
    
    // Persiapkan array untuk data
    $labels = [];
    $values = [];
    
    // Kategori default
    $kategori_default = ['Pendidikan', 'Kesehatan', 'Pangan', 'Infrastruktur'];
    $data_kategori = [];
    
    // Inisialisasi data kategori dengan nilai 0
    foreach ($kategori_default as $kategori) {
        $data_kategori[$kategori] = 0;
    }
    
    // Isi dengan data sebenarnya
    foreach ($query->result() as $row) {
        $kategori = $row->kategori;
        $total_dana = (float)$row->total_dana;
        
        // Jika kategori sudah ada di default kategori, update nilainya
        if (array_key_exists($kategori, $data_kategori)) {
            $data_kategori[$kategori] = $total_dana;
        } else {
            // Jika kategori baru, tambahkan ke array
            $data_kategori[$kategori] = $total_dana;
        }
    }
    
    // Konversi data menjadi format yang sesuai untuk chart
    foreach ($data_kategori as $kategori => $dana) {
        $labels[] = $kategori;
        $values[] = $dana;
    }
    
    // Return data dalam format yang dibutuhkan chart
    return [
        'labels' => $labels,
        'values' => $values
    ];
}
    

    public function get_program_by_id($id)
{
    return $this->db->get_where('programdonasi', ['id_program' => $id])->row();
}

    // Menambahkan program donasi baru
    public function createProgramDonasi($data) {
        $this->db->insert('programdonasi', $data);
        return $this->db->insert_id();
    }
    
    // Mengupdate data program donasi
    public function updateProgram($id_program, $data) {
        $this->db->where('id_program', $id_program);
        return $this->db->update('programdonasi', $data);
    }

    // Menghapus program donasi
    public function deleteProgramDonasi($id) {
        // Cek apakah ada foto terkait sebelum menghapus
        $program = $this->getProgramById($id);
        
        if ($program && isset($program->foto) && !empty($program->foto)) {
            $file_path = './uploads/program/' . basename($program->foto);
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file foto
            }
        }

        $this->db->where('id_program', $id);
        $this->db->delete('programdonasi');
        return $this->db->affected_rows();
    }
    
    // Menghitung jumlah program donasi yang masih aktif
    public function countActivePrograms() {
        return $this->db->where('status', 'active')
                        ->where('tanggal_selesai >=', date('Y-m-d'))
                        ->count_all_results('programdonasi');
    }
    
    // Menghitung progres donasi berdasarkan ID program
    public function getProgramProgress($program_id) {
        // Ambil target donasi dari program terkait
        $program = $this->db->select('targetDonasi')
                            ->where('id_program', $program_id)
                            ->get('programdonasi')
                            ->row();
        
        if (!$program) {
            return 0;
        }
        
        $target = $program->targetDonasi;

        // Ambil total donasi yang masuk
        $donation = $this->db->select_sum('nominal', 'total_donasi') // Perbaiki kolom dari 'jumlah' ke 'nominal'
                             ->where('program_id', $program_id)
                             ->where_in('status', ['completed', 'verification'])
                             ->get('donation')
                             ->row();
        
        $current = isset($donation->total_donasi) ? $donation->total_donasi : 0;
        
        // Hitung persentase pencapaian
        return ($target > 0) ? min(100, ($current / $target) * 100) : 0;
    }

    public function updateStatusIfTargetReached() {
    $programs = $this->db->get('programdonasi')->result_array();

    foreach ($programs as $program) {
        $this->db->select_sum('nominal');
        $this->db->where('program_id', $program['id_program']);
        $this->db->where('status', 'completed');
        $total_donasi = $this->db->get('donation')->row()->nominal;

        if ($total_donasi >= $program['targetDonasi']) {
            $this->db->where('id_program', $program['id_program']);
            $this->db->update('programdonasi', ['is_completed' => 1]);
        }
    }
}

    public function get_all_programs() {
    return $this->db->select('id_program, judul')->get('programdonasi')->result();
}


    //pencairan
    public function getAllProgramsWithTotal()
{
    $this->db->select('programdonasi.id_program, programdonasi.judul, 
        (SELECT SUM(nominal) FROM donation WHERE donation.program_id = programdonasi.id_program) AS total_donasi');
    return $this->db->get('programdonasi')->result();
}


}
?>
