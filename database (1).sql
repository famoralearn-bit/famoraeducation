-- Database untuk Website Matematika
-- Jalankan script ini di phpMyAdmin atau MySQL

CREATE DATABASE IF NOT EXISTS math_website;
USE math_website;

-- Tabel untuk user/siswa
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nisn VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    kelas ENUM('X', 'XI', 'XII') NOT NULL,
    kabupaten VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk Discord link (untuk update otomatis)
CREATE TABLE IF NOT EXISTS discord_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255) NOT NULL,
    jam_update ENUM('16:00', '20:00') NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default Discord links
INSERT INTO discord_links (link, jam_update) VALUES 
('https://discord.gg/default1', '16:00'),
('https://discord.gg/default2', '20:00');

-- Tabel untuk tracking login
CREATE TABLE IF NOT EXISTS login_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
