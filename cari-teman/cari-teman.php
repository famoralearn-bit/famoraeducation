<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
update_last_seen($user_id);

$filter_kelas     = isset($_GET['kelas'])     ? clean_input($_GET['kelas'])     : '';
$filter_kecamatan = isset($_GET['kecamatan']) ? clean_input($_GET['kecamatan']) : '';
$search_nama      = isset($_GET['search'])    ? clean_input($_GET['search'])    : '';

$query = "SELECT id, nama, kelas, kecamatan, last_seen FROM users WHERE id != $user_id";
if ($filter_kelas)     $query .= " AND kelas = '$filter_kelas'";
if ($filter_kecamatan) $query .= " AND kecamatan = '$filter_kecamatan'";
if ($search_nama)      $query .= " AND nama LIKE '%$search_nama%'";
$query .= " ORDER BY last_seen DESC, nama ASC";

$result = $conn->query($query);
$users  = [];
$online_count = 0;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['is_online'] = is_user_online($row['last_seen']);
        if ($row['is_online']) $online_count++;
        $users[] = $row;
    }
}

$kecamatan_list = [
    'Cikarang','Tambun','Babelan','Bojongmangu','Cibarusah',
    'Cibitung','Karangbahagia','Kedungwaringin','Muaragembong',
    'Pebayuran','Serang Baru','Setu','Sukaraya','Sukatani',
    'Sukawangi','Tambelang','Tarumajaya','Cabangbungin'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Teman - FamoraLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="cari-teman.css">
</head>
<body data-theme="dark">

    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand brand-logo" href="../dashboard/dashboard.php">
                <img src="../assets/images/famora.png" alt="Logo" class="nav-logo-img">
                FamoraLearn
            </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="../dashboard/dashboard.php"><i class="bi bi-house me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../profile/profile.php"><i class="bi bi-person me-1"></i>Profil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cari-teman.php"><i class="bi bi-people me-1"></i>Cari Teman</a></li>
                    <li class="nav-item">
                        <button class="btn nav-theme-btn" onclick="toggleTheme()">
                            <span id="theme-icon">🌙</span><span id="theme-text">Dark</span>
                        </button>
                    </li>
                    <li class="nav-item"><a class="nav-link nav-logout" href="../logout/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <div class="mb-4">
            <h1 class="page-title">🔍 Cari Teman Belajar</h1>
            <p class="page-sub">Temukan teman sekelas atau sesama pelajar matematika</p>
        </div>

        <!-- Stats -->
        <div class="stats-bar mb-4">
            <span class="stat-item"><span class="dot-online"></span> Online: <strong id="online-count"><?php echo $online_count; ?></strong></span>
            <span class="stat-item"><span class="dot-offline"></span> Offline: <strong id="offline-count"><?php echo count($users) - $online_count; ?></strong></span>
            <span class="stat-item">Total: <strong id="total-count"><?php echo count($users); ?></strong> pengguna</span>
            <span class="live-badge"><span class="live-dot"></span> Live</span>
        </div>

        <!-- Search -->
        <div class="search-panel mb-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label custom-label"><i class="bi bi-search me-1"></i> Cari Nama</label>
                    <input type="text" name="search" class="form-control custom-input"
                           placeholder="Ketik nama..."
                           value="<?php echo htmlspecialchars($search_nama); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label custom-label"><i class="bi bi-journal-bookmark me-1"></i> Kelas</label>
                    <select name="kelas" class="form-select custom-input">
                        <option value="">Semua Kelas</option>
                        <option value="X"   <?php echo $filter_kelas=='X'   ? 'selected':''; ?>>X</option>
                        <option value="XI"  <?php echo $filter_kelas=='XI'  ? 'selected':''; ?>>XI</option>
                        <option value="XII" <?php echo $filter_kelas=='XII' ? 'selected':''; ?>>XII</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label custom-label"><i class="bi bi-geo-alt me-1"></i> Kecamatan</label>
                    <select name="kecamatan" class="form-select custom-input">
                        <option value="">Semua Kecamatan</option>
                        <?php foreach ($kecamatan_list as $kec): ?>
                            <option value="<?php echo $kec; ?>" <?php echo $filter_kecamatan==$kec ? 'selected':''; ?>>
                                <?php echo $kec; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-custom-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Tabs -->
        <div class="d-flex gap-2 mb-4 flex-wrap">
            <button class="filter-tab" onclick="filterUsers('all', this)">Semua</button>
            <button class="filter-tab active" onclick="filterUsers('online', this)">🟢 Online</button>
            <button class="filter-tab" onclick="filterUsers('offline', this)">⚫ Offline</button>
        </div>

        <!-- Users Grid -->
        <div class="row g-3" id="users-grid">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 user-card-wrap
                                <?php echo $u['is_online'] ? 'is-online' : 'is-offline'; ?>"
                         data-status="<?php echo $u['is_online'] ? 'online' : 'offline'; ?>"
                         data-user-id="<?php echo $u['id']; ?>">
                        <div class="user-card text-center h-100">
                            <div class="user-avatar-wrap mb-2">
                                <div class="user-avatar">👤</div>
                                <div class="online-dot <?php echo $u['is_online'] ? 'online' : 'offline'; ?>"></div>
                            </div>
                            <span class="status-label <?php echo $u['is_online'] ? 'online' : 'offline'; ?> mb-2">
                                <?php echo $u['is_online'] ? '🟢 Online' : '⚫ Offline'; ?>
                            </span>
                            <h3 class="user-name"><?php echo htmlspecialchars($u['nama']); ?></h3>
                            <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                                <span class="user-badge">Kelas <?php echo $u['kelas']; ?></span>
                                <span class="user-badge"><?php echo htmlspecialchars($u['kecamatan']); ?></span>
                            </div>
                            <?php if ($u['is_online']): ?>
                                <a class="btn btn-discord w-100" href="<?php echo get_discord_link(); ?>" target="_blank">
                                    💬 Ajak Belajar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="no-results">😔 Tidak ada teman yang ditemukan</p>
                    <p class="text-muted">Coba ubah filter pencarian Anda</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="cari-teman.js"></script>
</body>
</html>
