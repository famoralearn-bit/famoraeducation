<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query   = "SELECT * FROM users WHERE id = $user_id";
$user    = $conn->query($query)->fetch_assoc();

$success = '';
$error   = '';

$kecamatan_list = [
    'Cikarang','Tambun','Babelan','Bojongmangu','Cibarusah',
    'Cibitung','Karangbahagia','Kedungwaringin','Muaragembong',
    'Pebayuran','Serang Baru','Setu','Sukaraya','Sukatani',
    'Sukawangi','Tambelang','Tarumajaya','Cabangbungin'
];

// Daftar avatar yang valid
$valid_avatars = ['pria1','wanita1'];

// Update avatar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_avatar'])) {
    $av = clean_input($_POST['avatar_id']);
    if (in_array($av, $valid_avatars)) {
        $conn->query("UPDATE users SET avatar='$av' WHERE id=$user_id");
        $_SESSION['avatar'] = $av;
        $success = 'Avatar berhasil disimpan!';
        $user    = $conn->query($query)->fetch_assoc();
    }
}

// Update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nama      = clean_input($_POST['nama']);
    $kelas     = clean_input($_POST['kelas']);
    $kecamatan = clean_input($_POST['kecamatan']);
    if (empty($nama)) {
        $error = 'Nama tidak boleh kosong!';
    } else {
        if ($conn->query("UPDATE users SET nama='$nama', kelas='$kelas', kecamatan='$kecamatan' WHERE id=$user_id")) {
            $_SESSION['nama']      = $nama;
            $_SESSION['kelas']     = $kelas;
            $_SESSION['kecamatan'] = $kecamatan;
            $success = 'Profil berhasil diupdate!';
            $user    = $conn->query($query)->fetch_assoc();
        } else {
            $error = 'Gagal update profil!';
        }
    }
}

// Ganti password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $cnf = $_POST['confirm_password'];
    if (!password_verify($old, $user['password'])) {
        $error = 'Password lama salah!';
    } elseif ($new !== $cnf) {
        $error = 'Password baru tidak cocok!';
    } elseif (strlen($new) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$hash' WHERE id=$user_id");
        $success = 'Password berhasil diubah!';
    }
}

// Avatar aktif
$current_avatar = isset($user['avatar']) ? $user['avatar'] : 'pria1';
$avatar_map = [
    'pria1'   => ['emoji'=>'👦', 'label'=>'Pria',   'gender'=>'Pria'],
    'wanita1' => ['emoji'=>'👧', 'label'=>'Wanita', 'gender'=>'Wanita'],
];
$current_emoji  = $avatar_map[$current_avatar]['emoji'] ?? '👤';
$current_gender = $avatar_map[$current_avatar]['gender'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - FamoraLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body data-theme="dark">

    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand brand-logo" href="../dashboard/dashboard.php">
                <img src="../assets/images/famora.png" alt="Logo" class="nav-logo-img">
                FamoraLearn
            </a>
            <button class="navbar-toggler custom-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="../dashboard/dashboard.php"><i class="bi bi-house me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="profile.php"><i class="bi bi-person me-1"></i>Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="../cari-teman/cari-teman.php"><i class="bi bi-people me-1"></i>Cari Teman</a></li>
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

        <!-- ======== Profile Card ======== -->
        <div class="profile-card text-center mb-4">

            <!-- Avatar display besar -->
            <div class="avatar-display" id="avatarDisplay"><?php echo $current_emoji; ?></div>
            <div class="avatar-gender-badge" id="avatarGenderBadge"><?php echo $current_gender; ?></div>

            <!-- Ganti avatar — form POST ke DB -->
            <p class="avatar-label mt-2">Pilih Avatar</p>
            <form method="POST" id="avatarForm">
                <input type="hidden" name="avatar_id" id="avatarInput" value="<?php echo htmlspecialchars($current_avatar); ?>">
                <div class="avatar-selector mb-3">
                    <?php foreach ($avatar_map as $key => $av): ?>
                    <div class="avatar-option <?php echo $current_avatar === $key ? 'selected' : ''; ?>"
                         id="av-<?php echo $key; ?>"
                         onclick="pilihAvatar('<?php echo $key; ?>')"
                         title="<?php echo $av['label']; ?>">
                        <?php echo $av['emoji']; ?>
                        <span class="av-label"><?php echo $av['label']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="save_avatar" class="btn btn-save-avatar">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Avatar
                </button>
            </form>

            <hr class="my-3" style="border-color:var(--border);">

            <h1 class="profile-name"><?php echo htmlspecialchars($user['nama']); ?></h1>
            <p class="profile-sub">Kelas <?php echo $user['kelas']; ?> · <?php echo $user['kecamatan']; ?></p>

            <div class="row g-3 mt-3">
                <div class="col-6 col-md-3">
                    <div class="info-item"><div class="info-label">EMAIL</div><div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-item"><div class="info-label">KELAS</div><div class="info-value"><?php echo $user['kelas']; ?></div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-item"><div class="info-label">KECAMATAN</div><div class="info-value"><?php echo $user['kecamatan']; ?></div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-item"><div class="info-label">BERGABUNG</div><div class="info-value"><?php echo date('d M Y', strtotime($user['created_at'])); ?></div></div>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success-custom d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i><span><?php echo $success; ?></span>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger-custom d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-circle-fill"></i><span><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Edit Profil -->
            <div class="col-lg-6">
                <div class="form-card">
                    <h2 class="form-card-title">✏️ Edit Profil</h2>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label custom-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control custom-input"
                                   value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label custom-label">Kelas</label>
                            <select name="kelas" class="form-select custom-input" required>
                                <option value="X"   <?php echo $user['kelas']=='X'   ? 'selected':''; ?>>X</option>
                                <option value="XI"  <?php echo $user['kelas']=='XI'  ? 'selected':''; ?>>XI</option>
                                <option value="XII" <?php echo $user['kelas']=='XII' ? 'selected':''; ?>>XII</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label custom-label">Kecamatan</label>
                            <select name="kecamatan" class="form-select custom-input" required>
                                <?php foreach ($kecamatan_list as $kec): ?>
                                    <option value="<?php echo $kec; ?>" <?php echo $user['kecamatan']==$kec ? 'selected':''; ?>>
                                        <?php echo $kec; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="update" class="btn btn-custom-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="../dashboard/dashboard.php" class="btn btn-custom-outline">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="col-lg-6">
                <div class="form-card">
                    <h2 class="form-card-title">🔒 Ganti Password</h2>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label custom-label">Password Lama</label>
                            <input type="password" name="old_password" class="form-control custom-input"
                                   placeholder="Masukkan password lama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label custom-label">Password Baru</label>
                            <input type="password" id="new_password" name="new_password"
                                   class="form-control custom-input"
                                   placeholder="Minimal 6 karakter" minlength="6" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label custom-label">Konfirmasi Password Baru</label>
                            <input type="password" id="confirm_password" name="confirm_password"
                                   class="form-control custom-input"
                                   placeholder="Ulangi password baru" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-custom-primary">
                            <i class="bi bi-shield-lock me-1"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="profile.js"></script>
</body>
</html>
