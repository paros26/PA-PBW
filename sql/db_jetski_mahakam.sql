-- Create Database
CREATE DATABASE IF NOT EXISTS db_jetski_mahakam;
USE db_jetski_mahakam;

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);

-- Table jetskis
CREATE TABLE IF NOT EXISTS jetskis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    rider_type VARCHAR(50),
    route VARCHAR(100),
    price_per_hour DECIMAL(15, 2) NOT NULL,
    image_url TEXT NOT NULL,
    description TEXT,
    is_available BOOLEAN DEFAULT TRUE
);

-- Table rentals
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jetski_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    rental_date DATE NOT NULL,
    duration INT NOT NULL,
    total_price DECIMAL(15, 2) NOT NULL,
    payment_proof VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'completed', 'cancelled', 'deleted') DEFAULT 'active',
    FOREIGN KEY (jetski_id) REFERENCES jetskis(id)
);

-- Table gallery
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url TEXT NOT NULL,
    caption VARCHAR(255) NOT NULL,
    upload_date DATE NOT NULL
);

-- Seed Initial Data
-- Password: admin123 (hashed)
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$8.Xm9U.686566456789012345678901234567890123456789012', 'admin');

INSERT INTO jetskis (name, brand, model, year, rider_type, route, price_per_hour, image_url, description, is_available) VALUES
('Yamaha VX Cruiser', 'Yamaha', 'VX Cruiser', 2023, 'single', 'Jembatan Mahakam', 500000.00, '69da81e4e7101.jpg', 'Jet ski premium dengan performa tinggi dan kenyamanan maksimal', TRUE),
('Sea-Doo GTI SE', 'Sea-Doo', 'GTI SE', 2023, 'couple', 'Samarinda Seberang', 550000.00, '69da81e4e7101.jpg', 'Jet ski modern dengan teknologi canggih untuk pengalaman yang tak terlupakan', TRUE);

INSERT INTO gallery (image_url, caption, upload_date) VALUES
('69da826e79952.png', 'Penyewaan jet ski di pantai Mahakam', '2024-01-15'),
('69da826e79952.png', 'Petualangan seru bersama keluarga', '2024-02-20');
