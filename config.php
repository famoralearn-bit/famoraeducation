<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP tidak ada password
define('DB_NAME', 'math_website');

// Membuat koneksi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Fungsi untuk membersihkan input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Fungsi untuk get Discord link berdasarkan waktu
function get_discord_link() {
    global $conn;
    $current_hour = date('H');
    
    // Jam 16:00 - 19:59 gunakan link jam 16:00
    // Jam 20:00 - 15:59 gunakan link jam 20:00
    if ($current_hour >= 16 && $current_hour < 20) {
        $jam_update = '16:00';
    } else {
        $jam_update = '20:00';
    }
    
    $query = "SELECT link FROM discord_links WHERE jam_update = '$jam_update' LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['link'];
    }
    
    return 'https://discord.gg/default';
}

// Start session
session_start();
?>
