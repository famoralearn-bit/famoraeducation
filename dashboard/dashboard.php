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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid px-3">
        <a class="navbar-brand brand-logo" href="dashboard.php">
            <img src="../assets/images/logo.jpeg" alt="Logo" class="nav-logo-img">
            FamoraLearn
        </a>
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list" style="font-size:1.2em;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="bi bi-house me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="../profile/profile.php"><i class="bi bi-person me-1"></i>Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="../cari-teman/cari-teman.php"><i class="bi bi-people me-1"></i>Cari Teman</a></li>
                <li class="nav-item">
                    <button class="btn nav-theme-btn" onclick="toggleTheme()">
                        <span id="theme-icon">🌙</span> <span id="theme-text">Dark</span>
                    </button>
                </li>
                <!-- User info + Logout (pojok kanan) -->
                <li class="nav-item d-none d-lg-flex align-items-center ms-1">
                    <div class="nav-user-pill">
                        <div class="nav-user-avatar"><?php echo mb_strtoupper(mb_substr($nama, 0, 1)); ?></div>
                        <div class="nav-user-info">
                            <span class="nav-user-name"><?php echo htmlspecialchars($nama); ?></span>
                            <span class="nav-user-kelas"><?php echo htmlspecialchars($kelas); ?></span>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-logout" href="../logout/logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid dash-main dashboard-shell">

    <!-- ===== HERO BANNER ===== -->
    <div class="hero-banner mb-4 anim-1">
        <!-- Decorative math symbols background -->
        <div class="hero-math-bg" aria-hidden="true">
            <span class="math-sym s1">∑</span>
            <span class="math-sym s2">π</span>
            <span class="math-sym s3">√</span>
            <span class="math-sym s4">∫</span>
            <span class="math-sym s5">Δ</span>
            <span class="math-sym s6">∞</span>
            <span class="math-sym s7">θ</span>
            <span class="math-sym s8">≈</span>
            <span class="math-sym s8">≤</span>
        </div>
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative">
            <div>
                <div class="hero-badge-row mb-2">
                    <span class="hero-badge-math">🧮 FamoraLearn</span>
                    <span class="hero-badge-math hero-badge-green">✅ Platform Aktif</span>
                </div>
                <h1 class="hero-name">Halo, <?php echo htmlspecialchars($nama); ?>! 👋</h1>
                <p class="hero-desc">Kelas <strong><?php echo $kelas; ?></strong> &nbsp;·&nbsp; Kuasai matematika langkah demi langkah ✨</p>
                <div class="hero-formula-strip mt-2">
                    <span class="formula-item">aᵐ·aⁿ = aᵐ⁺ⁿ</span>
                    <span class="formula-sep">|</span>
                    <span class="formula-item">sin²θ+cos²θ=1</span>
                    <span class="formula-sep">|</span>
                    <span class="formula-item">P(A)=n(A)/n(S)</span>
                    <span class="formula-sep">|</span>
                    <span class="formula-item">∫xⁿdx=xⁿ⁺¹/(n+1)+C</span>
                </div>
            </div>
            <div class="hero-stats-col d-none d-md-flex flex-column gap-2 align-items-end">
                <div class="hero-stat-box"><span class="hero-stat-num">12</span><span class="hero-stat-label">Topik Materi</span></div>
                <div class="hero-stat-box"><span class="hero-stat-num">12</span><span class="hero-stat-label">Latihan Soal</span></div>
                <div class="hero-stat-box hero-stat-ai"><span class="hero-stat-num">🤖</span><span class="hero-stat-label">AI Tutor Aktif</span></div>
            </div>
        </div>
        <div class="hero-chips mt-3">
            <div class="hero-chip"><span>📚</span><div class="chip-text"><strong>12</strong>Topik Materi</div></div>
            <div class="hero-chip"><span>📝</span><div class="chip-text"><strong>12</strong>Latihan Soal</div></div>
            <div class="hero-chip"><span>🤖</span><div class="chip-text"><strong>AI Tutor</strong>Siap Bantu</div></div>
            <div class="hero-chip d-none d-sm-flex"><span>🏆</span><div class="chip-text"><strong>Belajar</strong>Sekarang</div></div>
        </div>
    </div>

    <!-- ===== 2-COL LAYOUT: Quick Menu + AI Tutor ===== -->
    <div class="row g-3 mb-4">

        <!-- Quick Menu (left) -->
        <div class="col-lg-5">
            <div class="row g-3 h-100">
                <div class="col-12 anim-2">
                    <a href="../profile/profile.php" class="quick-card">
                        <div class="quick-icon qi-orange">👤</div>
                        <h3>Profil Saya</h3>
                        <p>Lihat dan edit informasi profil serta data akunmu</p>
                        <span class="quick-arrow">Buka profil →</span>
                    </a>
                </div>
                <div class="col-6 anim-3">
                    <a href="../cari-teman/cari-teman.php" class="quick-card">
                        <div class="quick-icon qi-blue">👥</div>
                        <h3>Cari Teman</h3>
                        <p>Temukan teman belajar matematika di sekitarmu</p>
                        <span class="quick-arrow">Cari →</span>
                    </a>
                </div>
                <div class="col-6 anim-3">
                    <a href="<?php echo $discord_link; ?>" target="_blank" class="quick-card">
                        <div class="quick-icon qi-purple">💬</div>
                        <h3>Discord</h3>
                        <p>Gabung komunitas belajar bareng</p>
                        <div class="discord-time-box">
                            <div class="discord-time-label">⏰ Sekarang:</div>
                            <div id="current-time" class="discord-time-value"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- AI Tutor (right) -->
        <div class="col-lg-7 anim-2">
            <div class="ai-tutor-card h-100">
                <div class="ai-badge"><span class="ai-dot"></span>AI POWERED</div>
                <div class="ai-tutor-title">🤖 Math FamorAI</div>
                <div class="ai-tutor-desc">Tanya apa saja tentang matematika — dari rumus dasar sampai soal tersulit!</div>
                <div class="ai-chat-box">
                    <div class="ai-messages" id="ai-messages">
                        <div class="msg-bubble msg-ai">
                            <div class="msg-sender">🤖 FamorAI</div>
                            Halo <?php echo htmlspecialchars($nama); ?>! 👋 Aku FamorAI, tutor matematikamu. Mau tanya soal apa hari ini? Aku bisa bantu jelaskan materi, rumus, atau carakan soal! 🧮
                        </div>
                    </div>
                    <div class="ai-input-row">
                        <input class="ai-input" id="ai-input" type="text" placeholder="Tanya soal matematika... misal: jelaskan eksponen" maxlength="300">
                        <button class="ai-send-btn" id="ai-send-btn" onclick="sendAIMessage()">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
                <div class="ai-quick-prompts mt-3">
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan trigonometri dasar dengan contoh')">Trigonometri</span>
                    <span class="ai-prompt-chip" onclick="askAI('Apa itu fungsi komposisi dan bagaimana cara mengerjakannya?')">Fungsi Komposisi</span>
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan statistika dasar seperti mean median modus')">Statistika</span>
                    <span class="ai-prompt-chip" onclick="askAI('Apa itu relasi dan fungsi?')">Relasi Fungsi</span>
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan limit dan turunan dengan contoh sederhana')">Limit Turunan</span>
                    <span class="ai-prompt-chip" onclick="askAI('Apa itu kaidah pencacahan, permutasi, dan kombinasi?')">Pencacahan</span>
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan logika matematika dasar')">Logika</span>
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan rumus eksponen dengan contoh')">Eksponen</span>
                    <span class="ai-prompt-chip" onclick="askAI('Apa itu logaritma dan bagaimana cara menghitungnya?')">Logaritma</span>
                    <span class="ai-prompt-chip" onclick="askAI('Jelaskan baris dan deret aritmetika')">Baris Deret</span>
                    <span class="ai-prompt-chip" onclick="askAI('Bagaimana cara menghitung peluang suatu kejadian?')">Peluang</span>
                    <span class="ai-prompt-chip" onclick="askAI('Apa itu integral dan bagaimana cara menghitungnya?')">Integral</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MATERI MATEMATIKA ===== -->
    <div class="sec-head mb-3 anim-4">
        <h2 class="sec-title"><span class="sec-bar"></span><span>📖 Materi Matematika</span></h2>
        <small style="color:rgba(232,233,243,0.35);font-family:'Space Mono',monospace;font-size:0.7em;">Klik untuk buka materi</small>
    </div>
    <div class="panel-box mb-4 anim-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div class="class-tabs">
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('X')"   id="materi-btn-X">Kelas X</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XI')"  id="materi-btn-XI">Kelas XI</button>
                <button class="class-tab-btn materi-tab-btn" onclick="selectMateri('XII')" id="materi-btn-XII">Kelas XII</button>
            </div>
        </div>
        <div id="materi-X" class="tab-panel materi-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('eksponen-x')"><span class="materi-icon">⚡</span><h4>Eksponen</h4><p>Bilangan berpangkat & sifat-sifat eksponen</p><span class="badge-popular">⭐ Populer</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('logaritma-x')"><span class="materi-icon">📈</span><h4>Logaritma</h4><p>Definisi, sifat, dan penerapan logaritma</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('barisderet-x')"><span class="materi-icon">🔗</span><h4>Baris &amp; Deret</h4><p>Barisan aritmetika, geometri, deret</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('trigonometri-x')"><span class="materi-icon">📐</span><h4>Trigonometri</h4><p>Sudut, rasio trig, sin, cos, tangen</p><span class="badge-materi">Materi</span></div></div>
            </div>
        </div>
        <div id="materi-XI" class="tab-panel materi-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('fungsi-xi')"><span class="materi-icon">🔄</span><h4>Fungsi Komposisi</h4><p>Komposisi fungsi dan sifat-sifatnya</p><span class="badge-popular">⭐ Populer</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('peluang-xi')"><span class="materi-icon">🎲</span><h4>Peluang</h4><p>Ruang sampel, kejadian, peluang</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('statistika-xi')"><span class="materi-icon">📉</span><h4>Statistika</h4><p>Ukuran pemusatan & penyebaran data</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('relasifungsi-xi')"><span class="materi-icon">🗺️</span><h4>Relasi &amp; Fungsi</h4><p>Jenis fungsi dan representasinya</p><span class="badge-materi">Materi</span></div></div>
            </div>
        </div>
        <div id="materi-XII" class="tab-panel materi-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('limitturunan-xii')"><span class="materi-icon">📉</span><h4>Limit &amp; Turunan</h4><p>Konsep limit, turunan fungsi</p><span class="badge-popular">⭐ Populer</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('kaidah-xii')"><span class="materi-icon">🔢</span><h4>Kaidah Pencacahan</h4><p>Permutasi, kombinasi, aturan hitung</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('logika-xii')"><span class="materi-icon">🧠</span><h4>Logika Matematika</h4><p>Pernyataan, konjungsi, implikasi</p><span class="badge-materi">Materi</span></div></div>
                <div class="col-6 col-md-3"><div class="materi-card" onclick="bukaMateri('integral-xii')"><span class="materi-icon">∫</span><h4>Integral</h4><p>Integral tak tentu, tentu & aplikasi</p><span class="badge-materi">Materi</span></div></div>
            </div>
        </div>
    </div>

    <!-- ===== LATIHAN SOAL ===== -->
    <div class="sec-head mb-3">
        <h2 class="sec-title"><span class="sec-bar"></span><span>📝 Latihan Soal</span></h2>
        <small style="color:rgba(232,233,243,0.35);font-family:'Space Mono',monospace;font-size:0.7em;">via Quizzory</small>
    </div>
    <div class="panel-box mb-4">
        <div class="class-tabs mb-3">
            <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('X')"   id="latihan-btn-X">Kelas X</button>
            <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XI')"  id="latihan-btn-XI">Kelas XI</button>
            <button class="class-tab-btn latihan-tab-btn" onclick="selectLatihan('XII')" id="latihan-btn-XII">Kelas XII</button>
        </div>
        <div id="latihan-X" class="tab-panel latihan-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b015973bce17d35ef0ae3e" target="_blank" class="topic-card"><span class="topic-icon">⚡</span><h4>Eksponen</h4><p>Latihan soal eksponen</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b0221ae151768d0424a152" target="_blank" class="topic-card"><span class="topic-icon">📈</span><h4>Logaritma</h4><p>Latihan soal logaritma</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b033d43bce17d35ef268cd" target="_blank" class="topic-card"><span class="topic-icon">🔗</span><h4>Baris &amp; Deret</h4><p>Latihan baris & deret</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b377e83bce17d35e11d836" target="_blank" class="topic-card"><span class="topic-icon">📐</span><h4>Trigonometri</h4><p>Latihan trigonometri</p><span class="topic-badge">Kerjakan →</span></a></div>
            </div>
        </div>
        <div id="latihan-XI" class="tab-panel latihan-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b264e0e7af599f6eef4053" target="_blank" class="topic-card"><span class="topic-icon">🔄</span><h4>Fungsi Komposisi</h4><p>Latihan fungsi komposisi</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b26fccffacacde881aca9c" target="_blank" class="topic-card"><span class="topic-icon">🎲</span><h4>Peluang</h4><p>Latihan soal peluang</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b08b96ffacacde8808b7f0" target="_blank" class="topic-card"><span class="topic-icon">📉</span><h4>Statistika</h4><p>Latihan statistika</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69ce7f75c030dc218433bcc4" target="_blank" class="topic-card"><span class="topic-icon">🗺️</span><h4>Relasi &amp; Fungsi</h4><p>Latihan relasi & fungsi</p><span class="topic-badge">Kerjakan →</span></a></div>
            </div>
        </div>
        <div id="latihan-XII" class="tab-panel latihan-panel">
            <div class="row g-3">
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b2ace7e7af599f6ef35a7e" target="_blank" class="topic-card"><span class="topic-icon">📉</span><h4>Limit &amp; Turunan</h4><p>Latihan limit & turunan</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b2bf8bffacacde881f61ca" target="_blank" class="topic-card"><span class="topic-icon">🔢</span><h4>Kaidah Pencacahan</h4><p>Latihan kaidah pencacahan</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69ce8440f7e103e1127f7079" target="_blank" class="topic-card"><span class="topic-icon">🧠</span><h4>Logika Matematika</h4><p>Latihan logika matematika</p><span class="topic-badge">Kerjakan →</span></a></div>
                <div class="col-6 col-md-3"><a href="https://quizzory.in/id/69b2b5523bce17d35e0b9eea" target="_blank" class="topic-card"><span class="topic-icon">∫</span><h4>Integral</h4><p>Latihan soal integral</p><span class="topic-badge">Kerjakan →</span></a></div>
            </div>
        </div>
    </div>

