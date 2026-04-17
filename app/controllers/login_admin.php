<?php

class Login_admin extends Controller {
    public function index()
    {
        $data['judul'] = 'Login Admin - Jetski Mahakam';
        $data['active'] = 'login_admin';
        
        $this->view('templates/header', $data);
        $this->view('login_admin/index', $data);
        $this->view('templates/footer', $data);
    }

    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($user = $this->model('User_model')->login($username, $password)) {
            // Validasi Role: Hanya izinkan role 'admin'
            if ($user['role'] !== 'admin') {
                header('Location: ' . BASEURL . '/login_admin?error=unauthorized');
                exit;
            }

            // Set session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['admin'] = $user['id'];
            
            header('Location: ' . BASEURL . '/admin');
            exit;
        } else {
            header('Location: ' . BASEURL . '/login_admin?error=1');
            exit;
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/login_admin');
        exit;
    }
}
