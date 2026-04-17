<?php

class Register extends Controller {
    public function index()
    {
        $data['judul'] = 'Daftar Akun - Jetski Mahakam';
        $data['active'] = 'user_login';
        
        $this->view('templates/header', $data);
        $this->view('register/index', $data);
        $this->view('templates/footer', $data);
    }

    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi password cocok
        if ($password !== $confirm_password) {
            header('Location: ' . BASEURL . '/register?error=password');
            exit;
        }

        // Cek apakah username sudah ada
        if ($this->model('User_model')->checkUsername($username)) {
            header('Location: ' . BASEURL . '/register?error=exists');
            exit;
        }

        // Proses registrasi
        if ($this->model('User_model')->register($_POST) > 0) {
            header('Location: ' . BASEURL . '/user_login?registered=1');
            exit;
        } else {
            header('Location: ' . BASEURL . '/register?error=failed');
            exit;
        }
    }
}
