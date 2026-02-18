<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Filter pencarian
$filter_kelas = isset($_GET['kelas']) ? clean_input($_GET['kelas']) : '';
$filter_kabupaten = isset($_GET['kabupaten']) ? clean_input($_GET['kabupaten']) : '';
$search_nama = isset($_GET['search']) ? clean_input($_GET['search']) : '';

// Build query
$query = "SELECT id, nama, kelas, kabupaten FROM users WHERE id != $user_id";

if ($filter_kelas) {
    $query .= " AND kelas = '$filter_kelas'";
}

if ($filter_kabupaten) {
    $query .= " AND kabupaten = '$filter_kabupaten'";
}

if ($search_nama) {
    $query .= " AND nama LIKE '%$search_nama%'";
}

$query .= " ORDER BY nama ASC";

$result = $conn->query($query);

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
    <title>Cari Teman - MathLearn</title>
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Space Mono', monospace;
            font-size: 2.5em;
            color: var(--light);
            margin-bottom: 10px;
        }

        .page-header p {
            color: var(--accent);
            font-size: 1.2em;
        }

        .search-box {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 20px var(--hover-shadow);
        }

        .search-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 100px;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            color: var(--light);
            font-weight: 600;
            font-size: 0.9em;
        }

        .form-group input,
        .form-group select {
            padding: 12px 16px;
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

        .btn-search {
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
            border: none;
            border-radius: 12px;
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(246, 177, 122, 0.3);
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .user-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 2px solid var(--border);
            transition: all 0.3s;
            text-align: center;
            box-shadow: 0 4px 15px var(--hover-shadow);
        }

        .user-card:hover {
            transform: translateY(-5px);
            border-color: var(--light);
            box-shadow: 0 10px 30px var(--hover-shadow);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            margin: 0 auto 20px;
        }

        .user-card h3 {
            font-family: 'Space Mono', monospace;
            color: var(--light);
            font-size: 1.3em;
            margin-bottom: 10px;
        }

        .user-card .info {
            color: var(--accent);
            margin: 5px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(112, 119, 161, 0.3);
            border-radius: 20px;
            font-size: 0.85em;
            margin: 5px;
            color: var(--light);
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: var(--accent);
            font-size: 1.2em;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .search-form {
                grid-template-columns: 1fr;
            }

            .users-grid {
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
        <div class="page-header">
            <h1>🔍 Cari Teman Belajar</h1>
            <p>Temukan teman sekelas atau sesama pelajar matematika</p>
        </div>

        <div class="search-box">
            <form method="GET" class="search-form">
                <div class="form-group">
                    <label>Cari Nama</label>
                    <input type="text" name="search" placeholder="Ketik nama..." value="<?php echo htmlspecialchars($search_nama); ?>">
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas">
                        <option value="">Semua Kelas</option>
                        <option value="X" <?php echo $filter_kelas == 'X' ? 'selected' : ''; ?>>X</option>
                        <option value="XI" <?php echo $filter_kelas == 'XI' ? 'selected' : ''; ?>>XI</option>
                        <option value="XII" <?php echo $filter_kelas == 'XII' ? 'selected' : ''; ?>>XII</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="kabupaten">
                        <option value="">Semua</option>
                        <?php foreach ($kabupaten_list as $kab): ?>
                            <option value="<?php echo $kab; ?>" <?php echo $filter_kabupaten == $kab ? 'selected' : ''; ?>>
                                <?php echo $kab; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-search">Cari</button>
            </form>
        </div>

        <div class="users-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <div class="user-card">
                        <div class="user-avatar">👤</div>
                        <h3><?php echo htmlspecialchars($user['nama']); ?></h3>
                        <div class="info">
                            <span class="badge">Kelas <?php echo $user['kelas']; ?></span>
                            <span class="badge"><?php echo $user['kabupaten']; ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results" style="grid-column: 1 / -1;">
                    <p>😔 Tidak ada teman yang ditemukan</p>
                    <p style="font-size: 0.9em; margin-top: 10px;">Coba ubah filter pencarian Anda</p>
                </div>
            <?php endif; ?>
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
