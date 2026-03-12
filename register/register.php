<?php
require_once '../config/config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}

$error = '';
$success = '';

$kecamatan_list = [
    'Cikarang','Tambun','Babelan','Bojongmangu','Cibarusah',
    'Cibitung','Karangbahagia','Kedungwaringin','Muaragembong',
    'Pebayuran','Serang Baru','Setu','Sukaraya','Sukatani',
    'Sukawangi','Tambelang','Tarumajaya','Cabangbungin'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama             = clean_input($_POST['nama']);
    $email            = clean_input($_POST['email']);
    $kelas            = clean_input($_POST['kelas']);
    $kecamatan        = clean_input($_POST['kecamatan']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nama)) {
        $error = 'Nama lengkap tidak boleh kosong!';
    } elseif (empty($email)) {
        $error = 'Email tidak boleh kosong!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check && $check->num_rows > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
            $hash  = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nama, email, password, kelas, kecamatan)
                      VALUES ('$nama','$email','$hash','$kelas','$kecamatan')";
            if ($conn->query($query)) {
                $success = 'Registrasi berhasil! Silakan login.';
            } else {
                $error = 'Terjadi kesalahan: ' . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MathLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="register.css">
</head>
<body data-theme="dark">

    <button class="theme-toggle-fixed" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="register-container">
            <div class="text-center mb-4">
                <h1 class="logo-title">MathLearn</h1>
                <p class="logo-sub">DAFTAR AKUN BARU</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 py-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?php echo $success; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate autocomplete="off">

                <div class="mb-3">
                    <label for="nama" class="form-label custom-label">
                        <i class="bi bi-person me-1"></i> Nama Lengkap
                    </label>
                    <input type="text" id="nama" name="nama"
                           class="form-control custom-input"
                           value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                           placeholder="Masukkan nama lengkap" required autocomplete="off">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label custom-label">
                        <i class="bi bi-envelope me-1"></i> Email
                    </label>
                    <input type="email" id="email" name="email"
                           class="form-control custom-input"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           placeholder="contoh@email.com" required autocomplete="off">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label for="kelas" class="form-label custom-label">
                            <i class="bi bi-journal-bookmark me-1"></i> Kelas
                        </label>
                        <select id="kelas" name="kelas" class="form-select custom-input" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X"   <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='X')   ? 'selected':''; ?>>X</option>
                            <option value="XI"  <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='XI')  ? 'selected':''; ?>>XI</option>
                            <option value="XII" <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='XII') ? 'selected':''; ?>>XII</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="kecamatan" class="form-label custom-label">
                            <i class="bi bi-geo-alt me-1"></i> Kecamatan
                        </label>
                        <select id="kecamatan" name="kecamatan" class="form-select custom-input" required>
                            <option value="">Pilih Kecamatan</option>
                            <?php foreach ($kecamatan_list as $kec): ?>
                                <option value="<?php echo $kec; ?>"
                                    <?php echo (isset($_POST['kecamatan']) && $_POST['kecamatan']==$kec) ? 'selected':''; ?>>
                                    <?php echo $kec; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr class="custom-divider my-3">

                <div class="mb-3">
                    <label for="password" class="form-label custom-label">
                        <i class="bi bi-lock me-1"></i> Password
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="password"
                               class="form-control custom-input"
                               placeholder="Minimal 6 karakter" minlength="6"
                               required autocomplete="new-password">
                        <button class="btn custom-eye-btn" type="button" id="toggle-password" tabindex="-1">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    <!-- Strength bar -->
                    <div class="progress mt-2" style="height:4px; background:var(--border); border-radius:4px;">
                        <div id="strength-bar" class="progress-bar" style="width:0; transition:all 0.3s;"></div>
                    </div>
                    <small id="strength-text" class="text-muted mt-1 d-block"></small>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label custom-label">
                        <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password"
                           class="form-control custom-input"
                           placeholder="Ulangi password"
                           required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-custom-primary w-100">
                    <i class="bi bi-person-check me-2"></i> Daftar Sekarang
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="../login/index.php" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i> Sudah punya akun? Login di sini
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="register.js"></script>
</body>
</html>
