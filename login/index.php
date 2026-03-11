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
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['nama']     = $user['nama'];
            $_SESSION['kelas']    = $user['kelas'];
            $_SESSION['kecamatan']= $user['kecamatan'];

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
    <title>Login - MathLearn</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="login.css">
</head>
<body data-theme="dark">

    <button class="theme-toggle-fixed" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="login-container">
        <div class="logo">
            <span class="logo-icon">📐</span>
            <h1>MathLearn</h1>
            <p>BELAJAR MATEMATIKA</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-full" style="margin-top:8px;">
                Masuk
            </button>
        </form>

        <div class="divider"><span>atau</span></div>

        <a href="../register/register.php" style="text-decoration:none;">
            <button class="btn btn-secondary btn-full">Buat Akun Baru</button>
        </a>
    </div>

    <script src="../assets/js/theme.js"></script>
    <script src="login.js"></script>
</body>
</html>
