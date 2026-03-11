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
    <title>Cari Teman - MathLearn</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="cari-teman.css">
</head>
<body data-theme="dark">

    <nav class="navbar">
        <a href="../dashboard/dashboard.php" class="brand">MathLearn</a>
        <div class="nav-links">
            <a href="../dashboard/dashboard.php">Dashboard</a>
            <a href="../profile/profile.php">Profil</a>
            <a href="cari-teman.php" class="active">Cari Teman</a>
            <button class="theme-toggle" onclick="toggleTheme()">
                <span id="theme-icon">🌙</span>
                <span id="theme-text">Dark</span>
            </button>
            <a href="../logout/logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>🔍 Cari Teman Belajar</h1>
            <p>Temukan teman sekelas atau sesama pelajar matematika</p>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-dot online"></div>
                Online: <span class="stat-count" id="online-count"><?php echo $online_count; ?></span>
            </div>
            <div class="stat-item">
                <div class="stat-dot offline"></div>
                Offline: <span class="stat-count" id="offline-count"><?php echo count($users) - $online_count; ?></span>
            </div>
            <div class="stat-item">
                Total: <span class="stat-count" id="total-count"><?php echo count($users); ?></span> pengguna
            </div>
            <div class="live-indicator">
                <div class="live-dot"></div>
                Update otomatis
            </div>
        </div>

        <!-- Search -->
        <div class="search-box">
            <form method="GET" class="search-form">
                <div class="form-group">
                    <label>Cari Nama</label>
                    <input type="text" name="search" placeholder="Ketik nama..."
                           value="<?php echo htmlspecialchars($search_nama); ?>">
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas">
                        <option value="">Semua Kelas</option>
                        <option value="X"   <?php echo $filter_kelas=='X'   ? 'selected':''; ?>>X</option>
                        <option value="XI"  <?php echo $filter_kelas=='XI'  ? 'selected':''; ?>>XI</option>
                        <option value="XII" <?php echo $filter_kelas=='XII' ? 'selected':''; ?>>XII</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kecamatan">
                        <option value="">Semua Kecamatan</option>
                        <?php foreach ($kecamatan_list as $kec): ?>
                            <option value="<?php echo $kec; ?>"
                                <?php echo $filter_kecamatan==$kec ? 'selected':''; ?>>
                                <?php echo $kec; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-search">Cari</button>
            </form>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab"        onclick="filterUsers('all',     this)">Semua</button>
            <button class="filter-tab active" onclick="filterUsers('online',  this)">🟢 Online</button>
            <button class="filter-tab"        onclick="filterUsers('offline', this)">⚫ Offline</button>
        </div>

        <!-- Users Grid -->
        <div class="users-grid" id="users-grid">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                    <div class="user-card <?php echo $u['is_online'] ? 'is-online' : 'is-offline'; ?>"
                         data-status="<?php echo $u['is_online'] ? 'online' : 'offline'; ?>"
                         data-user-id="<?php echo $u['id']; ?>">

                        <div class="user-avatar-wrap">
                            <div class="user-avatar">👤</div>
                            <div class="online-dot <?php echo $u['is_online'] ? 'online' : 'offline'; ?>"></div>
                        </div>

                        <span class="status-label <?php echo $u['is_online'] ? 'online' : 'offline'; ?>">
                            <span class="dot"></span>
                            <?php echo $u['is_online'] ? 'Online' : 'Offline'; ?>
                        </span>

                        <h3><?php echo htmlspecialchars($u['nama']); ?></h3>
                        <div>
                            <span class="user-badge">Kelas <?php echo $u['kelas']; ?></span>
                            <span class="user-badge"><?php echo htmlspecialchars($u['kecamatan']); ?></span>
                        </div>

                        <?php if ($u['is_online']): ?>
                            <a class="btn-discord" href="<?php echo get_discord_link(); ?>" target="_blank">
                                💬 Ajak Belajar
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results">
                    <p>😔 Tidak ada teman yang ditemukan</p>
                    <p style="font-size:.9em;margin-top:10px;">Coba ubah filter pencarian Anda</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../assets/js/theme.js"></script>
    <script src="cari-teman.js"></script>
</body>
</html>
