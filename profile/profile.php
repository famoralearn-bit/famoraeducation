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

// ---- Update profil (nama + kelas + kecamatan) ----
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

// ---- Ganti password ----
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - MathLearn</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body data-theme="dark">

    <nav class="navbar">
        <a href="../dashboard/dashboard.php" class="brand">MathLearn</a>
        <div class="nav-links">
            <a href="../dashboard/dashboard.php">Dashboard</a>
            <a href="profile.php" class="active">Profil</a>
            <a href="../cari-teman/cari-teman.php">Cari Teman</a>
            <button class="theme-toggle" onclick="toggleTheme()">
                <span id="theme-icon">🌙</span>
                <span id="theme-text">Dark</span>
            </button>
            <a href="../logout/logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <div class="container">

        <!-- Info Profil -->
        <div class="card">
            <div class="profile-header-card">
                <div class="profile-avatar">👤</div>
                <h1><?php echo htmlspecialchars($user['nama']); ?></h1>
                <p>Kelas <?php echo $user['kelas']; ?> • <?php echo $user['kecamatan']; ?></p>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">EMAIL</div>
                    <div class="value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">KELAS</div>
                    <div class="value"><?php echo $user['kelas']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">KECAMATAN</div>
                    <div class="value"><?php echo $user['kecamatan']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">BERGABUNG</div>
                    <div class="value"><?php echo date('d M Y', strtotime($user['created_at'])); ?></div>
                </div>
            </div>
        </div>

        <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
        <?php if ($error):   ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>

        <!-- Edit Profil -->
        <div class="card">
            <h2 class="form-section-title">✏️ Edit Profil</h2>
            <p class="form-note">Kamu bisa mengubah nama, kelas, dan kecamatan.</p>
            <form method="POST" novalidate>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" required>
                        <option value="X"   <?php echo $user['kelas']=='X'   ? 'selected':''; ?>>X</option>
                        <option value="XI"  <?php echo $user['kelas']=='XI'  ? 'selected':''; ?>>XI</option>
                        <option value="XII" <?php echo $user['kelas']=='XII' ? 'selected':''; ?>>XII</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kecamatan" required>
                        <?php foreach ($kecamatan_list as $kec): ?>
                            <option value="<?php echo $kec; ?>"
                                <?php echo $user['kecamatan']==$kec ? 'selected':''; ?>>
                                <?php echo $kec; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="btn-row">
                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="../dashboard/dashboard.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>

        <!-- Ganti Password -->
        <div class="card">
            <h2 class="form-section-title">🔒 Ganti Password</h2>
            <form method="POST" novalidate>
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="old_password" placeholder="Masukkan password lama" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter" minlength="6" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password baru" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-primary">Ganti Password</button>
            </form>
        </div>

    </div>

    <script src="../assets/js/theme.js"></script>
    <script src="profile.js"></script>
</body>
</html>
