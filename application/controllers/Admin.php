<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        if ($this->session->userdata('role_id') != 1) {
            redirect('auth/blocked');
        }
        $this->load->model('Admin_model');
        $this->load->model('Keuangan_model');
        $this->load->model('Donatur_model');
        $this->load->model('Donasi_model');
        $this->load->model('Donation_model');
        $this->load->model('Program_model');
        $this->load->model('Report_model');
        $this->load->model('Pencairan_model');
        $this->load->helper('text');
        $this->load->model('Dashboard_model');
    }

    // Dashboard
    public function index()
{
    $data['title'] = 'Dashboard';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    // Misalnya program_id diambil dari parameter atau dari sesi
    $program_id = 1; // Ganti dengan ID program yang sesuai

    $data['total_donatur'] = $this->Admin_model->count_donatur();
    $data['total_program'] = $this->Program_model->getTotalProgramAktif();
    $year = date('Y'); 
    $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
    $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year); // <-- penting
    $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
}

    // Kelola Donatur
public function kelola_admin()
{
    $data['title'] = 'Kelola Admin';
    
    // Ambil data admin yang aktif
    $data['admin'] = $this->Admin_model->get_admin_aktif();

    // Ambil data user yang sedang login
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // Load view
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/kelola_admin', $data);
    $this->load->view('templates/footer');
}

public function tambah_admin()
{
    $data['title'] = 'Tambah Admin';

    // Ambil user login untuk sidebar/topbar
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/tambah_admin', $data);
    $this->load->view('templates/footer');
}

public function simpan_admin()
{
    $this->_rulesadmin();

    if ($this->form_validation->run() == FALSE) {
        $this->tambah_admin();
    } else {
        $data = [
            'name'         => $this->input->post('name', true),
            'email'        => $this->input->post('email', true),
            'image'        => 'default.jpg',
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id'      => 1, // Admin
            'is_active'    => 1,
            'date_created' => time()
        ];

        $this->Admin_model->insert_user($data);

        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                Data Admin Berhasil Ditambahkan!
            </div>');

        redirect('admin/kelola_admin');
    }
}

public function delete_admin($id)
{
    $this->Admin_model->delete_admin($id);

    $this->session->set_flashdata('pesan', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Admin berhasil dihapus!
        </div>');

    redirect('admin/kelola_admin');
}

private function _rulesadmin()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Nama', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
        'is_unique' => 'Email ini sudah terdaftar!'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
}


    // Kelola Donatur
    public function donatur()
    {
        $data['title'] = 'Data Donatur';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['donatur'] = $this->Admin_model->get_all_donatur();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/donatur', $data);
        $this->load->view('templates/footer');
    }

    

    // Kelola Donasi
    public function donasi() {
        $this->load->model('Donasi_model');

        $data['title'] = 'Kelola Donasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['donasi'] = $this->Donasi_model->get_all_donasi(); // Panggil method dengan nama yang benar        
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/donasi', $data);
        $this->load->view('templates/footer');
    }

    public function update_status_donasi()
{
    $id = $this->input->post('id');
    $status = $this->input->post('status');

    $this->db->where('id', $id);
    $this->db->update('donation', ['status' => $status]);

    $this->session->set_flashdata('success', 'Status donasi berhasil diperbarui.');
    redirect('admin/donasi');
}

