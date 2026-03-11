# MathLearn - Platform Belajar Matematika

## Struktur Folder

```
mathlearn/
├── index.php                   ← Root redirect
├── config/
│   └── config.php              ← Konfigurasi database & helper functions
├── database/
│   └── database.sql            ← Schema database (jalankan di phpMyAdmin)
├── assets/
│   ├── css/
│   │   └── variables.css       ← CSS variables & shared global styles
│   ├── js/
│   │   └── theme.js            ← Dark/Light mode toggle (shared)
│   └── images/                 ← Folder untuk gambar/aset
├── login/
│   ├── index.php               ← Halaman login (PHP)
│   ├── login.css               ← Styles halaman login
│   └── login.js                ← JS halaman login
├── register/
│   ├── register.php            ← Halaman daftar akun (PHP)
│   ├── register.css            ← Styles halaman register
│   └── register.js             ← JS validasi & password strength
├── dashboard/
│   ├── dashboard.php           ← Halaman dashboard utama (PHP)
│   ├── dashboard.css           ← Styles dashboard
│   └── dashboard.js            ← JS tab materi & latihan soal, jam realtime
├── profile/
│   ├── profile.php             ← Halaman profil & edit (PHP)
│   ├── profile.css             ← Styles profil
│   └── profile.js              ← JS validasi password
├── cari-teman/
│   ├── cari-teman.php          ← Halaman cari teman belajar (PHP)
│   ├── cari-teman.css          ← Styles cari teman
│   ├── cari-teman.js           ← JS filter & polling online status
│   └── online-status.php       ← API endpoint AJAX online status
└── logout/
    └── logout.php              ← Logout & session destroy
```

## Cara Setup

### 1. Persyaratan
- XAMPP / WAMP / LAMP (PHP 7.4+ dan MySQL 5.7+)
- Web browser modern

### 2. Install
1. Copy folder `mathlearn/` ke `htdocs/` (XAMPP) atau `www/` (WAMP)
2. Buka phpMyAdmin → **Import** file `database/database.sql`
3. Edit `config/config.php` jika nama database / password berbeda
4. Buka browser: `http://localhost/mathlearn/`

### 3. Konfigurasi Database
Edit file `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Sesuaikan password MySQL Anda
define('DB_NAME', 'math_website');
```

### 4. Update Link Discord
Setelah login sebagai admin, update tabel `discord_links` di database:
```sql
UPDATE discord_links SET link = 'https://discord.gg/LINK_ANDA' WHERE jam_update = '16:00';
UPDATE discord_links SET link = 'https://discord.gg/LINK_ANDA' WHERE jam_update = '20:00';
```

### 5. Menambah Soal Latihan
Buka `dashboard/dashboard.php`, cari komentar:
```html
<!-- Tambahkan soal Kelas X baru di sini -->
```
Lalu tambahkan kartu soal baru dengan format:
```html
<a href="https://forms.gle/LINK_FORM_ANDA" target="_blank" class="topic-card">
    <span class="topic-icon">📝</span>
    <h4>Nama Materi</h4>
    <p>Deskripsi singkat soal</p>
    <span class="topic-badge">Kerjakan →</span>
</a>
```

## Fitur
- ✅ Login & Register (tanpa NISN)
- ✅ Dark/Light mode (tersimpan di localStorage)
- ✅ Dashboard dengan materi per kelas (X, XI, XII)
- ✅ Latihan soal per kelas (mudah ditambah)
- ✅ Profil: edit nama, kelas, kecamatan
- ✅ Ganti password
- ✅ Cari teman belajar dengan filter
- ✅ Status online/offline real-time (polling 30 detik)
- ✅ Link Discord otomatis berganti jam 16:00 & 20:00
- ✅ Jam realtime di dashboard

## Materi yang Tersedia
| Kelas | Materi |
|-------|--------|
| X     | Eksponen, Logaritma, Baris & Deret |
| XI    | Fungsi Komposisi & Invers, Matriks, Statistika |
| XII   | Transformasi Fungsi, Matriks, Logaritma |
