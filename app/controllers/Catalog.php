<?php

class Catalog extends Controller {
    public function index()
    {
        $data['judul'] = 'Katalog - Jetski Mahakam';
        $data['active'] = 'catalog';
        $data['jetskis'] = $this->model('JetSki_model')->getAllJetSkis();
        
        $this->view('templates/header', $data);
        $this->view('catalog/index', $data);
        $this->view('templates/footer', $data);
    }
}
