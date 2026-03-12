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
    <title>Dashboard - FamoraLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body data-theme="dark" data-user-class="<?php echo $kelas; ?>">

    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand brand-logo" href="dashboard.php">
                <img src="../assets/images/famora.png" alt="Logo" class="nav-logo-img me-2">FamoraLearn
            </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="bi bi-house me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile/profile.php"><i class="bi bi-person me-1"></i>Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cari-teman/cari-teman.php"><i class="bi bi-people me-1"></i>Cari Teman</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn nav-theme-btn" onclick="toggleTheme()">
                            <span id="theme-icon">🌙</span>
                            <span id="theme-text">Dark</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-logout" href="../logout/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- Welcome -->
        <div class="welcome-card mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="welcome-title">Halo, <?php echo htmlspecialchars($nama); ?>! 👋</h1>
                    <p class="welcome-sub">Kelas <?php echo $kelas; ?> · Mari belajar matematika dengan menyenangkan</p>
                </div>
                <span class="kelas-badge">Kelas <?php echo $kelas; ?></span>
            </div>
        </div>

        <!-- Quick Menu -->
        <div class="row g-3 mb-5">
            <div class="col-md-4">
                <a href="../profile/profile.php" class="menu-card d-block text-decoration-none">
                    <span class="menu-icon">👤</span>
                    <h3>Profil Saya</h3>
                    <p>Lihat dan edit informasi profil Anda</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../cari-teman/cari-teman.php" class="menu-card d-block text-decoration-none">
                    <span class="menu-icon">👥</span>
                    <h3>Cari Teman Belajar</h3>
                    <p>Temukan teman sekelas atau sesama pelajar matematika</p>
                    <small class="text-light-custom">Cari berdasarkan kelas & kecamatan</small>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo $discord_link; ?>" target="_blank" class="menu-card d-block text-decoration-none">
                    <span class="menu-icon">💬</span>
                    <h3>Ruang Discord</h3>
                    <p>Gabung komunitas belajar matematika</p>
                    <div class="discord-time-box mt-2">
                        <div class="discord-time-label">⏰ Waktu Saat Ini:</div>
                        <div id="current-time" class="discord-time-value"></div>
                        <div class="discord-time-label mt-1">Link update otomatis jam 16:00 & 20:00</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Materi -->
        <h2 class="section-title">📖 Materi Matematika</h2>
        <div class="panel-box mb-5">
            <div class="class-tabs mb-3">
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('X')"   id="materi-btn-X">Kelas X</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XI')"  id="materi-btn-XI">Kelas XI</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XII')" id="materi-btn-XII">Kelas XII</button>
            </div>

            <div id="materi-X" class="tab-panel materi-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">⚡</span><h4>Eksponen</h4><p>Bilangan berpangkat, sifat-sifat eksponen, dan operasi perpangkatan</p><span class="badge badge-popular">Populer</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">📈</span><h4>Logaritma</h4><p>Definisi logaritma, sifat-sifat logaritma, dan penerapannya</p><span class="badge badge-materi">Materi</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">🔗</span><h4>Baris & Deret</h4><p>Barisan aritmetika dan geometri, deret hingga dan tak hingga</p><span class="badge badge-materi">Materi</span></a></div>
                </div>
            </div>

            <div id="materi-XI" class="tab-panel materi-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">🔄</span><h4>Fungsi Komposisi &amp; Invers</h4><p>Komposisi fungsi, fungsi invers, dan sifat-sifatnya</p><span class="badge badge-popular">Populer</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">🎯</span><h4>Matriks</h4><p>Operasi matriks, determinan, invers matriks, dan aplikasinya</p><span class="badge badge-materi">Materi</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">📉</span><h4>Statistika</h4><p>Ukuran pemusatan, penyebaran data, dan penyajian data statistik</p><span class="badge badge-materi">Materi</span></a></div>
                </div>
            </div>

            <div id="materi-XII" class="tab-panel materi-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">🌀</span><h4>Transformasi Fungsi</h4><p>Translasi, refleksi, rotasi, dan dilatasi pada fungsi</p><span class="badge badge-popular">Populer</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">🎯</span><h4>Matriks</h4><p>Lanjutan operasi matriks, sistem persamaan linear, dan transformasi</p><span class="badge badge-materi">Materi</span></a></div>
                    <div class="col-md-4"><a href="#" class="materi-card d-block text-decoration-none"><span class="materi-icon">📈</span><h4>Logaritma</h4><p>Persamaan logaritma, pertidaksamaan logaritma, dan penerapannya</p><span class="badge badge-materi">Materi</span></a></div>
                </div>
            </div>
        </div>

        <!-- Latihan Soal -->
        <h2 class="section-title">📝 Latihan Soal</h2>
        <div class="panel-box">
            <div class="class-tabs mb-3">
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('X')"   id="latihan-btn-X">Kelas X</button>
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XI')"  id="latihan-btn-XI">Kelas XI</button>
                <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XII')" id="latihan-btn-XII">Kelas XII</button>
            </div>

            <div id="latihan-X" class="tab-panel latihan-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="https://forms.gle/eksponen-kelas10" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">⚡</span><h4>Eksponen</h4><p>Latihan soal eksponen dan perpangkatan</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/logaritma-kelas10" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">📈</span><h4>Logaritma</h4><p>Latihan soal logaritma</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/barisderet-kelas10" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">🔗</span><h4>Baris &amp; Deret</h4><p>Latihan soal baris dan deret</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <!-- Tambahkan soal Kelas X baru di sini -->
                </div>
            </div>

            <div id="latihan-XI" class="tab-panel latihan-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="https://forms.gle/fungsi-kelas11" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">🔄</span><h4>Fungsi Komposisi &amp; Invers</h4><p>Latihan soal fungsi komposisi dan invers</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/matriks-kelas11" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">🎯</span><h4>Matriks</h4><p>Latihan soal matriks</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/statistika-kelas11" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">📉</span><h4>Statistika</h4><p>Latihan soal statistika</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <!-- Tambahkan soal Kelas XI baru di sini -->
                </div>
            </div>

            <div id="latihan-XII" class="tab-panel latihan-panel">
                <div class="row g-3">
                    <div class="col-md-4"><a href="https://forms.gle/transformasi-kelas12" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">🌀</span><h4>Transformasi Fungsi</h4><p>Latihan soal transformasi fungsi</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/matriks-kelas12" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">🎯</span><h4>Matriks</h4><p>Latihan soal matriks</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <div class="col-md-4"><a href="https://forms.gle/logaritma-kelas12" target="_blank" class="topic-card d-block text-decoration-none"><span class="topic-icon">📈</span><h4>Logaritma</h4><p>Latihan soal logaritma</p><span class="topic-badge">Kerjakan →</span></a></div>
                    <!-- Tambahkan soal Kelas XII baru di sini -->
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="site-footer mt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Brand -->
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="../assets/images/famora.png" alt="Logo" class="footer-logo">
                        <div>
                            <div class="footer-brand">FamoraLearn</div>
                            <div class="footer-brand-sub">by Famora Education</div>
                        </div>
                    </div>
                    <p class="footer-desc">Platform belajar matematika interaktif untuk siswa SMA. Belajar lebih mudah, lebih menyenangkan, dan bersama teman.</p>
                </div>

                <!-- Alamat & Kontak -->
                <div class="col-md-4">
                    <h6 class="footer-heading">Hubungi Kami</h6>
                    <ul class="footer-list">
                        <li><i class="bi bi-envelope-fill me-2"></i><a href="mailto:famoralearn@gmail.com">famoralearn@gmail.com</a></li>
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Kabupaten Bekasi, Jawa Barat</li>
                        <li><i class="bi bi-clock-fill me-2"></i>Senin – Jumat, 08.00 – 17.00 WIB</li>
                    </ul>
                </div>

                <!-- Produk & Sosial -->
                <div class="col-md-4">
                    <h6 class="footer-heading">Produk</h6>
                    <ul class="footer-list mb-3">
                        <li><i class="bi bi-box-fill me-2"></i>Famora Education</li>
                        <li><i class="bi bi-mortarboard-fill me-2"></i><strong class="text-light-footer">FamoraLearn</strong></li>
                    </ul>
                    <h6 class="footer-heading">Ikuti Kami</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="#" class="footer-social"><i class="bi bi-instagram"></i> Instagram</a>
                        <a href="#" class="footer-social"><i class="bi bi-youtube"></i> YouTube</a>
                        <a href="#" class="footer-social discord-social"><i class="bi bi-discord"></i> Discord</a>
                    </div>
                </div>
            </div>

            <hr class="footer-divider mt-4 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="footer-copy mb-0">© 2024 Famora Education. Semua hak dilindungi.</p>
                <p class="footer-copy mb-0">Made with ❤️ untuk pelajar Indonesia</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="dashboard.js"></script>
</body>
</html>
