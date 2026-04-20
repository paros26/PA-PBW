<?php

class Gallery extends Controller {
    public function index()
    {
        $data['judul'] = 'Galeri - Jetski Mahakam';
        $data['active'] = 'gallery';
        $data['gallery'] = $this->model('Gallery_model')->getAllGallery();
        $data['extra_scripts'] = ['gallery.js'];
        
        $this->view('templates/header', $data);
        $this->view('gallery/index', $data);
        $this->view('templates/footer', $data);
    }
}
