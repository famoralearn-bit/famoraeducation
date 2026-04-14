<?php
// =============================================
//  MathLearn - Konfigurasi Database
// =============================================

define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASS', ''); // Default XAMPP kosong 
define('DB_NAME', 'math_website');
define('GEMINI_API_KEY', 'AIzaSyDJMMOJ9Rzmzi6razXIDIEJA9-n7tQrQa4');
define('GEMINI_MODEL', getenv('GEMINI_MODEL') ?: 'gemini-2.5-flash-lite');

// Koneksi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ---- Helper Functions ----

function clean_input($data) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(stripslashes(trim($data))));
}

function update_last_seen($user_id) {
    global $conn;
    $conn->query("UPDATE users SET last_seen = NOW() WHERE id = " . intval($user_id));
}

function is_user_online($last_seen) {
    if (!$last_seen) return false;
    return (time() - strtotime($last_seen)) < 180; // 3 menit
}

function get_discord_link() {
    global $conn;
    $jam = (date('H') >= 16 && date('H') < 20) ? '16:00' : '20:00';
    $result = $conn->query("SELECT link FROM discord_links WHERE jam_update = '$jam' LIMIT 1");
    if ($result && $result->num_rows > 0) return $result->fetch_assoc()['link'];
    return 'https://discord.gg/default';
}

function get_gemini_api_key() {
    return defined('GEMINI_API_KEY') ? GEMINI_API_KEY : '';
}

function get_gemini_model() {
    return defined('GEMINI_MODEL') && GEMINI_MODEL ? GEMINI_MODEL : 'gemini-2.5-flash';
}

// Start session
session_start();
?>
