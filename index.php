<?php
// Root index - redirect ke login
header("Location: login/index.php");
exit();
require_once 'config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['kelas'] = $user['kelas'];
            $_SESSION['kabupaten'] = $user['kabupaten'];
            
            // Log login history
            $user_id = $user['id'];
            $conn->query("INSERT INTO login_history (user_id) VALUES ($user_id)");
            
            header("Location: dashboard.php");
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
    <title>MathLearn - Platform Belajar Matematika</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Crimson+Pro:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2D3250;
            --secondary: #424769;
            --accent: #7077A1;
            --light: #F6B17A;
            --bg: #1a1d2e;
            --text: #e8e9f3;
        }

        /* Light Mode Variables */
        [data-theme="light"] {
            --primary: #f5f7fa;
            --secondary: #ffffff;
            --accent: #5a67d8;
            --light: #ed8936;
            --bg: #edf2f7;
            --text: #2d3748;
            --border: #cbd5e0;
            --card-bg: #ffffff;
            --input-bg: #f7fafc;
            --float-color: rgba(237, 137, 54, 0.1);
        }

        /* Dark Mode Variables */
        [data-theme="dark"] {
            --primary: #2D3250;
            --secondary: #424769;
            --accent: #7077A1;
            --light: #F6B17A;
            --bg: #1a1d2e;
            --text: #e8e9f3;
            --border: rgba(255, 255, 255, 0.1);
            --card-bg: rgba(45, 50, 80, 0.7);
            --input-bg: rgba(26, 29, 46, 0.6);
            --float-color: rgba(240, 177, 122, 0.1);
        }

        body {
            font-family: 'Crimson Pro', serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--primary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            position: relative;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--float-color) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--float-color) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(20px, 30px) rotate(270deg); }
        }

        /* Theme Toggle Button - Positioned Top Right */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 50px;
            padding: 10px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-family: 'Space Mono', monospace;
            font-size: 0.9em;
            color: var(--text);
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .theme-toggle:hover {
            border-color: var(--light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .theme-toggle .icon {
            font-size: 1.2em;
        }

        .container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 60px 50px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo h1 {
            font-family: 'Space Mono', monospace;
            font-size: 2.5em;
            font-weight: 700;
            color: var(--light);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: -2px;
        }

        .logo p {
            color: var(--accent);
            margin-top: 10px;
            font-size: 1.1em;
            letter-spacing: 3px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light);
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: 1px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--border);
            border-radius: 15px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 1em;
            font-family: 'Crimson Pro', serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--light);
            box-shadow: 0 0 0 4px rgba(246, 177, 122, 0.1);
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-size: 1.1em;
            font-weight: 700;
            font-family: 'Space Mono', monospace;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--light) 0%, #e89f6a 100%);
            color: #2d3748;
            box-shadow: 0 8px 20px rgba(246, 177, 122, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(246, 177, 122, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
            margin-top: 15px;
        }

        .btn-secondary:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .error {
            background: rgba(255, 82, 82, 0.2);
            border: 1px solid rgba(255, 82, 82, 0.5);
            color: #ef4444;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            text-align: center;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--accent), transparent);
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .divider span {
            padding: 0 15px;
            color: var(--accent);
            font-size: 0.9em;
            letter-spacing: 2px;
        }
    </style>
</head>
<body data-theme="dark">
    <button class="theme-toggle" onclick="toggleTheme()">
        <span class="icon" id="theme-icon">🌙</span>
        <span id="theme-text">Dark</span>
    </button>

    <div class="container">
        <div class="logo">
            <h1>MathLearn</h1>
            <p>BELAJAR MATEMATIKA</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" name="login" class="btn btn-primary">Masuk</button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <a href="register.php" style="text-decoration: none;">
            <button class="btn btn-secondary">Buat Akun Baru</button>
        </a>
    </div>

    <script>
        // Theme Toggle Function
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            const currentTheme = body.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                body.setAttribute('data-theme', 'light');
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            body.setAttribute('data-theme', savedTheme);
            
            if (savedTheme === 'light') {
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light';
            } else {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
            }
        });
    </script>
</body>
</html>
>>>>>>> 9d115378423cb2d24e11d8792ca3a83d4ec18d83
