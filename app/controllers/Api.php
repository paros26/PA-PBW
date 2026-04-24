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

    private function validate($data, $rules)
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[] = "Field $field wajib diisi.";
                continue;
            }

            if (strpos($rule, 'numeric') !== false && !is_numeric($value)) {
                $errors[] = "Field $field harus berupa angka.";
            }

            if (strpos($rule, 'phone') !== false && !preg_match('/^[0-9]{10,13}$/', $value)) {
                $errors[] = "Format nomor telepon tidak valid (harus 10-13 digit angka).";
            }

            if (strpos($rule, 'min:') !== false) {
                preg_match('/min:([0-9]+)/', $rule, $matches);
                $min = $matches[1];
                if (strlen($value) < $min) {
                    $errors[] = "Field $field minimal $min karakter.";
                }
            }

            if (strpos($rule, 'max:') !== false) {
                preg_match('/max:([0-9]+)/', $rule, $matches);
                $max = $matches[1];
                if ((int)$value > $max) {
                    $errors[] = "Field $field maksimal $max sesi.";
                }
            }
        }
        return $errors;
    }

    public function addJetski()
    {
        try {
            $rules = [
                'name' => 'required|min:3',
                'price_per_hour' => 'required|numeric',
                'route' => 'required'
            ];
            $errors = $this->validate($_POST, $rules);
            if (!empty($errors)) {
                echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
                return;
            }

            $image_url = $this->uploadImage($_FILES['image_file'] ?? null, 'jetski');
            $_POST['image_url'] = $image_url ?: 'default-jetski.jpg';
            
            // Mengambil nilai is_available dari POST (dikirim sebagai '1' atau '0' dari JS)
            $_POST['is_available'] = isset($_POST['is_available']) ? (int)$_POST['is_available'] : 1;
            
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
            
            // Mengambil nilai is_available dari POST
            $_POST['is_available'] = isset($_POST['is_available']) ? (int)$_POST['is_available'] : 1;

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
        try {
            // Map 'duration' to 'sesi' if 'sesi' is not present (for backward compatibility)
            if (!isset($_POST['sesi']) && isset($_POST['duration'])) {
                $_POST['sesi'] = $_POST['duration'];
            }

            $rules = [
                'customer_name' => 'required|min:3',
                'customer_phone' => 'required|phone',
                'rental_date' => 'required',
                'sesi' => 'required|numeric|max:5'
            ];
            $errors = $this->validate($_POST, $rules);
            if (!empty($errors)) {
                echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
                return;
            }

            $payment_proof = $this->uploadImage($_FILES['payment_proof'] ?? null, 'payments');
            $_POST['payment_proof'] = $payment_proof;
            
            // Konversi total_price ke float untuk keamanan database
            if (isset($_POST['total_price'])) {
                $_POST['total_price'] = (float)$_POST['total_price'];
            }

            $rowCount = $this->model('Rental_model')->tambahDataRental($_POST);
            if ($rowCount > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mencatat penyewaan. Pastikan semua data terisi dengan benar.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    public function updateRental()
    {
        try {
            $payment_proof = $this->uploadImage($_FILES['payment_proof'] ?? null, 'payments');
            $_POST['payment_proof'] = $payment_proof ?: ($_POST['existing_payment_proof'] ?? '');

            // Map 'duration' to 'sesi' if 'sesi' is not present
            if (!isset($_POST['sesi']) && isset($_POST['duration'])) {
                $_POST['sesi'] = $_POST['duration'];
            }

            if ($this->model('Rental_model')->ubahDataRental($_POST) > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah data atau format telepon salah']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
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
