<?php

class Api extends Controller {
    public function jetskis()
    {
        $jetskis = $this->model('JetSki_model')->getAllJetSkis();
        echo json_encode($jetskis);
    }

    private function uploadImage($file, $folder)
    {
        if (isset($file) && $file['error'] === 0) {
            $namaFile = $file['name'];
            $tmpName = $file['tmp_name'];

            $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));

            if (in_array($ekstensiGambar, $ekstensiGambarValid)) {
                $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
                $targetPath = '../public/img/' . $folder . '/';
                
                if (!file_exists($targetPath)) {
                    mkdir($targetPath, 0777, true);
                }

                if (move_uploaded_file($tmpName, $targetPath . $namaFileBaru)) {
                    return $namaFileBaru;
                }
            }
        }
        return null;
    }

    public function addJetski()
    {
        $image_url = $this->uploadImage($_FILES['image_file'] ?? null, 'jetski');
        $_POST['image_url'] = $image_url ?: 'default-jetski.jpg';

        if ($this->model('JetSki_model')->tambahDataJetSki($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function updateJetski()
    {
        $image_url = $this->uploadImage($_FILES['image_file'] ?? null, 'jetski');
        $_POST['image_url'] = $image_url ?: $_POST['existing_image'];

        try {
            $this->model('JetSki_model')->ubahDataJetSki($_POST);
            // In PDO, if data is identical, rowCount is 0, but it's not an error.
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteJetski($id)
    {
        if ($this->model('JetSki_model')->hapusDataJetSki($id) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function rentals()
    {
        $rentals = $this->model('Rental_model')->getAllRentals();
        echo json_encode($rentals);
    }

    public function addRental()
    {
        $payment_proof = $this->uploadImage($_FILES['payment_proof'] ?? null, 'payments');
        $_POST['payment_proof'] = $payment_proof;

        if ($this->model('Rental_model')->tambahDataRental($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambah data atau format telepon salah (hanya angka)']);
        }
    }

    public function updateRental()
    {
        $payment_proof = $this->uploadImage($_FILES['payment_proof'] ?? null, 'payments');
        $_POST['payment_proof'] = $payment_proof ?: ($_POST['existing_payment_proof'] ?? '');

        if ($this->model('Rental_model')->ubahDataRental($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah data atau format telepon salah']);
        }
    }

    public function deleteRental($id)
    {
        if ($this->model('Rental_model')->hapusDataRental($id) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function gallery()
    {
        $gallery = $this->model('Gallery_model')->getAllGallery();
        echo json_encode($gallery);
    }

    public function addGallery()
    {
        $image_url = $this->uploadImage($_FILES['gallery_file'] ?? null, 'gallery');
        $_POST['image_url'] = $image_url ?: 'default-gallery.jpg';

        if ($this->model('Gallery_model')->tambahDataGallery($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function updateGallery()
    {
        $image_url = $this->uploadImage($_FILES['gallery_file'] ?? null, 'gallery');
        $_POST['image_url'] = $image_url ?: ($_POST['existing_image'] ?? '');

        if ($this->model('Gallery_model')->ubahDataGallery($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function deleteGallery($id)
    {
        if ($this->model('Gallery_model')->hapusDataGallery($id) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
