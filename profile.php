<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

$success = '';
$error = '';

// Update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nama = clean_input($_POST['nama']);
    $email = clean_input($_POST['email']);
    $kelas = clean_input($_POST['kelas']);
    $kabupaten = clean_input($_POST['kabupaten']);
    
    $update_query = "UPDATE users SET nama = '$nama', email = '$email', kelas = '$kelas', kabupaten = '$kabupaten' WHERE id = $user_id";
    
    if ($conn->query($update_query)) {
        $_SESSION['nama'] = $nama;
        $_SESSION['kelas'] = $kelas;
        $_SESSION['kabupaten'] = $kabupaten;
        $success = 'Profil berhasil diupdate!';
        
        // Refresh data
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
    } else {
        $error = 'Gagal update profil!';
    }
}

// Ganti password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (password_verify($old_password, $user['password'])) {
        if ($new_password == $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $conn->query("UPDATE users SET password = '$hashed' WHERE id = $user_id");
                $success = 'Password berhasil diubah!';
            } else {
                $error = 'Password minimal 6 karakter!';
            }
        } else {
            $error = 'Password baru tidak cocok!';
        }
    } else {
        $error = 'Password lama salah!';
    }
}

$kabupaten_list = [
    'Cikarang', 'Tambun', 'Babelan', 'Bojongmangu', 'Cibarusah', 
    'Cibitung', 'Karangbahagia', 'Kedungwaringin', 'Muaragembong', 
    'Pebayuran', 'Serang Baru', 'Setu', 'Sukaraya', 'Sukatani', 
    'Sukawangi', 'Tambelang', 'Tarumajaya', 'Cabangbungin'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - MathLearn</title>
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
            --hover-shadow: rgba(0, 0, 0, 0.1);
            --input-bg: #f7fafc;
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
            --hover-shadow: rgba(246, 177, 122, 0.2);
            --input-bg: rgba(26, 29, 46, 0.6);
        }

        body {
            font-family: 'Crimson Pro', serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--primary) 100%);
            min-height: 100vh;
            color: var(--text);
            transition: all 0.3s ease;
        }

        .navbar {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .brand {
            font-family: 'Space Mono', monospace;
            font-size: 1.8em;
            font-weight: 700;
            color: var(--light);
        }

        .navbar .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .navbar a {
            color: var(--text);
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: var(--light);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 50px;
            padding: 8px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-family: 'Space Mono', monospace;
            font-size: 0.9em;
            color: var(--text);
        }

        .theme-toggle:hover {
            border-color: var(--light);
            transform: translateY(-2px);
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .profile-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid var(--border);
            margin-bottom: 30px;
            box-shadow: 0 4px 20px var(--hover-shadow);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid var(--border);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            margin: 0 auto 20px;
        }

        .profile-header h1 {
            font-family: 'Space Mono', monospace;
            color: var(--light);
            font-size: 2em;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: var(--accent);
            font-size: 1.1em;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h2 {
            font-family: 'Space Mono', monospace;
            color: var(--light);
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light);
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 1em;
            font-family: 'Crimson Pro', serif;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--light);
            box-shadow: 0 0 0 3px rgba(246, 177, 122, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1em;
            font-weight: 700;
            font-family: 'Space Mono', monospace;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(246, 177, 122, 0.3);
        }

        .btn-back {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
            margin-left: 15px;
        }

        .btn-back:hover {
            background: var(--accent);
            color: #2d3748;
        }

        .success {
            background: rgba(82, 255, 168, 0.2);
            border: 1px solid rgba(82, 255, 168, 0.5);
            color: #10b981;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: rgba(255, 82, 82, 0.2);
            border: 1px solid rgba(255, 82, 82, 0.5);
            color: #ef4444;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .info-item {
            background: var(--input-bg);
            padding: 15px 20px;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .info-item .label {
            color: var(--accent);
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .info-item .value {
            color: var(--light);
            font-size: 1.1em;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body data-theme="dark">
    <nav class="navbar">
        <div class="brand">MathLearn</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profil</a>
            <a href="cari-teman.php">Cari Teman</a>
            <button class="theme-toggle" onclick="toggleTheme()">
                <span class="icon" id="theme-icon">🌙</span>
                <span id="theme-text">Dark</span>
            </button>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <h1><?php echo htmlspecialchars($user['nama']); ?></h1>
                <p>Kelas <?php echo $user['kelas']; ?> • <?php echo $user['kabupaten']; ?></p>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">NISN</div>
                    <div class="value"><?php echo $user['nisn']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Email</div>
                    <div class="value"><?php echo $user['email']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Kelas</div>
                    <div class="value"><?php echo $user['kelas']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Bergabung</div>
                    <div class="value"><?php echo date('d M Y', strtotime($user['created_at'])); ?></div>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="form-section">
                <h2>Edit Profil</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas" required>
                                <option value="X" <?php echo $user['kelas'] == 'X' ? 'selected' : ''; ?>>X</option>
                                <option value="XI" <?php echo $user['kelas'] == 'XI' ? 'selected' : ''; ?>>XI</option>
                                <option value="XII" <?php echo $user['kelas'] == 'XII' ? 'selected' : ''; ?>>XII</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select name="kabupaten" required>
                                <?php foreach ($kabupaten_list as $kab): ?>
                                    <option value="<?php echo $kab; ?>" <?php echo $user['kabupaten'] == $kab ? 'selected' : ''; ?>>
                                        <?php echo $kab; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary">Update Profil</button>
                    <a href="dashboard.php"><button type="button" class="btn btn-back">Kembali</button></a>
                </form>
            </div>
        </div>

        <div class="profile-card">
            <div class="form-section">
                <h2>Ganti Password</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="old_password" required>
                    </div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" required minlength="6">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>

                    <button type="submit" name="change_password" class="btn btn-primary">Ganti Password</button>
                </form>
            </div>
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