</div><!-- /.container -->

<!-- Modal Materi -->
<div class="modal fade" id="materiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content materi-modal-content">
            <div class="modal-header materi-modal-header">
                <div>
                    <span id="modal-kelas-badge" class="modal-kelas-badge"></span>
                    <h5 class="modal-title mt-2" id="materiModalLabel"></h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body materi-modal-body" id="materiModalBody"></div>
            <div class="modal-footer materi-modal-footer">
                <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i>Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="site-footer">
    <div class="container-fluid dashboard-shell footer-shell">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <img src="../assets/images/logo.jpeg" alt="Logo" class="footer-logo">
                    <div><div class="footer-brand">FamoraLearn</div><div class="footer-brand-sub">by Famora Education</div></div>
                </div>
                <p class="footer-desc">Platform belajar matematika interaktif untuk siswa SMA.</p>
            </div>
            <div class="col-md-4">
                <h6 class="footer-heading">Hubungi Kami</h6>
                <ul class="footer-list">
                    <li><i class="bi bi-envelope-fill"></i><a href="mailto:admin@famoralearn.my.id">admin@famoralearn.my.id</a></li>
                    <li><i class="bi bi-geo-alt-fill"></i>SMKN 1 Cikarang Selatan, Kab. Bekasi</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="footer-heading">Ikuti Kami</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="https://www.instagram.com/famoralearn_/" target="_blank" class="footer-social"><i class="bi bi-instagram"></i> Instagram</a>
                    <a href="https://www.tiktok.com/@famoralearn_id" target="_blank" class="footer-social tiktok-social"><i class="bi bi-tiktok"></i> TikTok</a>
                </div>
                <div class="mt-2"><small class="footer-desc">Produk: <strong class="text-light-footer">FamoraLearn</strong> by Famora Education</small></div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-1">
            <p class="footer-copy mb-0">© 2026 Famora Education. Semua hak dilindungi.</p>
            <p class="footer-copy mb-0">Made by FamoraEducation TJKT A</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="dashboard.js"></script>
</body>
</html>
