<?php

class Home extends Controller {
    public function index()
    {
        $data['judul'] = 'Jetski Mahakam - Beranda';
        $data['active'] = 'index';
        $data['extra_scripts'] = ['weather.js'];
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer', $data);
    }
}
