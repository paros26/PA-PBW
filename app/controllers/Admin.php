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
        
        // Load data for the dashboard
        $data['jetskis'] = $this->model('JetSki_model')->getAllJetSkis();
        $data['rentals'] = $this->model('Rental_model')->getAllRentals();
        $data['gallery'] = $this->model('Gallery_model')->getAllGallery();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('templates/admin_footer', $data);
    }

    // JetSki Management
    public function tambahJetSki()
    {
        if ($this->model('JetSki_model')->tambahDataJetSki($_POST) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function hapusJetSki($id)
    {
        if ($this->model('JetSki_model')->hapusDataJetSki($id) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function getubahJetSki()
    {
        echo json_encode($this->model('JetSki_model')->getJetSkiById($_POST['id']));
    }

    public function ubahJetSki()
    {
        if ($this->model('JetSki_model')->ubahDataJetSki($_POST) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    // Rental Management
    public function tambahRental()
    {
        if ($this->model('Rental_model')->tambahDataRental($_POST) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function hapusRental($id)
    {
        if ($this->model('Rental_model')->hapusDataRental($id) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function getubahRental()
    {
        echo json_encode($this->model('Rental_model')->getRentalById($_POST['id']));
    }

    public function ubahRental()
    {
        if ($this->model('Rental_model')->ubahDataRental($_POST) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    // Gallery Management
    public function tambahGallery()
    {
        if ($this->model('Gallery_model')->tambahDataGallery($_POST) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function hapusGallery($id)
    {
        if ($this->model('Gallery_model')->hapusDataGallery($id) > 0) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }
}
