<?php

class Login extends Controller {
    public function index()
    {
        $data['judul'] = 'Login Pengguna - Jetski Mahakam';
        $data['active'] = 'login';
        
        $this->view('templates/header', $data);
        $this->view('login/index', $data);
        $this->view('templates/footer', $data);
    }

    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($user = $this->model('User_model')->login($username, $password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                $_SESSION['admin'] = $user['id'];
                header('Location: ' . BASEURL . '/admin');
            } else {
                header('Location: ' . BASEURL);
            }
            exit;
        } else {
            header('Location: ' . BASEURL . '/login?error=1');
            exit;
        }
    }

    public function register()
    {
        $data['judul'] = 'Daftar Akun - Jetski Mahakam';
        $data['active'] = 'login';
        
        $this->view('templates/header', $data);
        $this->view('login/register', $data);
        $this->view('templates/footer', $data);
    }

    public function processRegister()
    {
        if ($this->model('User_model')->cekUsername($_POST['username'])) {
            header('Location: ' . BASEURL . '/login/register?error=username_exists');
            exit;
        }

        if ($this->model('User_model')->register($_POST) > 0) {
            header('Location: ' . BASEURL . '/login?success=registered');
            exit;
        } else {
            header('Location: ' . BASEURL . '/login/register?error=failed');
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}
