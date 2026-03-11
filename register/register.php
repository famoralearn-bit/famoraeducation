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
                $error = 'Terjadi kesalahan. Silakan coba lagi.';
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
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="register.css">
</head>
<body data-theme="dark">

    <button class="theme-toggle-fixed" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="register-container">
        <div class="logo">
            <h1>MathLearn</h1>
            <p>DAFTAR AKUN BARU</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama"
                       value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                       placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                       placeholder="contoh@email.com" required>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select id="kelas" name="kelas" required>
                    <option value="">Pilih Kelas</option>
                    <option value="X"   <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='X')   ? 'selected':''; ?>>X</option>
                    <option value="XI"  <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='XI')  ? 'selected':''; ?>>XI</option>
                    <option value="XII" <?php echo (isset($_POST['kelas']) && $_POST['kelas']=='XII') ? 'selected':''; ?>>XII</option>
                </select>
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <select id="kecamatan" name="kecamatan" required>
                    <option value="">Pilih Kecamatan</option>
                    <?php foreach ($kecamatan_list as $kec): ?>
                        <option value="<?php echo $kec; ?>"
                            <?php echo (isset($_POST['kecamatan']) && $_POST['kecamatan']==$kec) ? 'selected':''; ?>>
                            <?php echo $kec; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="divider-line"></div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Minimal 6 karakter" minlength="6" required>
                <!-- Strength indicator -->
                <div style="margin-top:8px; height:4px; border-radius:4px; background:var(--border); overflow:hidden;">
                    <div id="strength-bar" style="height:100%; width:0; transition:all 0.3s;"></div>
                </div>
                <span id="strength-text" style="font-size:0.8em; color:var(--accent); margin-top:4px; display:block;"></span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;">
                Daftar Sekarang
            </button>
        </form>

        <div class="back-link">
            <a href="../login/index.php">← Sudah punya akun? Login di sini</a>
        </div>
    </div>

    <script src="../assets/js/theme.js"></script>
    <script src="register.js"></script>
</body>
</html>
