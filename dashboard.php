<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$nama = $_SESSION['nama'];
$kelas = $_SESSION['kelas'];
$discord_link = get_discord_link();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MathLearn</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Crimson+Pro:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #2D3250; --secondary: #424769;
            --accent: #7077A1; --light: #F6B17A;
            --bg: #1a1d2e; --text: #e8e9f3;
        }

        [data-theme="light"] {
            --primary: #f5f7fa; --secondary: #ffffff;
            --accent: #5a67d8; --light: #ed8936;
            --bg: #edf2f7; --text: #2d3748;
            --border: #cbd5e0; --card-bg: #ffffff;
            --hover-shadow: rgba(0,0,0,0.1);
            --input-bg: #f7fafc;
        }

        [data-theme="dark"] {
            --primary: #2D3250; --secondary: #424769;
            --accent: #7077A1; --light: #F6B17A;
            --bg: #1a1d2e; --text: #e8e9f3;
            --border: rgba(255,255,255,0.1);
            --card-bg: rgba(45,50,80,0.7);
            --hover-shadow: rgba(246,177,122,0.2);
            --input-bg: rgba(26,29,46,0.5);
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
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar .brand {
            font-family: 'Space Mono', monospace;
            font-size: 1.8em;
            font-weight: 700;
            color: var(--light);
            letter-spacing: -1px;
        }

        .navbar .nav-links { display: flex; gap: 30px; align-items: center; }
        .navbar a { color: var(--text); text-decoration: none; font-size: 1em; transition: color 0.3s; letter-spacing: 1px; }
        .navbar a:hover { color: var(--light); }

        .navbar .logout {
            background: rgba(255,82,82,0.3);
            padding: 8px 20px;
            border-radius: 8px;
            border: 1px solid rgba(255,82,82,0.5);
        }

        .navbar .logout:hover { background: rgba(255,82,82,0.5); }

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

        .theme-toggle:hover { border-color: var(--light); transform: translateY(-2px); }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 40px; }

        .welcome {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            border: 1px solid var(--border);
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 4px 20px var(--hover-shadow);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome h1 {
            font-family: 'Space Mono', monospace;
            font-size: 2.4em;
            color: var(--light);
            margin-bottom: 10px;
        }

        .welcome p { font-size: 1.2em; color: var(--accent); letter-spacing: 1px; }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .menu-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px var(--hover-shadow);
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(246,177,122,0.1), transparent);
            transition: left 0.5s;
        }

        .menu-card:hover::before { left: 100%; }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: var(--light);
            box-shadow: 0 10px 30px var(--hover-shadow);
        }

        .menu-card h3 { font-family: 'Space Mono', monospace; font-size: 1.3em; color: var(--light); margin-bottom: 12px; }
        .menu-card p { color: var(--accent); font-size: 0.95em; line-height: 1.6; }
        .menu-card .icon { font-size: 2.5em; margin-bottom: 15px; display: block; }

        .section-title {
            font-family: 'Space Mono', monospace;
            font-size: 1.8em;
            color: var(--light);
            margin: 50px 0 25px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        /* ===== SECTION MATERI ===== */
        .materi-selector {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid var(--border);
            margin-top: 30px;
            box-shadow: 0 4px 20px var(--hover-shadow);
        }

        .class-tabs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .class-tab-btn {
            padding: 15px;
            background: var(--input-bg);
            border: 2px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            font-size: 1em;
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .class-tab-btn:hover {
            border-color: var(--light);
            transform: translateY(-2px);
        }

        .class-tab-btn.active {
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
            border-color: var(--light);
        }

        .materi-panel {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .materi-panel.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .materi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .materi-card {
            background: var(--input-bg);
            border: 2px solid var(--border);
            border-radius: 15px;
            padding: 25px 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text);
            display: block;
            position: relative;
            overflow: hidden;
        }

        .materi-card:hover {
            border-color: var(--light);
            transform: translateY(-4px);
            box-shadow: 0 8px 25px var(--hover-shadow);
        }

        .materi-card .materi-icon { font-size: 2em; margin-bottom: 12px; display: block; }

        .materi-card h4 {
            font-family: 'Space Mono', monospace;
            color: var(--light);
            font-size: 1em;
            margin-bottom: 8px;
        }

        .materi-card p { color: var(--accent); font-size: 0.88em; line-height: 1.5; }

        .materi-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 10px;
            background: rgba(112,119,161,0.2);
            border-radius: 20px;
            font-size: 0.78em;
            color: var(--accent);
            border: 1px solid var(--border);
        }

        .materi-badge.new {
            background: rgba(246,177,122,0.2);
            color: var(--light);
            border-color: rgba(246,177,122,0.4);
        }

        /* ===== SECTION LATIHAN SOAL ===== */
        .exercise-selector {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid var(--border);
            margin-top: 30px;
            box-shadow: 0 4px 20px var(--hover-shadow);
        }

        .class-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .class-btn {
            padding: 20px;
            background: var(--input-bg);
            border: 2px solid var(--border);
            border-radius: 15px;
            color: var(--text);
            font-size: 1.1em;
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .class-btn:hover {
            border-color: var(--light);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px var(--hover-shadow);
        }

        .class-btn.active {
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
            border-color: var(--light);
        }

        .topics-container {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .topics-container.active { display: block; }

        .topic-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 18px;
        }

        .topic-card {
            background: var(--input-bg);
            border: 2px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text);
            display: block;
        }

        .topic-card:hover {
            border-color: var(--light);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px var(--hover-shadow);
        }

        .topic-card .topic-icon { font-size: 1.8em; margin-bottom: 10px; display: block; }

        .topic-card h4 {
            font-family: 'Space Mono', monospace;
            color: var(--light);
            font-size: 1em;
            margin-bottom: 6px;
        }

        .topic-card p { color: var(--accent); font-size: 0.88em; }

        .topic-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 10px;
            background: rgba(246,177,122,0.15);
            border-radius: 20px;
            font-size: 0.78em;
            color: var(--light);
            border: 1px solid rgba(246,177,122,0.3);
        }

        .discord-time-box {
            margin-top: 15px;
            padding: 10px;
            background: var(--input-bg);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .navbar .nav-links { flex-wrap: wrap; justify-content: center; }
            .container { padding: 0 20px; }
            .menu-grid { grid-template-columns: 1fr; }
            .class-selector { grid-template-columns: 1fr; }
            .class-tabs { grid-template-columns: 1fr; }
            .topic-list, .materi-grid { grid-template-columns: 1fr; }
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
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome">
            <h1>Selamat Datang, <?php echo htmlspecialchars($nama); ?>! 👋</h1>
            <p>Kelas <?php echo $kelas; ?> | Mari belajar matematika dengan menyenangkan</p>
        </div>

        <!-- Menu Utama -->
        <div class="menu-grid">
            <a href="profile.php" style="text-decoration: none;">
                <div class="menu-card">
                    <span class="icon">👤</span>
                    <h3>Profil Saya</h3>
                    <p>Lihat dan edit informasi profil Anda</p>
                </div>
            </a>

            <a href="cari-teman.php" style="text-decoration: none;">
                <div class="menu-card">
                    <span class="icon">👥</span>
                    <h3>Cari Teman Belajar</h3>
                    <p>Temukan teman sekelas atau sesama pelajar matematika</p>
                    <p style="font-size: 0.85em; margin-top: 10px; color: var(--light);">Cari berdasarkan kelas</p>
                </div>
            </a>

            <a href="<?php echo $discord_link; ?>" target="_blank" style="text-decoration: none;">
                <div class="menu-card">
                    <span class="icon">💬</span>
                    <h3>Ruang Discord</h3>
                    <p>Gabung komunitas belajar matematika</p>
                    <div class="discord-time-box">
                        <div style="font-size: 0.85em; color: var(--accent); margin-bottom: 5px;">⏰ Waktu Saat Ini:</div>
                        <div id="current-time" style="font-size: 1.3em; font-weight: 700; color: var(--light); font-family: 'Space Mono', monospace;"></div>
                        <div style="font-size: 0.8em; color: var(--accent); margin-top: 5px;">Link update otomatis jam 16:00 & 20:00</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- ===== SECTION MATERI ===== -->
        <h2 class="section-title">📖 Materi Matematika</h2>

        <div class="materi-selector">
            <div class="class-tabs">
                <button class="class-tab-btn" onclick="selectMateri('X')" id="materi-btn-X">Kelas X</button>
                <button class="class-tab-btn" onclick="selectMateri('XI')" id="materi-btn-XI">Kelas XI</button>
                <button class="class-tab-btn" onclick="selectMateri('XII')" id="materi-btn-XII">Kelas XII</button>
            </div>

            <!-- Materi Kelas X -->
            <div id="materi-X" class="materi-panel">
                <div class="materi-grid">
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔢</span>
                        <h4>Bilangan Berpangkat</h4>
                        <p>Operasi bilangan eksponen, sifat-sifat perpangkatan</p>
                        <span class="materi-badge new">Populer</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Definisi, sifat, dan penerapan logaritma</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📉</span>
                        <h4>Fungsi</h4>
                        <p>Pengertian fungsi, domain, kodomain, dan range</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📊</span>
                        <h4>Persamaan & Pertidaksamaan</h4>
                        <p>Persamaan linear, kuadrat, dan pertidaksamaan</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔵</span>
                        <h4>Trigonometri Dasar</h4>
                        <p>Sin, cos, tan, dan identitas trigonometri</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔗</span>
                        <h4>Baris & Deret</h4>
                        <p>Barisan aritmetika dan geometri, deret tak hingga</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                </div>
            </div>

            <!-- Materi Kelas XI -->
            <div id="materi-XI" class="materi-panel">
                <div class="materi-grid">
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔄</span>
                        <h4>Fungsi Komposisi</h4>
                        <p>Komposisi fungsi dan fungsi invers</p>
                        <span class="materi-badge new">Populer</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Operasi matriks, determinan, dan invers matriks</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📐</span>
                        <h4>Vektor</h4>
                        <p>Vektor di bidang dan ruang, operasi vektor</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📉</span>
                        <h4>Statistika</h4>
                        <p>Ukuran pemusatan, penyebaran data, dan distribusi</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🎲</span>
                        <h4>Peluang</h4>
                        <p>Ruang sampel, kejadian, dan aturan peluang</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🌀</span>
                        <h4>Transformasi Geometri</h4>
                        <p>Translasi, rotasi, refleksi, dan dilatasi</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                </div>
            </div>

            <!-- Materi Kelas XII -->
            <div id="materi-XII" class="materi-panel">
                <div class="materi-grid">
                    <a href="#" class="materi-card">
                        <span class="materi-icon">♾️</span>
                        <h4>Limit Fungsi</h4>
                        <p>Konsep limit, limit aljabar, dan teorema limit</p>
                        <span class="materi-badge new">Populer</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📏</span>
                        <h4>Turunan (Diferensial)</h4>
                        <p>Aturan turunan, aplikasi turunan fungsi</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">∫</span>
                        <h4>Integral</h4>
                        <p>Integral tak tentu, integral tertentu, dan aplikasinya</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📦</span>
                        <h4>Program Linear</h4>
                        <p>Model matematika, daerah penyelesaian, optimasi</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔢</span>
                        <h4>Kombinatorika</h4>
                        <p>Permutasi, kombinasi, dan binomial Newton</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                    <a href="#" class="materi-card">
                        <span class="materi-icon">📊</span>
                        <h4>Statistika Lanjut</h4>
                        <p>Distribusi binomial, normal, dan inferensi statistik</p>
                        <span class="materi-badge">Materi</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- ===== SECTION LATIHAN SOAL ===== -->
        <h2 class="section-title">📝 Latihan Soal</h2>

        <div class="exercise-selector">
            <div class="class-selector">
                <button class="class-btn" onclick="selectClass('X')" id="btn-X">Kelas X</button>
                <button class="class-btn" onclick="selectClass('XI')" id="btn-XI">Kelas XI</button>
                <button class="class-btn" onclick="selectClass('XII')" id="btn-XII">Kelas XII</button>
            </div>

            <!-- Soal Kelas X -->
            <div id="topics-X" class="topics-container">
                <div class="topic-list">
                    <a href="https://forms.gle/eksponen-kelas10" target="_blank" class="topic-card">
                        <span class="topic-icon">📊</span>
                        <h4>Eksponen</h4>
                        <p>Latihan soal eksponen dan perpangkatan</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/logaritma-kelas10" target="_blank" class="topic-card">
                        <span class="topic-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Latihan soal logaritma</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/barisderet-kelas10" target="_blank" class="topic-card">
                        <span class="topic-icon">🔢</span>
                        <h4>Baris & Deret</h4>
                        <p>Latihan soal baris dan deret</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <!-- Tambahkan soal kelas X di bawah ini -->
                </div>
            </div>

            <!-- Soal Kelas XI -->
            <div id="topics-XI" class="topics-container">
                <div class="topic-list">
                    <a href="https://forms.gle/fungsi-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">🔄</span>
                        <h4>Fungsi Komposisi & Invers</h4>
                        <p>Latihan soal fungsi komposisi dan invers</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/matriks-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Latihan soal matriks</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/statistika-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">📉</span>
                        <h4>Statistika</h4>
                        <p>Latihan soal statistika</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <!-- Tambahkan soal kelas XI di bawah ini -->
                </div>
            </div>

            <!-- Soal Kelas XII -->
            <div id="topics-XII" class="topics-container">
                <div class="topic-list">
                    <a href="https://forms.gle/transformasi-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">🔀</span>
                        <h4>Transformasi Fungsi</h4>
                        <p>Latihan soal transformasi fungsi</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/matriks-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Latihan soal matriks</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <a href="https://forms.gle/logaritma-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Latihan soal logaritma</p>
                        <span class="topic-badge">Klik untuk mengerjakan →</span>
                    </a>
                    <!-- Tambahkan soal kelas XII di bawah ini -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const currentTheme = body.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                body.setAttribute('data-theme', 'light');
                document.getElementById('theme-icon').textContent = '☀️';
                document.getElementById('theme-text').textContent = 'Light';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                document.getElementById('theme-icon').textContent = '🌙';
                document.getElementById('theme-text').textContent = 'Dark';
                localStorage.setItem('theme', 'dark');
            }
        }

        window.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.body.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'light') {
                document.getElementById('theme-icon').textContent = '☀️';
                document.getElementById('theme-text').textContent = 'Light';
            }

            const userClass = '<?php echo $kelas; ?>';
            selectClass(userClass);
            selectMateri(userClass);
        });

        function updateTime() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('current-time');
            if (el) el.textContent = `${h}:${m}:${s}`;
        }

        updateTime();
        setInterval(updateTime, 1000);

        setInterval(function() {
            const now = new Date();
            if ((now.getHours() === 16 || now.getHours() === 20) && now.getMinutes() === 0 && now.getSeconds() === 0) {
                location.reload();
            }
        }, 1000);

        function selectClass(className) {
            document.querySelectorAll('.class-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.topics-container').forEach(c => c.classList.remove('active'));
            document.getElementById('btn-' + className).classList.add('active');
            document.getElementById('topics-' + className).classList.add('active');
        }

        function selectMateri(className) {
            document.querySelectorAll('.class-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.materi-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('materi-btn-' + className).classList.add('active');
            document.getElementById('materi-' + className).classList.add('active');
        }
    </script>
</body>
</html>
