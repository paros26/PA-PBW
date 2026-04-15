<?php

class Home extends Controller {
    public function index()
    {
        $data['judul'] = 'Jetski Mahakam - Beranda';
        $data['active'] = 'index';
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer', $data);
    }
}
