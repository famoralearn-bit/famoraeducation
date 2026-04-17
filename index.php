<?php
require_once 'config/config.php';

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/dashboard.php");
    exit();
}
// Halaman ini publik — tidak redirect ke login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FamoraLearn — Platform Belajar Matematika</title>

    <link rel="icon" type="image/jpeg" href="assets/images/logo.jpeg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:    #2D3250;
            --secondary:  #424769;
            --accent:     #7077A1;
            --light:      #F6B17A;
            --bg:         #1a1d2e;
            --text:       #e8e9f3;
            --text-muted: #9fa3c2;
            --border:     rgba(255,255,255,0.1);
            --card-bg:    rgba(45,50,80,0.65);
            --glass:      rgba(45,50,80,0.45);
        }
        [data-theme="light"] {
            --primary:    #ffffff;
            --secondary:  #f8fafc;
            --accent:     #5a67d8;
            --light:      #d97706;
            --bg:         #ffffff;
            --text:       #1a202c;
            --text-muted: #64748b;
            --border:     #e2e8f0;
            --card-bg:    #ffffff;
            --glass:      rgba(255, 255, 255, 0.92);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Crimson Pro', serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            transition: background 0.3s, color 0.3s;
        }
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: -1;
            background:
                radial-gradient(ellipse 60% 50% at 10% 5%,  rgba(246,177,122,0.12), transparent),
                radial-gradient(ellipse 50% 40% at 90% 15%, rgba(112,119,161,0.18), transparent),
                radial-gradient(ellipse 70% 60% at 50% 90%, rgba(86,108,255,0.10), transparent),
                linear-gradient(180deg, #141726 0%, #1a1d2e 60%, #12152a 100%);
        }
        body[data-theme="light"] {
            background: #ffffff !important;
        }
        body[data-theme="light"]::before {
            background:
                radial-gradient(ellipse 65% 55% at 10% 5%,  rgba(217,119,6,0.04), transparent),
                radial-gradient(ellipse 55% 45% at 90% 15%, rgba(90,103,216,0.03), transparent),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 60%, #f1f5f9 100%);
        }
        /* ─── NAVBAR ─── */
        .site-nav {
            position: sticky; top: 0; z-index: 999;
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 clamp(16px, 4vw, 48px);
            min-height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Space Mono', monospace;
            font-size: 1.15em; font-weight: 700;
            color: var(--light) !important; text-decoration: none;
        }
        .nav-brand img {
            width: 34px; height: 34px; border-radius: 50%;
            border: 2px solid rgba(246,177,122,0.4); object-fit: cover;
        }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .nav-theme-btn {
            background: transparent;
            border: 1.5px solid var(--border); border-radius: 50px;
            padding: 6px 14px; font-family: 'Space Mono', monospace; font-size: 0.75em;
            color: var(--text); cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .nav-theme-btn:hover { border-color: var(--light); color: var(--light); }
        .btn-nav-login {
            background: linear-gradient(135deg, var(--light), #e89f6a);
            color: #2d3748 !important; border: none; border-radius: 10px;
            padding: 8px 22px; font-family: 'Space Mono', monospace;
            font-size: 0.78em; font-weight: 700; text-decoration: none;
            transition: all 0.2s; box-shadow: 0 4px 14px rgba(246,177,122,0.3);
            white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-nav-login:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(246,177,122,0.45); color: #2d3748 !important; }
        .btn-nav-register {
            background: transparent; border: 1.5px solid var(--accent); border-radius: 10px;
            padding: 7px 18px; font-family: 'Space Mono', monospace; font-size: 0.78em;
            font-weight: 700; color: var(--accent) !important; text-decoration: none;
            transition: all 0.2s; white-space: nowrap;
        }
        .btn-nav-register:hover { background: var(--accent); color: #fff !important; transform: translateY(-2px); }
        /* ─── HERO ─── */
        .hero {
            min-height: calc(100vh - 64px);
            display: flex; align-items: center; justify-content: center;
            padding: clamp(48px, 8vh, 100px) clamp(16px, 5vw, 80px);
            position: relative;
        }
        .hero-content { max-width: 680px; text-align: center; animation: fadeUp 0.8s ease both; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(246,177,122,0.12); border: 1px solid rgba(246,177,122,0.3);
            border-radius: 50px; padding: 6px 16px;
            font-family: 'Space Mono', monospace; font-size: 0.75em;
            color: var(--light); letter-spacing: 1px; margin-bottom: 28px;
            animation: fadeUp 0.7s ease 0.1s both;
        }
        .hero-badge .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #52ff9a; box-shadow: 0 0 6px #52ff9a;
            animation: pulse 2s infinite; flex-shrink: 0;
        }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .hero-title {
            font-family: 'Space Mono', monospace;
            font-size: clamp(2.2em, 6vw, 3.8em);
            font-weight: 700; line-height: 1.15; color: var(--text);
            margin-bottom: 20px; animation: fadeUp 0.7s ease 0.2s both;
        }
        .hero-title span { color: var(--light); }
        .hero-desc {
            font-size: clamp(1.1em, 2.5vw, 1.3em);
            color: var(--text-muted); line-height: 1.7; margin-bottom: 40px;
            animation: fadeUp 0.7s ease 0.3s both;
        }
        .hero-cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; animation: fadeUp 0.7s ease 0.4s both; }
        .btn-cta-primary {
            background: linear-gradient(135deg, var(--light), #e08a50);
            color: #1a1d2e !important; font-weight: 700;
            font-family: 'Space Mono', monospace; font-size: 0.9em;
            padding: 14px 32px; border-radius: 14px; text-decoration: none;
            box-shadow: 0 6px 24px rgba(246,177,122,0.35); transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cta-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(246,177,122,0.5); color: #1a1d2e !important; }
        .btn-cta-secondary {
            background: var(--card-bg); border: 1.5px solid var(--border);
            color: var(--text) !important; font-family: 'Space Mono', monospace;
            font-size: 0.9em; padding: 13px 28px; border-radius: 14px;
            text-decoration: none; backdrop-filter: blur(10px); transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cta-secondary:hover { border-color: var(--accent); color: var(--light) !important; transform: translateY(-3px); }
        /* Floating math symbols */
        .hero-floats { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
        .float-sym {
            position: absolute; font-family: 'Space Mono', monospace;
            font-size: clamp(1.2em, 3vw, 2.2em); color: rgba(112,119,161,0.18);
            animation: floatSym 18s ease-in-out infinite; user-select: none;
        }
        .float-sym:nth-child(1){top:12%;left:5%;animation-delay:0s;animation-duration:16s;}
        .float-sym:nth-child(2){top:25%;right:7%;animation-delay:-4s;animation-duration:20s;}
        .float-sym:nth-child(3){top:60%;left:8%;animation-delay:-8s;animation-duration:14s;}
        .float-sym:nth-child(4){top:75%;right:6%;animation-delay:-12s;animation-duration:22s;}
        .float-sym:nth-child(5){top:45%;left:2%;animation-delay:-6s;animation-duration:18s;}
        .float-sym:nth-child(6){top:15%;right:3%;animation-delay:-2s;animation-duration:24s;}
        @keyframes floatSym { 0%,100%{transform:translateY(0) rotate(0deg);opacity:.18;} 33%{transform:translateY(-22px) rotate(8deg);opacity:.28;} 66%{transform:translateY(14px) rotate(-5deg);opacity:.14;} }
        /* ─── STATS STRIP ─── */
        .stats-strip {
            background: var(--card-bg); backdrop-filter: blur(16px);
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
            padding: 28px clamp(16px, 5vw, 80px);
        }
        .stat-item { text-align: center; padding: 8px; }
        .stat-num { font-family: 'Space Mono', monospace; font-size: clamp(1.6em,4vw,2.4em); font-weight: 700; color: var(--light); line-height: 1; }
        .stat-label { font-size: 0.9em; color: var(--text-muted); margin-top: 4px; }
        /* ─── FEATURES ─── */
        .features { padding: clamp(60px,8vw,100px) clamp(16px,5vw,80px); }
        .section-tag {
            display: inline-block; font-family: 'Space Mono', monospace; font-size: 0.72em;
            letter-spacing: 2px; color: var(--light); border: 1px solid rgba(246,177,122,0.3);
            background: rgba(246,177,122,0.08); border-radius: 50px; padding: 4px 14px; margin-bottom: 16px;
        }
        .section-title { font-family: 'Space Mono', monospace; font-size: clamp(1.6em,4vw,2.4em); font-weight: 700; color: var(--text); margin-bottom: 12px; }
        .section-title span { color: var(--light); }
        .section-desc { color: var(--text-muted); font-size: 1.1em; max-width: 520px; line-height: 1.7; }
        .feature-card {
            background: var(--card-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--border); border-radius: 20px; padding: 30px 26px;
            transition: all 0.3s; height: 100%;
        }
        .feature-card:hover { transform: translateY(-6px); border-color: rgba(246,177,122,0.35); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
        .feature-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.6em; margin-bottom: 18px; }
        .fi-orange{background:rgba(246,177,122,0.15);} .fi-blue{background:rgba(86,108,255,0.15);} .fi-green{background:rgba(82,255,154,0.12);} .fi-purple{background:rgba(160,100,255,0.15);}
        .feature-title { font-family: 'Space Mono', monospace; font-size: 1em; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .feature-desc { color: var(--text-muted); font-size: 0.98em; line-height: 1.65; }
        /* ─── FORMULA TICKER ─── */
        .formula-strip {
            background: linear-gradient(135deg, rgba(45,50,80,0.8), rgba(26,29,46,0.9));
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
            padding: 18px 0; overflow: hidden;
        }
        [data-theme="light"] .formula-strip {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }
        .formula-ticker { display: flex; gap: 40px; white-space: nowrap; animation: ticker 28s linear infinite; }
        .formula-ticker span { font-family: 'Space Mono', monospace; font-size: 0.88em; color: var(--accent); padding: 0 8px; }
        .formula-ticker span.sep { color: rgba(246,177,122,0.4); }
        @keyframes ticker { from{transform:translateX(0);} to{transform:translateX(-50%);} }
        /* ─── HOW IT WORKS ─── */
        .how-it-works { padding: clamp(60px,8vw,100px) clamp(16px,5vw,80px); }
        .step-card { text-align: center; padding: 10px; }
        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--light), #e08a50);
            color: #1a1d2e; font-family: 'Space Mono', monospace; font-size: 1.3em; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px; box-shadow: 0 6px 20px rgba(246,177,122,0.3);
        }
        .step-title { font-family: 'Space Mono', monospace; font-size: 0.95em; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .step-desc { color: var(--text-muted); font-size: 0.95em; line-height: 1.6; }
        .step-connector { display: flex; align-items: center; justify-content: center; color: rgba(246,177,122,0.4); font-size: 1.5em; padding-top: 28px; }
        /* ─── CTA ─── */
        .cta-section { padding: clamp(60px,8vw,100px) clamp(16px,5vw,80px); text-align: center; }
        .cta-box {
            background: var(--card-bg); backdrop-filter: blur(20px);
            border: 1px solid rgba(246,177,122,0.25); border-radius: 28px;
            padding: clamp(40px,6vw,72px) clamp(24px,6vw,72px);
            max-width: 700px; margin: 0 auto; position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 220px; height: 220px; border-radius: 50%;
            background: radial-gradient(circle, rgba(246,177,122,0.18), transparent 70%);
            pointer-events: none;
        }
        .cta-title { font-family: 'Space Mono', monospace; font-size: clamp(1.5em,4vw,2.2em); font-weight: 700; color: var(--text); margin-bottom: 16px; }
        .cta-title span { color: var(--light); }
        .cta-desc { color: var(--text-muted); font-size: 1.05em; margin-bottom: 32px; line-height: 1.7; }
        /* ─── FOOTER ─── */
        .site-footer {
            background: var(--card-bg); backdrop-filter: blur(16px);
            border-top: 1px solid var(--border); padding: 32px clamp(16px,5vw,80px); text-align: center;
        }
        .footer-brand { font-family: 'Space Mono', monospace; font-weight: 700; color: var(--light); font-size: 1.1em; margin-bottom: 8px; }
        .footer-note { color: var(--text-muted); font-size: 0.9em; }
        /* ─── LIGHT MODE OVERRIDES ─── */
        body[data-theme="light"] .hero-badge {
            background: rgba(217,119,6,0.08);
            border-color: rgba(217,119,6,0.25);
        }
        body[data-theme="light"] .stats-strip {
            background: #f8fafc;
        }
        body[data-theme="light"] .feature-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        body[data-theme="light"] .feature-card:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.10);
        }
        body[data-theme="light"] .cta-box {
            background: #ffffff;
            border-color: rgba(217,119,6,0.2);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        body[data-theme="light"] .site-nav {
            background: rgba(255,255,255,0.95);
            border-bottom-color: #e2e8f0;
        }
        body[data-theme="light"] .btn-cta-secondary {
            background: #ffffff;
            border-color: #cbd5e0;
            color: #1a202c !important;
        }
        body[data-theme="light"] .site-footer {
            background: #f8fafc;
            border-top-color: #e2e8f0;
        }
        /* ─── ANIMATIONS ─── */
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .anim-delay-1{transition-delay:.1s;} .anim-delay-2{transition-delay:.2s;} .anim-delay-3{transition-delay:.3s;} .anim-delay-4{transition-delay:.4s;}
        @media(max-width:768px){.step-connector{display:none;}.hero-title{font-size:2em;}}
    </style>
</head>
<body data-theme="dark">

<!-- NAVBAR -->
<nav class="site-nav">
    <a href="index.php" class="nav-brand">
        <img src="assets/images/logo.jpeg" alt="Logo">
        FamoraLearn
    </a>
    <div class="nav-right">
        <button class="nav-theme-btn" onclick="toggleTheme()">
            <span id="theme-icon">🌙</span>
            <span id="theme-text">Dark</span>
        </button>
        <a href="register/register.php" class="btn-nav-register d-none d-sm-inline-flex">Daftar</a>
        <a href="login/index.php" class="btn-nav-login">
            <i class="bi bi-box-arrow-in-right"></i>Login
        </a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-floats" aria-hidden="true">
        <span class="float-sym">∑</span><span class="float-sym">π</span>
        <span class="float-sym">√</span><span class="float-sym">∫</span>
        <span class="float-sym">∞</span><span class="float-sym">Δ</span>
    </div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="dot"></span>
            PLATFORM AKTIF · GRATIS UNTUK PELAJAR
        </div>
        <h1 class="hero-title">
            Kuasai <span>Matematika</span><br>Langkah demi Langkah
        </h1>
        <p class="hero-desc">
            FamoraLearn adalah platform belajar matematika interaktif dengan AI Tutor, materi lengkap, dan komunitas pelajar aktif. Dari eksponen sampai integral — semua ada di sini.
        </p>
        <div class="hero-cta">
            <a href="register/register.php" class="btn-cta-primary">
                <i class="bi bi-rocket-takeoff"></i>Mulai Belajar Gratis
            </a>
            <a href="login/index.php" class="btn-cta-secondary">
                <i class="bi bi-box-arrow-in-right"></i>Sudah Punya Akun
            </a>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-strip reveal">
    <div class="row g-0 justify-content-center">
        <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">12+</div><div class="stat-label">Topik Materi</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">12+</div><div class="stat-label">Latihan Soal</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">🤖</div><div class="stat-label">AI Tutor Aktif</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">100%</div><div class="stat-label">Gratis Diakses</div></div></div>
    </div>
</div>

<!-- FORMULA TICKER -->
<div class="formula-strip" aria-hidden="true">
    <div class="formula-ticker">
        <span>aᵐ · aⁿ = aᵐ⁺ⁿ</span><span class="sep">✦</span>
        <span>sin²θ + cos²θ = 1</span><span class="sep">✦</span>
        <span>P(A) = n(A) / n(S)</span><span class="sep">✦</span>
        <span>∫xⁿ dx = xⁿ⁺¹/(n+1) + C</span><span class="sep">✦</span>
        <span>lim x→∞ (1+1/x)ˣ = e</span><span class="sep">✦</span>
        <span>log_a(bc) = log_a(b) + log_a(c)</span><span class="sep">✦</span>
        <span>det(A) = ad − bc</span><span class="sep">✦</span>
        <span>f'(x) = lim [f(x+h)−f(x)]/h</span><span class="sep">✦</span>
        <!-- duplicate for seamless loop -->
        <span>aᵐ · aⁿ = aᵐ⁺ⁿ</span><span class="sep">✦</span>
        <span>sin²θ + cos²θ = 1</span><span class="sep">✦</span>
        <span>P(A) = n(A) / n(S)</span><span class="sep">✦</span>
        <span>∫xⁿ dx = xⁿ⁺¹/(n+1) + C</span><span class="sep">✦</span>
        <span>lim x→∞ (1+1/x)ˣ = e</span><span class="sep">✦</span>
        <span>log_a(bc) = log_a(b) + log_a(c)</span><span class="sep">✦</span>
        <span>det(A) = ad − bc</span><span class="sep">✦</span>
        <span>f'(x) = lim [f(x+h)−f(x)]/h</span><span class="sep">✦</span>
    </div>
</div>

<!-- FEATURES -->
<section class="features">
    <div class="row g-0 mb-5 align-items-end reveal">
        <div class="col-lg-6">
            <span class="section-tag">✦ FITUR UNGGULAN</span>
            <h2 class="section-title">Semua yang Kamu <span>Butuhkan</span></h2>
            <p class="section-desc">Dari materi interaktif hingga AI Tutor yang siap menjawab soal apapun — FamoraLearn hadir lengkap.</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3 reveal anim-delay-1">
            <div class="feature-card">
                <div class="feature-icon fi-orange">🤖</div>
                <div class="feature-title">AI Tutor FamorAI</div>
                <p class="feature-desc">Tanya soal matematika apapun dan dapatkan penjelasan langkah demi langkah dari AI yang cerdas.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal anim-delay-2">
            <div class="feature-card">
                <div class="feature-icon fi-blue">📚</div>
                <div class="feature-title">Materi Lengkap</div>
                <p class="feature-desc">12+ topik mulai dari Eksponen, Trigonometri, Integral, hingga Peluang sesuai kurikulum SMA.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal anim-delay-3">
            <div class="feature-card">
                <div class="feature-icon fi-green">👥</div>
                <div class="feature-title">Cari Teman Belajar</div>
                <p class="feature-desc">Temukan teman matematika di kotamu dan belajar bareng lewat komunitas yang aktif.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal anim-delay-4">
            <div class="feature-card">
                <div class="feature-icon fi-purple">💬</div>
                <div class="feature-title">Komunitas Discord</div>
                <p class="feature-desc">Gabung server Discord eksklusif, diskusi soal, dan belajar bersama pelajar dari seluruh Indonesia.</p>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-it-works">
    <div class="text-center mb-5 reveal">
        <span class="section-tag">✦ CARA KERJA</span>
        <h2 class="section-title">Mulai dalam <span>3 Langkah</span></h2>
    </div>
    <div class="row g-4 justify-content-center reveal">
        <div class="col-6 col-md-3 col-lg-2">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-title">Daftar Akun</div>
                <p class="step-desc">Buat akun gratis dengan email. Selesai dalam 1 menit.</p>
            </div>
        </div>
        <div class="col-auto d-none d-md-flex step-connector">›</div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-title">Pilih Materi</div>
                <p class="step-desc">Jelajahi topik sesuai kelasmu dan pelajari dengan mudah.</p>
            </div>
        </div>
        <div class="col-auto d-none d-md-flex step-connector">›</div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-title">Tanya Teman/FamorAI</div>
                <p class="step-desc">Diskusikan dengan teman belajar online atau FamorAI untuk mendapatkan bantuan.</p>
            </div>
        </div>
    </div>
</section> 

<!-- CTA -->
<section class="cta-section">
    <div class="cta-box reveal">
        <h2 class="cta-title">Siap <span>Belajar</span> Hari Ini?</h2>
        <p class="cta-desc">Bergabunglah bersama pelajar yang sudah merasakan manfaat belajar matematika bersama FamoraLearn. Gratis, mudah, dan menyenangkan.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="register/register.php" class="btn-cta-primary">
                <i class="bi bi-rocket-takeoff"></i>Daftar Sekarang — Gratis
            </a>
            <a href="login/index.php" class="btn-cta-secondary">
                <i class="bi bi-box-arrow-in-right"></i>Login
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-brand">FamoraLearn</div>
    <p class="footer-note">© 2026 Famora Education · Platform Belajar Matematika untuk Pelajar Indonesia</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theme.js"></script>
<script>
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.1 });
    reveals.forEach(el => io.observe(el));
</script>
</body>
</html>
