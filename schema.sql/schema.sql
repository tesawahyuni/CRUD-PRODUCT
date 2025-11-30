-- ============================================================
-- Schema Database untuk Aplikasi CRUD Produk
-- ============================================================

CREATE DATABASE IF NOT EXISTS crud;
USE crud;

-- ============================================================
-- Tabel utama: products
-- ============================================================

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
);
 

 