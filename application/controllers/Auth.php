<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session', 'email']);
        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
       

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = htmlspecialchars($this->input->post('email', true));
        $password = htmlspecialchars($this->input->post('password', true));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    redirect($user['role_id'] == 1 ? 'admin' : 'user');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">This email has not been activated!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered!</div>');
        }
        redirect('auth');
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Register';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = htmlspecialchars($this->input->post('email', true));
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => $email,
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            $token = base64_encode(openssl_random_pseudo_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            if ($this->_sendEmail($token, 'verify', $email)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">Your account has been created. Please check your email to activate your account.</div>');
            }
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type, $email)
{
    $config = [
        'protocol' => 'smtp',
        'smtp_host' =>  'smtp.gmail.com',
        'smtp_user' => 'zahhhh0606@gmail.com',
        'smtp_pass' => 'irqdztiekvpfiayg', // App password Gmail
        'smtp_port' => 465,
        'smtp_crypto' => 'ssl',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n", 
        'crlf'      => "\r\n",
    ];

    $this->email->initialize($config);
    $this->email->from('zahhhh0606@gmail.com', 'Zahrah');
    $this->email->to($email);

    if ($type == 'verify') {
        $this->email->subject('Account Verification');
        $this->email->message('Klik link ini untuk mengaktivasi akun Anda: 
            <a href="' . base_url('auth/verify?email=' . $email . '&token=' . urlencode($token)) . '">Aktivasi</a>');
    } elseif ($type == 'forgot') {
        $this->email->subject('Reset Password');
        $this->email->message('Klik link ini untuk mereset password Anda: 
            <a href="' . base_url('auth/resetpassword?email=' . $email . '&token=' . urlencode($token)) . '">Reset Password</a>');
    }

    if (!$this->email->send()) {
        $error = $this->email->print_debugger(['headers']);
        log_message('error', 'Email sending failed: ' . $error);
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal mengirim email. <pre>' . $error . '</pre></div>');
        return false;
    } else {
        return true;
    }
}

public function verify()
{
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
        $user_token = $this->db->get_where('user_token', [
            'email' => $email,
            'token' => $token
        ])->row_array();

        if ($user_token) {
            // Periksa apakah token masih berlaku (dalam 24 jam)
            if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                $this->db->set('is_active', 1);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->db->delete('user_token', ['email' => $email]);

                $this->session->set_flashdata('message', '<div class="alert alert-success">Akun berhasil diaktivasi. Silakan login!</div>');
                redirect('auth');
            } else {
                // Token expired
                $this->db->delete('user', ['email' => $email]);
                $this->db->delete('user_token', ['email' => $email]);

                $this->session->set_flashdata('message', '<div class="alert alert-danger">Token expired! Silakan registrasi ulang.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Token tidak valid!</div>');
            redirect('auth');
        }
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Email tidak ditemukan!</div>');
        redirect('auth');
    }
}


    public function logout()
    {
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('image');
        $this->session->set_flashdata('message', '<div class="alert alert-success">You have successfully logged out!</div>');
        redirect('home/index');
    }

    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(openssl_random_pseudo_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot', $email);

                $this->session->set_flashdata('message', '<div class="alert alert-success">Check your email to reset your password!</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered or not activated!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

       public function resetpassword()
{
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
        $user_token = $this->db->get_where('user_token', ['email' => $email, 'token' => $token])->row_array();

        if ($user_token) {
            $this->session->set_userdata('reset_email', $email);
            redirect('auth/changepassword');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Invalid token.</div>');
            redirect('auth');
        }
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Email not found.</div>');
        redirect('auth');
    }
}


    public function changePassword()
    {

        if(!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

            $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
            $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');
            if($this->form_validation->run() == false){
                $data['title'] = 'Change Password';
                $this->load->view('templates/auth_header', $data);
                $this->load->view('auth/change-password');
                $this->load->view('templates/auth_footer');
            } else{
                $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
                $email = $this->session->userdata('reset_email');

                $this->db->set('password', $password);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->session->unset_userdata('reset_email');

                $this->session->set_flashdata('message', '<div class="alert alert-success">Password has been changed! Please login.</div>');
                redirect('auth');
            }
          
    }

}