-- ==========================================================
-- DATABASE: db_jetski_mahakam
-- Sesuai dengan fitur Admin (CRUD) dan Pengguna
-- ==========================================================

CREATE DATABASE IF NOT EXISTS db_jetski_mahakam;
USE db_jetski_mahakam;

-- 1. Tabel users (Untuk Login Admin & Pelanggan)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel jetskis (Sekarang: Paket Rental)
CREATE TABLE IF NOT EXISTS jetskis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(50) DEFAULT 'Yamaha',
    model VARCHAR(50) DEFAULT 'Mahakam Series',
    year INT DEFAULT 2024,
    rider_type ENUM('single', 'couple') NOT NULL,
    route VARCHAR(255) NOT NULL,
    price_per_hour DECIMAL(15, 2) NOT NULL,
    image_url TEXT NOT NULL,
    description TEXT,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel rentals (Transaksi Sewa)
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jetski_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    rental_date DATE NOT NULL,
    duration INT NOT NULL, -- Dalam sesi/jam
    total_price DECIMAL(15, 2) NOT NULL,
    token VARCHAR(20) DEFAULT NULL,
    payment_proof VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'completed', 'cancelled', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jetski_id) REFERENCES jetskis(id) ON DELETE SET NULL
);

-- 4. Tabel gallery (Dokumentasi Pantai Mahakam)
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url TEXT NOT NULL,
    caption VARCHAR(255) NOT NULL,
    upload_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================================
-- DATA AWAL (SEEDING) - Untuk Percobaan Fitur
-- ==========================================================

-- Data Admin (Password: admin123)
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Data Paket Rental
INSERT INTO jetskis (name, rider_type, route, price_per_hour, image_url, description, is_available) VALUES
('Paket Wisata Jembatan Mahakam', 'single', 'Dermaga - Jembatan Mahakam IV (PP)', 350000.00, '69da81e4e7101.jpg', 'Nikmati pemandangan ikonik Jembatan Mahakam dari tengah sungai.', TRUE),
('Paket Couple Romantis', 'couple', 'Susur Sungai Mahakam - Samarinda Seberang', 600000.00, '69da81e4e7101.jpg', 'Sempurna untuk pasangan yang ingin menikmati sunset di Sungai Mahakam.', TRUE),
('Paket Extreme Mahakam', 'single', 'Dermaga - Jembatan Mahakam - Karang Asam', 500000.00, '69da81e4e7101.jpg', 'Rute lebih panjang dengan tantangan arus sungai yang seru.', TRUE);

-- Data Gallery
INSERT INTO gallery (image_url, caption, upload_date) VALUES
('69da826e79952.png', 'Kegiatan rental jetski di hari minggu', CURDATE()),
('69da826e79952.png', 'Suasana sunset Sungai Mahakam', CURDATE());

-- Data Transaksi Contoh (Untuk Laporan Income)
INSERT INTO rentals (jetski_id, customer_name, customer_phone, rental_date, duration, total_price, status) VALUES
(1, 'Artha Pelanggan', '08123456789', CURDATE(), 2, 700000.00, 'completed'),
(2, 'Budi Samarinda', '08987654321', CURDATE(), 1, 600000.00, 'active');
