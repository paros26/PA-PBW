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
                // Since we are running from public/index.php, the current directory is public/
                $targetPath = 'img/' . $folder . '/';
                
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
        try {
            $image_url = $this->uploadImage($_FILES['image_file'] ?? null, 'jetski');
            $_POST['image_url'] = $image_url ?: 'default-jetski.jpg';
            
            // Pastikan is_available terisi (1 jika dicentang, 0 jika tidak)
            $_POST['is_available'] = isset($_POST['is_available']) ? 1 : 0;
            
            // Nilai default untuk field teknis
            $_POST['brand'] = $_POST['brand'] ?: 'Yamaha';
            $_POST['model'] = $_POST['model'] ?: 'Mahakam Series';
            $_POST['year'] = $_POST['year'] ?: date('Y');

            if ($this->model('JetSki_model')->tambahDataJetSki($_POST) > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan paket rental']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateJetski()
    {
        try {
            $image_url = $this->uploadImage($_FILES['image_file'] ?? null, 'jetski');
            $_POST['image_url'] = $image_url ?: $_POST['existing_image'];
            
            // Pastikan is_available terisi
            $_POST['is_available'] = isset($_POST['is_available']) ? 1 : 0;

            $this->model('JetSki_model')->ubahDataJetSki($_POST);
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

    // User Management
    public function users()
    {
        $users = $this->model('User_model')->getAllUsers();
        echo json_encode($users);
    }

    public function addUser()
    {
        if ($this->model('User_model')->register($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function updateUser()
    {
        if ($this->model('User_model')->ubahDataUser($_POST) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function deleteUser($id)
    {
        if ($this->model('User_model')->hapusDataUser($id) > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
