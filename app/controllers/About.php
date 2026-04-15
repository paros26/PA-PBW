<?php

class About extends Controller {
    public function index()
    {
        $data['judul'] = 'Tentang Kami - Jetski Mahakam';
        $data['active'] = 'about';
        
        $this->view('templates/header', $data);
        $this->view('about/index', $data);
        $this->view('templates/footer', $data);
    }
}