public function hapus_donasi($id)
{
    $this->load->model('Donasi_model');
    $this->Donasi_model->hapus_donasi($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success">Data donasi berhasil dihapus.</div>');
    redirect('admin/donasi');
}


    // Kelola Program Donasi
   public function program()
    {
        $data['title'] = 'Kelola Program Donasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['program'] = $this->Program_model->getAllPrograms();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/program', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_program()
    {
        $data['title'] = 'Tambah Program Donasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('targetDonasi', 'Target Donasi', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data); 
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/program', $data);
            $this->load->view('templates/footer');
        } else {
            // Konfigurasi upload
            $config['upload_path'] = './uploads/program/'; // Folder penyimpanan
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = time() . '_' . $_FILES['foto']['name'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];

                $newData = [
                    'judul' => $this->input->post('judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                    'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                    'targetDonasi' => $this->input->post('targetDonasi'),
                    'foto' => $foto, // hanya nama file
                    'status' => 'active'
                ];

                $this->Program_model->createProgramDonasi($newData);
                $this->session->set_flashdata('message', 'Program berhasil ditambahkan!');
                redirect('admin/program');
            } else {
                // Upload gagal
                $data['upload_error'] = $this->upload->display_errors();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('admin/program', $data);
                $this->load->view('templates/footer');
            }
        }
    }


public function edit_program($id)
{
    $data['title'] = 'Edit Program Donasi';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['program'] = $this->Program_model->getProgramById($id);

    if (!$data['program']) {
        show_404();
    }

    $this->form_validation->set_rules('judul', 'Judul', 'required');
    $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
    $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
    $this->form_validation->set_rules('targetDonasi', 'Target Donasi', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/edit_program', $data);
        $this->load->view('templates/footer');
    } else {
        // Konfigurasi upload
        $config['upload_path'] = './uploads/program/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = time() . '_' . $_FILES['foto']['name'];
        $this->load->library('upload', $config);

        // Cek apakah ada file diupload
        if (!empty($_FILES['foto']['name'])) {
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];

                // Hapus gambar lama (jika ada)
                if (!empty($data['program']->foto) && file_exists('./uploads/program/' . $data['program']->foto)) {
                    unlink('./uploads/program/' . $data['program']->foto);
                }
            } else {
                // Jika upload gagal, gunakan gambar lama
                $foto = $data['program']->foto;
            }
        } else {
            // Jika tidak mengupload gambar, tetap pakai gambar lama
            $foto = $data['program']->foto;
        }

        // Update data program
        $updateData = [
            'judul' => $this->input->post('judul'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'targetDonasi' => $this->input->post('targetDonasi'),
            'status' => $this->input->post('status'),
            'foto' => $foto
        ];

        $this->Program_model->updateProgramDonasi($id, $updateData);
        $this->session->set_flashdata('message', 'Program berhasil diperbarui!');
        redirect('admin/program');
    }
}


    public function hapus_program($id) 
    {
    $this->Program_model->deleteProgramDonasi($id);
    $this->session->set_flashdata('message', 'Program berhasil dihapus!');
    redirect('admin/program');
    }

    public function update_program($id_program)
{
    $program = $this->Program_model->getProgramById($id_program);

    if (!$program) {
        $this->session->set_flashdata('message', 'Program tidak ditemukan!');
        redirect('admin/program');
    }

    // Ambil data dasar dari form
    $data = [
        'judul'          => $this->input->post('judul'),
        'deskripsi'      => $this->input->post('deskripsi'),
        'tanggal_mulai'  => $this->input->post('tanggal_mulai'),
        'tanggal_selesai'=> $this->input->post('tanggal_selesai'),
        'targetDonasi'   => $this->input->post('targetDonasi'),
        'status'         => $this->input->post('status')
        // 'foto' tidak diset di sini
    ];

    // Proses upload gambar baru jika ada
    if (!empty($_FILES['foto']['name'])) {
        $config['upload_path']   = './uploads/program/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = time() . '_' . $_FILES['foto']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            $uploadData = $this->upload->data();
            $data['foto'] = $uploadData['file_name'];

            // Hapus gambar lama
            if (!empty($program->foto) && file_exists('./uploads/program/' . $program->foto)) {
                unlink('./uploads/program/' . $program->foto);
            }
        } else {
            $this->session->set_flashdata('message', 'Gagal upload gambar: ' . strip_tags($this->upload->display_errors()));
            redirect('admin/edit_program/' . $id_program);
            return;
        }
    }

    // Simpan perubahan ke database
    $this->Program_model->updateProgram($id_program, $data);

    $this->session->set_flashdata('message', 'Perubahan berhasil disimpan!');
    redirect('admin/program');
}

    public function update_status() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');

    $this->db->where('id', $id);
    $this->db->update('donation', ['status' => $status]);

    // Cek apakah target sudah tercapai
    $this->load->model('Program_model');
    $this->Program_model->updateStatusIfTargetReached();

    redirect('admin/donasi');
}

    // Laporan Penggalangan
   public function laporan()
{
    $data['title'] = 'Laporan Penggalangan Dana';
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    $year = $this->input->get('tahun') ?? date('Y'); // Ambil dari GET atau default tahun ini
    $data['selected_year'] = $year;


    // Data untuk ringkasan
    $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
    $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
    $data['saldo_akhir']     = $data['total_pemasukan'] - $data['total_pencairan'];

    // Dropdown filter tahun
    $data['years'] = $this->Pencairan_model->get_available_years();

    // Data detail laporan (yang belum ditambahkan sebelumnya)
    $data['laporan'] = $this->Donasi_model->getLaporanByTahun($year);

    // Tampilkan view
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/laporan', $data);
    $this->load->view('templates/footer');
}

    public function cetakmsk() {
        $data['title'] = 'Cetak Laporan Pemasukkan';
        
        // Get year from query params
        $year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        $data['laporan'] = $this->Donasi_model->getLaporanByTahun($year);
        $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
        $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
        $data['selected_year'] = $year;
        
        // Get total pemasukan/donasi for comparison
        $this->load->model('Keuangan_model');
        $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
        
        // Calculate saldo akhir
        $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];
        
        $this->load->view('admin/cetakmasuk', $data);
    }


