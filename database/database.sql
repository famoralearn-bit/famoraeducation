-- =============================================
--  MathLearn - Database Schema
--  Jalankan di phpMyAdmin atau MySQL CLI
-- =============================================

CREATE DATABASE IF NOT EXISTS math_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE math_website;

-- Tabel users (tanpa NISN, dengan kecamatan)
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) UNIQUE NOT NULL,
    password    VARCHAR(255) NOT NULL,
    kelas       ENUM('X','XI','XII') NOT NULL,
    kecamatan   VARCHAR(60) NOT NULL DEFAULT '',
    last_seen   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel Discord link (update otomatis jam 16:00 & 20:00)
CREATE TABLE IF NOT EXISTS discord_links (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    link         VARCHAR(255) NOT NULL,
    jam_update   ENUM('16:00','20:00') NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO discord_links (link, jam_update) VALUES
    ('https://discord.gg/link-sore', '16:00'),
    ('https://discord.gg/link-malam','20:00')
ON DUPLICATE KEY UPDATE link = VALUES(link);

-- Tabel riwayat login
CREATE TABLE IF NOT EXISTS login_history (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================
--  Upgrade dari database lama (jika ada):
--  ALTER TABLE users DROP COLUMN IF EXISTS nisn;
--  ALTER TABLE users ADD COLUMN IF NOT EXISTS kecamatan VARCHAR(60) NOT NULL DEFAULT '';
--  ALTER TABLE users ADD COLUMN IF NOT EXISTS last_seen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
-- =============================================
