<?php
require_once '../config/config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email    = clean_input($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['nama']      = $user['nama'];
            $_SESSION['kelas']     = $user['kelas'];
            $_SESSION['kecamatan'] = $user['kecamatan'];
            $uid = $user['id'];
            $conn->query("INSERT INTO login_history (user_id) VALUES ($uid)");
            header("Location: ../dashboard/dashboard.php");
            exit();
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FamoraLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="login.css">
</head>
<body data-theme="dark">

    <button class="theme-toggle-fixed" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="login-container">

            <!-- Logo & Brand -->
            <div class="text-center mb-4">
                <img src="../assets/images/famora.png" alt="FamoraLearn Logo" class="brand-logo-img mb-3">
                <h1 class="logo-title">FamoraLearn</h1>
                <p class="logo-sub">PLATFORM BELAJAR MATEMATIKA</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate autocomplete="off">
                <div class="mb-4">
                    <label for="email" class="form-label custom-label">
                        <i class="bi bi-envelope me-1"></i> Email
                    </label>
                    <input type="email" id="email" name="email"
                           class="form-control custom-input"
                           placeholder="contoh@email.com"
                           required autocomplete="off">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label custom-label">
                        <i class="bi bi-lock me-1"></i> Password
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="password"
                               class="form-control custom-input"
                               placeholder="Masukkan password"
                               required autocomplete="new-password">
                        <button class="btn custom-eye-btn" type="button" id="toggle-password" tabindex="-1">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login" class="btn btn-custom-primary w-100 mt-1">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                </button>
            </form>

            <div class="divider my-4"><span>atau</span></div>

            <a href="../register/register.php" class="btn btn-custom-outline w-100">
                <i class="bi bi-person-plus me-2"></i> Buat Akun Baru
            </a>

            <p class="text-center mt-4 footer-note">
                © 2024 <strong>Famora Education</strong> · FamoraLearn
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="login.js"></script>
</body>
</html>
