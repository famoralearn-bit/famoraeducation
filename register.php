<?php
require_once 'config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

// Data kabupaten
$kabupaten_list = [
    'Cikarang', 'Tambun', 'Babelan', 'Bojongmangu', 'Cibarusah', 
    'Cibitung', 'Karangbahagia', 'Kedungwaringin', 'Muaragembong', 
    'Pebayuran', 'Serang Baru', 'Setu', 'Sukaraya', 'Sukatani', 
    'Sukawangi', 'Tambelang', 'Tarumajaya', 'Cabangbungin'
];

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = clean_input($_POST['nisn']);
    $nama = clean_input($_POST['nama']);
    $email = clean_input($_POST['email']);
    $kelas = clean_input($_POST['kelas']);
    $kabupaten = clean_input($_POST['kabupaten']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    if (strlen($nisn) != 10) {
        $error = 'NISN harus 10 digit!';
    } elseif ($password != $confirm_password) {
        $error = 'Password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Cek apakah NISN atau email sudah ada
        $check_query = "SELECT * FROM users WHERE nisn = '$nisn' OR email = '$email'";
        $check_result = $conn->query($check_query);
        
        if ($check_result && $check_result->num_rows > 0) {
            $error = 'NISN atau Email sudah terdaftar!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $insert_query = "INSERT INTO users (nisn, nama, email, password, kelas, kabupaten) 
                           VALUES ('$nisn', '$nama', '$email', '$hashed_password', '$kelas', '$kabupaten')";
            
            if ($conn->query($insert_query)) {
                $success = 'Registrasi berhasil! Silakan login.';
            } else {
                $error = 'Terjadi kesalahan. Silakan coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MathLearn</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Crimson+Pro:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2D3250;
            --secondary: #424769;
            --accent: #7077A1;
            --light: #F6B17A;
            --bg: #1a1d2e;
            --text: #e8e9f3;
        }

        /* Light Mode Variables */
        [data-theme="light"] {
            --primary: #f5f7fa;
            --secondary: #ffffff;
            --accent: #5a67d8;
            --light: #ed8936;
            --bg: #edf2f7;
            --text: #2d3748;
            --border: #cbd5e0;
            --card-bg: #ffffff;
            --input-bg: #f7fafc;
            --float-color: rgba(237, 137, 54, 0.1);
        }

        /* Dark Mode Variables */
        [data-theme="dark"] {
            --primary: #2D3250;
            --secondary: #424769;
            --accent: #7077A1;
            --light: #F6B17A;
            --bg: #1a1d2e;
            --text: #e8e9f3;
            --border: rgba(255, 255, 255, 0.1);
            --card-bg: rgba(45, 50, 80, 0.7);
            --input-bg: rgba(26, 29, 46, 0.6);
            --float-color: rgba(240, 177, 122, 0.1);
        }

        body {
            font-family: 'Crimson Pro', serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--primary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--float-color) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(20px, 30px) rotate(270deg); }
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 50px;
            padding: 10px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-family: 'Space Mono', monospace;
            font-size: 0.9em;
            color: var(--text);
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .theme-toggle:hover {
            border-color: var(--light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .theme-toggle .icon {
            font-size: 1.2em;
        }

        .container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px 40px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo h1 {
            font-family: 'Space Mono', monospace;
            font-size: 2.2em;
            font-weight: 700;
            color: var(--light);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: -2px;
        }

        .logo p {
            color: var(--accent);
            margin-top: 8px;
            font-size: 1em;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light);
            font-weight: 600;
            font-size: 0.9em;
            letter-spacing: 1px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 0.95em;
            font-family: 'Crimson Pro', serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--light);
            box-shadow: 0 0 0 4px rgba(246, 177, 122, 0.1);
        }

        .form-group select {
            cursor: pointer;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1em;
            font-weight: 700;
            font-family: 'Space Mono', monospace;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
            box-shadow: 0 8px 20px rgba(246, 177, 122, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(246, 177, 122, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
            margin-top: 15px;
        }

        .btn-secondary:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .error {
            background: rgba(255, 82, 82, 0.2);
            border: 1px solid rgba(255, 82, 82, 0.5);
            color: #ef4444;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9em;
            text-align: center;
        }

        .success {
            background: rgba(82, 255, 168, 0.2);
            border: 1px solid rgba(82, 255, 168, 0.5);
            color: #10b981;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9em;
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.95em;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: var(--light);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body data-theme="dark">
    <button class="theme-toggle" onclick="toggleTheme()">
        <span class="icon" id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="container">
        <div class="logo">
            <h1>MathLearn</h1>
            <p>DAFTAR AKUN BARU</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nisn">NISN (10 digit)</label>
                <input type="text" id="nisn" name="nisn" required placeholder="1234567890" maxlength="10" pattern="[0-9]{10}">
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required placeholder="Nama Anda">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="email@example.com">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select id="kelas" name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kabupaten">Kabupaten</label>
                    <select id="kabupaten" name="kabupaten" required>
                        <option value="">Pilih Kabupaten</option>
                        <?php foreach ($kabupaten_list as $kab): ?>
                            <option value="<?php echo $kab; ?>"><?php echo $kab; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" minlength="6">
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password">
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>

        <div class="back-link">
            <a href="index.php">← Sudah punya akun? Login di sini</a>
        </div>
    </div>

    <script>
        // Theme Toggle Function
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            const currentTheme = body.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                body.setAttribute('data-theme', 'light');
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            body.setAttribute('data-theme', savedTheme);
            
            if (savedTheme === 'light') {
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light';
            } else {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
            }
        });
    </script>
</body>
</html>
