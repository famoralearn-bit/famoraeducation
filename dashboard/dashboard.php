<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$nama         = $_SESSION['nama'];
$kelas        = $_SESSION['kelas'];
$discord_link = get_discord_link();
update_last_seen($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MathLearn</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body data-theme="dark" data-user-class="<?php echo $kelas; ?>">

    <!-- Navbar -->
    <nav class="navbar">
        <a href="dashboard.php" class="brand">MathLearn</a>
        <div class="nav-links">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="../profile/profile.php">Profil</a>
            <a href="../cari-teman/cari-teman.php">Cari Teman</a>
            <button class="theme-toggle" onclick="toggleTheme()">
                <span id="theme-icon">🌙</span>
                <span id="theme-text">Dark</span>
            </button>
            <a href="../logout/logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <div class="container">

        <!-- Welcome -->
        <div class="welcome">
            <div class="welcome-text">
                <h1>Halo, <?php echo htmlspecialchars($nama); ?>! 👋</h1>
                <p>Kelas <?php echo $kelas; ?> · Mari belajar matematika dengan menyenangkan</p>
            </div>
            <div class="welcome-badge">Kelas <?php echo $kelas; ?></div>
        </div>

        <!-- Quick Menu -->
        <div class="menu-grid">
            <a href="../profile/profile.php" class="menu-card">
                <span class="icon">👤</span>
                <h3>Profil Saya</h3>
                <p>Lihat dan edit informasi profil Anda</p>
            </a>

            <a href="../cari-teman/cari-teman.php" class="menu-card">
                <span class="icon">👥</span>
                <h3>Cari Teman Belajar</h3>
                <p>Temukan teman sekelas atau sesama pelajar matematika</p>
                <p style="font-size:.85em;margin-top:8px;color:var(--light);">Cari berdasarkan kelas & kecamatan</p>
            </a>

            <a href="<?php echo $discord_link; ?>" target="_blank" class="menu-card">
                <span class="icon">💬</span>
                <h3>Ruang Discord</h3>
                <p>Gabung komunitas belajar matematika</p>
                <div class="discord-time-box">
                    <div style="font-size:.82em;color:var(--accent);margin-bottom:4px;">⏰ Waktu Saat Ini:</div>
                    <div id="current-time" style="font-size:1.3em;font-weight:700;color:var(--light);font-family:'Space Mono',monospace;"></div>
                    <div style="font-size:.78em;color:var(--accent);margin-top:4px;">Link update otomatis jam 16:00 & 20:00</div>
                </div>
            </a>
        </div>

        <!-- ================================================
             SECTION: MATERI MATEMATIKA
             ================================================ -->
        <h2 class="section-title">📖 Materi Matematika</h2>

        <div class="panel-box">
            <!-- Class Tabs - Materi -->
            <div class="class-tabs">
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('X')"   id="materi-btn-X">Kelas X</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XI')"  id="materi-btn-XI">Kelas XI</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XII')" id="materi-btn-XII">Kelas XII</button>
            </div>

            <!-- ---- MATERI KELAS X ---- -->
            <div id="materi-X" class="tab-panel materi-panel">
                <div class="materi-grid">

                    <a href="#" class="materi-card">
                        <span class="materi-icon">⚡</span>
                        <h4>Eksponen</h4>
                        <p>Bilangan berpangkat, sifat-sifat eksponen, dan operasi perpangkatan</p>
                        <span class="badge badge-popular">Populer</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Definisi logaritma, sifat-sifat logaritma, dan penerapannya</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔗</span>
                        <h4>Baris & Deret</h4>
                        <p>Barisan aritmetika dan geometri, deret hingga dan tak hingga</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                </div>
            </div>

            <!-- ---- MATERI KELAS XI ---- -->
            <div id="materi-XI" class="tab-panel materi-panel">
                <div class="materi-grid">

                    <a href="#" class="materi-card">
                        <span class="materi-icon">🔄</span>
                        <h4>Fungsi Komposisi &amp; Invers</h4>
                        <p>Komposisi fungsi, fungsi invers, dan sifat-sifatnya</p>
                        <span class="badge badge-popular">Populer</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Operasi matriks, determinan, invers matriks, dan aplikasinya</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">📉</span>
                        <h4>Statistika</h4>
                        <p>Ukuran pemusatan, penyebaran data, dan penyajian data statistik</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                </div>
            </div>

            <!-- ---- MATERI KELAS XII ---- -->
            <div id="materi-XII" class="tab-panel materi-panel">
                <div class="materi-grid">

                    <a href="#" class="materi-card">
                        <span class="materi-icon">🌀</span>
                        <h4>Transformasi Fungsi</h4>
                        <p>Translasi, refleksi, rotasi, dan dilatasi pada fungsi</p>
                        <span class="badge badge-popular">Populer</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Lanjutan operasi matriks, sistem persamaan linear, dan transformasi</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                    <a href="#" class="materi-card">
                        <span class="materi-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Persamaan logaritma, pertidaksamaan logaritma, dan penerapannya</p>
                        <span class="badge badge-materi">Materi</span>
                    </a>

                </div>
            </div>
        </div><!-- end panel-box materi -->

        <!-- ================================================
             SECTION: LATIHAN SOAL
             ================================================ -->
        <h2 class="section-title">📝 Latihan Soal</h2>

        <div class="panel-box">
            <!-- Class Tabs - Latihan -->
            <div class="class-tabs">
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('X')"   id="latihan-btn-X">Kelas X</button>
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XI')"  id="latihan-btn-XI">Kelas XI</button>
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XII')" id="latihan-btn-XII">Kelas XII</button>
            </div>

            <!-- ---- LATIHAN KELAS X ---- -->
            <div id="latihan-X" class="tab-panel latihan-panel">
                <div class="topic-grid">

                    <a href="https://quizzory.in/id/69b015973bce17d35ef0ae3e" target="_blank" class="topic-card">
                        <span class="topic-icon">⚡</span>
                        <h4>Eksponen</h4>
                        <p>Latihan soal eksponen dan perpangkatan</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://quizzory.in/id/69b0221ae151768d0424a152" target="_blank" class="topic-card">
                        <span class="topic-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Latihan soal logaritma</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://quizzory.in/id/69b033d43bce17d35ef268cd" target="_blank" class="topic-card">
                        <span class="topic-icon">🔗</span>
                        <h4>Baris &amp; Deret</h4>
                        <p>Latihan soal baris dan deret</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <!-- Tambahkan soal Kelas X baru di sini -->

                </div>
            </div>

            <!-- ---- LATIHAN KELAS XI ---- -->
            <div id="latihan-XI" class="tab-panel latihan-panel">
                <div class="topic-grid">

                    <a href="https://forms.gle/fungsi-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">🔄</span>
                        <h4>Fungsi Komposisi &amp; Invers</h4>
                        <p>Latihan soal fungsi komposisi dan invers</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://forms.gle/matriks-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Latihan soal matriks</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://forms.gle/statistika-kelas11" target="_blank" class="topic-card">
                        <span class="topic-icon">📉</span>
                        <h4>Statistika</h4>
                        <p>Latihan soal statistika</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <!-- Tambahkan soal Kelas XI baru di sini -->

                </div>
            </div>

            <!-- ---- LATIHAN KELAS XII ---- -->
            <div id="latihan-XII" class="tab-panel latihan-panel">
                <div class="topic-grid">

                    <a href="https://forms.gle/transformasi-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">🌀</span>
                        <h4>Transformasi Fungsi</h4>
                        <p>Latihan soal transformasi fungsi</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://forms.gle/matriks-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">🎯</span>
                        <h4>Matriks</h4>
                        <p>Latihan soal matriks</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <a href="https://forms.gle/logaritma-kelas12" target="_blank" class="topic-card">
                        <span class="topic-icon">📈</span>
                        <h4>Logaritma</h4>
                        <p>Latihan soal logaritma</p>
                        <span class="topic-badge">Kerjakan →</span>
                    </a>

                    <!-- Tambahkan soal Kelas XII baru di sini -->

                </div>
            </div>
        </div><!-- end panel-box latihan -->

    </div><!-- end container -->

    <script src="../assets/js/theme.js"></script>
    <script src="dashboard.js"></script>
</body>
</html>
