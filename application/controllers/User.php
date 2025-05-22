<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('session');
        $this->load->model('Donation_model');
        $this->load->model('Donasi_model');
        $this->load->model('Keuangan_model');
        $this->load->model('Pencairan_model');
        $this->load->model('Program_model');
        $this->load->model('Admin_model');
        $this->load->library(['form_validation', 'upload']);
    }

    // DASHBOARD
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

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


    public function get_donasi_growth()
{
    // Pastikan ini hanya diakses via AJAX
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    // Load model
    $this->load->model('Donasi_model');
    $donatur_data = $this->Donasi_model->get_monthly_transaction_growth();

    // Kirim JSON ke JS
    header('Content-Type: application/json');
    echo json_encode($donatur_data);
}



    public function get_distribusi_dana()
{
    // Pastikan request ini hanya bisa diakses via AJAX
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Ambil data dari model
    $this->load->model('Program_model');
    $distribusi_data = $this->Program_model->get_distribusi_dana();
    
    // Return data dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($distribusi_data);
    exit;
}

    // HALAMAN DONASI
    public function donasi()
    {
    $this->load->helper('text'); // Helper text untuk word_limiter

    $data['title'] = 'Donasi';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
    $data['programdonasi'] = $this->Donasi_model->get_all_program(); // Ambil semua program donasi
    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/donasi', $data);
    $this->load->view('templates/footer');
}

public function donasi_detail($id_program)
{
    $data['title'] = 'Donasi';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Donasi_model');

    // Ambil detail program berdasarkan ID
    $data['program'] = $this->Donasi_model->program_by_id($id_program);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/donasi_detail', $data);
    $this->load->view('templates/footer');
}

  // User.php (controller)
   public function donation($id_program){
   
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->model('Program_model');
    $program = $this->Program_model->get_program_by_id($id_program);

    if (!$program) {
        show_error('Program tidak ditemukan');
    }

    $data['program'] = $program;
    $data['program_id'] = $id_program;

    $this->load->view('user/donation', $data);
}


    public function donasi_action()
{
    // Ambil user dari session email
    $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    if (!$user) {
        $this->session->set_flashdata('error', 'User tidak ditemukan. Silakan login kembali.');
        redirect('auth/login'); // ganti sesuai rute login kamu
        return;
    }

    $program_id = $this->input->post('program_id');
    $nominal = $this->input->post('nominal') ?: $this->input->post('nominal_custom');
    $metode = $this->input->post('metodePembayaran');
    $tanggal = date('Y-m-d');

    // Konfigurasi upload bukti pembayaran
    $config['upload_path']   = FCPATH . '/uploads/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size']      = 5120;

    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('buktiPembayaran')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect('user/donation/' . $program_id);
    } else {
        $upload_data = $this->upload->data();
        $bukti = $upload_data['file_name'];

        // Simpan data donasi
        $data = [
            'user_id' => $user['id'], // <- diperbaiki di sini
            'program_id' => $program_id,
            'nominal' => $nominal,
            'metodePembayaran' => $metode,
            'buktiPembayaran' => $bukti,
            'tanggal' => $tanggal,
            'status' => 'Pending'
        ];

        $this->db->insert('donation', $data);
        $insert_id = $this->db->insert_id(); // Ambil ID donasi terakhir yang baru disimpan

        // Simpan ID ke session untuk ditampilkan di halaman terima kasih
        $this->session->set_userdata('last_donation_id', $insert_id);
        $this->session->set_flashdata('success', 'Donasi berhasil dikirim.');

        redirect('user/terimakasih');
    }
}


    /**
     * Callback for file upload validation
     * 
     * @param string $str
     * @return bool
     */
    public function file_check($str) {
        // Validasi file upload
        if (empty($_FILES['bukti']['name'])) {
            $this->form_validation->set_message('file_check', 'Bukti pembayaran wajib diupload.');
            return FALSE;
        }

        $allowed_mime_type_arr = ['image/jpeg', 'image/png', 'image/jpg'];
        $mime = get_mime_by_extension($_FILES['bukti']['name']);
        if (in_array($mime, $allowed_mime_type_arr)) {
            // Check file size
            if ($_FILES['bukti']['size'] > 5 * 1024 * 1024) { // 5MB in bytes
                $this->form_validation->set_message('file_check', 'Ukuran file maksimal 5MB.');
                return FALSE;
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('file_check', 'Silakan pilih file dengan format jpg/png.');
            return FALSE;
        }
    }

    public function terimakasih()
{
    $donation_id = $this->session->userdata('last_donation_id');
    
    if (!$donation_id) {
        redirect('user/donasi'); // atau arahkan ke halaman lain
    }

    $this->load->model('Donasi_model');
    $data['donasi'] = $this->Donasi_model->get_terima($donation_id);

    $data['metode'] = [
        '1' => 'QRIS',
        '2' => 'Transfer Bank',
    ];

    $this->load->view('user/terimakasih', $data);
}




    // RIWAYAT DONASI
    public function riwayat_donasi(){

        $data['title'] = 'Riwayat Donasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $this->session->userdata('user_id');
            $user_id = $data['user']['id'] ?? null;
        if (!$user_id) {
            show_error('User tidak ditemukan atau belum login', 403);
            return;
        }
        $this->load->model('Donasi_model');
        $data['riwayat'] = $this->Donasi_model->get_donasi_by_user($user_id);

        // Load tampilan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/riwayat_donasi', $data);
        $this->load->view('templates/footer');
    }


    // KONFIRMASI DONASI OLEH ADMIN
    public function konfirmasi_donasi($id)
    {
        if (!$this->Donasi_model->get_donasi_by_id($id)) {
            show_404();
        }

        $data = ['status' => 'verified'];
        $this->Donasi_model->update_donasi($id, $data);

        $this->session->set_flashdata('success', 'Donasi telah dikonfirmasi.');
        redirect('admin/donasi');
    }

    // My Profile
    public function profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

public function editprofile()
{
    $data['title'] = 'Edit Profile';
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

    if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/editprofile', $data);
        $this->load->view('templates/footer');
    } else {
        $name = htmlspecialchars($this->input->post('name', true));
        $email = $this->session->userdata('email');

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['upload_path'] = './assets/img/profile/';
            $config['encrypt_name'] = TRUE; // Hindari overwrite file

            $this->load->library('upload');
            $this->upload->initialize($config); // <- PENTING!

            if ($this->upload->do_upload('image')) {
                $old_image = $data['user']['image'];
                if ($old_image && $old_image != 'default.jpg') {
                    $old_image_path = FCPATH . 'assets/img/profile/' . $old_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $error . '</div>');
                redirect('user/editprofile');
                return;
            }
        }

        $this->db->set('name', $name);
        $this->db->where('email', $email);
        $this->db->update('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
        redirect('user/profile');
    }
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
