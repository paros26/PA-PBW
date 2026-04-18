-- Create Database
CREATE DATABASE IF NOT EXISTS db_jetski_mahakam;
USE db_jetski_mahakam;

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin'
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
INSERT INTO users (username, password) VALUES ('admin', 'admin123');

INSERT INTO jetskis (name, brand, model, year, price_per_hour, image_url, description, is_available) VALUES
('Yamaha VX Cruiser', 'Yamaha', 'VX Cruiser', 2023, 500000.00, 'https://images.unsplash.com/photo-1768463852096-bf6dfab0f312?w=1080', 'Jet ski premium dengan performa tinggi dan kenyamanan maksimal', TRUE),
('Sea-Doo GTI SE', 'Sea-Doo', 'GTI SE', 2023, 550000.00, 'https://images.unsplash.com/photo-1618858227841-9beacd3b5f6f?w=1080', 'Jet ski modern dengan teknologi canggih untuk pengalaman yang tak terlupakan', TRUE),
('Yamaha GP1800R', 'Yamaha', 'GP1800R', 2024, 600000.00, 'https://images.unsplash.com/photo-1771282136960-345939d9f8d7?w=1080', 'Jet ski racing dengan kecepatan tinggi untuk petualangan ekstrem', TRUE);

INSERT INTO gallery (image_url, caption, upload_date) VALUES
('https://images.unsplash.com/photo-1744288956623-d4e32d685562?w=1080', 'Penyewaan jet ski di pantai Mahakam', '2024-01-15'),
('https://images.unsplash.com/photo-1769057266279-f2083dc330de?w=1080', 'Petualangan seru bersama keluarga', '2024-02-20'),
('https://images.unsplash.com/photo-1759661324054-cfd24f2d47c2?w=1080', 'Nikmati keindahan pantai tropis', '2024-03-07');
