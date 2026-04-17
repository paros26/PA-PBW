<?php

class User_login extends Controller {
    public function index()
    {
        $data['judul'] = 'Login Pelanggan - Jetski Mahakam';
        $data['active'] = 'user_login';
        
        $this->view('templates/header', $data);
        $this->view('user_login/index', $data);
        $this->view('templates/footer', $data);
    }

    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($user = $this->model('User_model')->login($username, $password)) {
            // Validasi Role: Hanya izinkan role 'user'
            if ($user['role'] !== 'user') {
                header('Location: ' . BASEURL . '/user_login?error=unauthorized');
                exit;
            }

            // Simpan data ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user'] = $user['id'];
            
            header('Location: ' . BASEURL . '/catalog');
            exit;
        } else {
            header('Location: ' . BASEURL . '/user_login?error=1');
            exit;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['user_name']);
        header('Location: ' . BASEURL . '/user_login');
        exit;
    }
}