// Pencairan
public function pencairan() {
    $data['title'] = 'Laporan Pencairan Dana';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    // Default tahun adalah tahun sekarang
    $year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
    
    // Load Pencairan_model if not already loaded
    if (!isset($this->Pencairan_model)) {
        $this->load->model('Pencairan_model');
    }
    
    // Get pencairan data
    $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_year($year);
    $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
    $data['years'] = $this->Pencairan_model->get_available_years();
    $data['selected_year'] = $year;
    
    // Get total pemasukan/donasi for comparison
    $this->load->model('Keuangan_model'); 
    $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
    
    // Calculate saldo akhir
    $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];
    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/pencairan', $data);
    $this->load->view('templates/footer');
}

public function tambahpencairan() {
    $data['title'] = 'Tambah Data Pencairan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    // Load models if not already loaded
    if (!isset($this->Program_model)) {
        $this->load->model('Program_model');
    }
    if (!isset($this->Pencairan_model)) {
        $this->load->model('Pencairan_model');
    }
    
    // Load programs for dropdown
    $data['programdonasi'] = $this->Program_model->getAllPrograms();
    
    // Form validation rules
    $this->form_validation->set_rules('program_id', 'Program', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah Pencairan', 'required|numeric');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    
    if ($this->form_validation->run() == FALSE) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tambah_pencairan', $data);
        $this->load->view('templates/footer');
    } else {
        $data = [
            'program_id' => $this->input->post('program_id'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        
        $this->Pencairan_model->add_pencairan($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil ditambahkan!</div>');
        redirect('admin/pencairan');
    }
}

public function tambah()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('program_id', 'Program Donasi', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah Pencairan', 'required|numeric');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

    if ($this->form_validation->run() == FALSE) {
        $data['title'] = 'Tambah Pencairan';
        $data['programdonasi'] = $this->Program_model->getAllPrograms();
        $this->load->view('templates/header', $data);
        $this->load->view('admin/tambah_pencairan', $data);
        $this->load->view('templates/footer');
    } else {
        $data = [
            'program_id' => $this->input->post('program_id'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->Pencairan_model->add_pencairan($data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data pencairan berhasil ditambahkan!</div>');
        redirect('admin/pencairan');
    }
}


    public function hapus($id) {
        // Check if the record exists
        $pencairan = $this->Pencairan_model->get_pencairan_by_id($id);
        
        if (!$pencairan) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
            redirect('admin/pencairan');
        }
        
        // Delete the record
        $this->Pencairan_model->delete_pencairan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil dihapus!</div>');
        redirect('admin/pencairan');
    }
    
    public function edit($id) {
    $data['title'] = 'Edit Data Pencairan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
    // Ambil data pencairan
    $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_id($id);
    if (!$data['pencairan']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
        redirect('admin/pencairan');
    }
    
    // Ambil program
    $this->load->model('Program_model');
    $data['programs'] = $this->Program_model->get_all_programs();
    
    // Validasi
    $this->form_validation->set_rules('program_id', 'Program', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah Pencairan', 'required|numeric');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    
    if ($this->form_validation->run() == FALSE) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/edit_pencairan', $data);
        $this->load->view('templates/footer');
    } else {
        $updateData = [
            'program_id' => $this->input->post('program_id'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];

        $this->Pencairan_model->update_pencairan($id, $updateData);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pencairan berhasil diperbarui!</div>');
        redirect('admin/pencairan');
    }
}



    public function detail($id) {
        $data['title'] = 'Detail Pencairan';
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_detail($id);
        
        if (!$data['pencairan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data pencairan tidak ditemukan!</div>');
            redirect('admin/pencairan');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/detail_pencairan', $data);
        $this->load->view('templates/footer');
    }
    
    public function cetak() {
        $data['title'] = 'Cetak Laporan Pencairan';
        
        // Get year from query params
        $year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        // Get pencairan data
        $data['pencairan'] = $this->Pencairan_model->get_pencairan_by_year($year);
        $data['total_pencairan'] = $this->Pencairan_model->get_total_pencairan($year);
        $data['selected_year'] = $year;
        
        // Get total pemasukan/donasi for comparison
        $this->load->model('Keuangan_model');
        $data['total_pemasukan'] = $this->Keuangan_model->get_total_pemasukan($year);
        
        // Calculate saldo akhir
        $data['saldo_akhir'] = $data['total_pemasukan'] - $data['total_pencairan'];
        
        $this->load->view('admin/cetak', $data);
    }
 


    // My Profile
    public function profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/profile', $data);
        $this->load->view('templates/footer');
    }

    // Logout
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah logout!</div>');
        redirect('auth');
    }
}
