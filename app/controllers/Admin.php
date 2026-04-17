<?php

class Admin extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: ' . BASEURL . '/login_admin');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard Admin - Jetski Mahakam';
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('templates/admin_footer', $data);
    }
}
