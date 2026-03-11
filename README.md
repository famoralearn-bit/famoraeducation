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

# Website Matematika - MathLearn

Website platform belajar matematika dengan sistem login/register untuk siswa kelas X, XI, dan XII.

## Fitur

### 1. Sistem Autentikasi
- **Login**: Email dan password
- **Register**: NISN (10 digit), nama, email, kelas, kabupaten, password

### 2. Dashboard
- Profil pengguna
- Cari teman belajar (berdasarkan kelas dan kabupaten)
- **Ruang Discord** dengan:
  - **Jam realtime** yang berjalan setiap detik
  - Link otomatis berubah jam 16:00 dan 20:00
  - Notifikasi waktu update
  - Auto-refresh halaman saat jam update
- Latihan soal per kelas (1 link Google Form per materi):
  - **Kelas X**: Eksponen, Logaritma, Baris & Deret **(3 link)**
  - **Kelas XI**: Fungsi Komposisi & Invers, Statistika, Matriks **(3 link)**
  - **Kelas XII**: Transformasi Fungsi, Matriks, Logaritma **(3 link)**
- **Total: 9 link Google Form** yang berbeda

### 3. Profil
- Edit data profil (nama, email, kelas, kabupaten)
- Ganti password

### 4. Cari Teman
- Filter berdasarkan nama, kelas, dan kabupaten
- Tampilan card untuk setiap siswa

## Instalasi di XAMPP

### Langkah 1: Persiapan
1. Install XAMPP dari https://www.apachefriends.org/
2. Jalankan XAMPP Control Panel
3. Start Apache dan MySQL

### Langkah 2: Database
1. Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
2. Klik tab "SQL"
3. Copy seluruh isi file `database.sql` dan paste ke SQL query box
4. Klik tombol "Go" untuk menjalankan

### Langkah 3: File Website
Copy semua file PHP ke folder XAMPP:
   - Windows: `C:\xampp\htdocs\math-website\`
   - Linux: `/opt/lampp/htdocs/math-website/`
   - Mac: `/Applications/XAMPP/htdocs/math-website/`
  ### Langkah 4: Akses Website
1. Buka browser
2. Ketik: `http://localhost/math-website/`
3. Halaman login akan muncul

## Konfigurasi Discord Link

Untuk mengupdate link Discord yang berubah otomatis:

1. Buka phpMyAdmin
2. Pilih database `math_website`
3. Klik tabel `discord_links`
4. Edit baris dengan jam_update `16:00` dan `20:00`
5. Ganti kolom `link` dengan URL Discord baru

Atau jalankan query SQL:
```sql
UPDATE discord_links SET link = 'https://discord.gg/your-new-link-1' WHERE jam_update = '16:00';
UPDATE discord_links SET link = 'https://discord.gg/your-new-link-2' WHERE jam_update = '20:00';
```

## Konfigurasi Link Google Form

Untuk mengganti link latihan soal, ada **9 link total** yang perlu dikonfigurasi (1 link per materi):

### Cara Update:
1. Buka file `dashboard.php`
2. Cari link dengan format `https://forms.gle/namamateri-kelasXX`
3. Ganti dengan link Google Form Anda

### Daftar Link per Kelas:

**KELAS X (3 link):**
- Eksponen → `https://forms.gle/eksponen-kelas10`
- Logaritma → `https://forms.gle/logaritma-kelas10`
- Baris & Deret → `https://forms.gle/barisderet-kelas10`

**KELAS XI (3 link):**
- Fungsi Komposisi & Invers → `https://forms.gle/fungsi-kelas11`
- Statistika → `https://forms.gle/statistika-kelas11`
- Matriks → `https://forms.gle/matriks-kelas11`

**KELAS XII (3 link):**
- Transformasi Fungsi → `https://forms.gle/transformasi-kelas12`
- Matriks → `https://forms.gle/matriks-kelas12`
- Logaritma → `https://forms.gle/logaritma-kelas12`

**Lihat file `PANDUAN_UPDATE_LINK.txt` untuk panduan detail!**

Contoh:
```html
<!-- Sebelum -->
<a href="https://forms.gle/eksponen-kelas10" target="_blank">

<!-- Sesudah -->
<a href="https://forms.gle/AbC123XyZ" target="_blank">
```

## Daftar Kabupaten

Website mendukung 18 kabupaten di Bekasi:
- Cikarang
- Tambun
- Babelan
- Bojongmangu
- Cibarusah
- Cibitung
- Karangbahagia
- Kedungwaringin
- Muaragembong
- Pebayuran
- Serang Baru
- Setu
- Sukaraya
- Sukatani
- Sukawangi
- Tambelang
- Tarumajaya
- Cabangbungin

## Troubleshooting

### Error: "Koneksi gagal"
- Pastikan MySQL sudah running di XAMPP
- Cek kredensial database di `config.php`

### Error: "Database tidak ditemukan"
- Jalankan file `database.sql` di phpMyAdmin
- Pastikan database bernama `math_website` sudah dibuat

### Halaman blank/error 500
- Aktifkan error reporting di PHP
- Cek file `error.log` di folder `xampp/apache/logs/`

### Link Discord tidak berubah
- Cek tabel `discord_links` di database
- Pastikan waktu server sudah benar
- Update manual via phpMyAdmin jika perlu

## Keamanan

⚠️ **PENTING untuk Production:**
1. Ganti password database di `config.php`
2. Aktifkan HTTPS
3. Validasi input lebih ketat
4. Tambahkan CAPTCHA di form
5. Backup database secara berkala

## Teknologi

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Font**: Space Mono, Crimson Pro (Google Fonts)
- **Server**: Apache (XAMPP)

## Lisensi

Untuk keperluan edukasi dan pembelajaran.

Dibuat dengan ❤️ untuk pembelajaran Matematika

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

## Kedepannya 
Kita menambahkan fitur dan materi lebih banyak lagi 🥰🥰
