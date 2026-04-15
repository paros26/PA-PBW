<?php

class Login extends Controller {
    public function index()
    {
        $data['judul'] = 'Login Admin - Jetski Mahakam';
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
            $_SESSION['admin'] = $user['id'];
            header('Location: ' . BASEURL . '/admin');
            exit;
        } else {
            // Flash message? (simple version)
            header('Location: ' . BASEURL . '/login?error=1');
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
