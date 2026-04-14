/* =============================================
   FamoraLearn - Dashboard JS
   ============================================= */

function selectMateri(className) {
    document.querySelectorAll('.materi-tab-btn').forEach(function(b) { b.classList.remove('active'); });
    document.querySelectorAll('.materi-panel').forEach(function(p)   { p.classList.remove('active'); });
    var btn   = document.getElementById('materi-btn-' + className);
    var panel = document.getElementById('materi-' + className);
    if (btn)   btn.classList.add('active');
    if (panel) panel.classList.add('active');
}

function selectLatihan(className) {
    document.querySelectorAll('.latihan-tab-btn').forEach(function(b) { b.classList.remove('active'); });
    document.querySelectorAll('.latihan-panel').forEach(function(p)   { p.classList.remove('active'); });
    var btn   = document.getElementById('latihan-btn-' + className);
    var panel = document.getElementById('latihan-' + className);
    if (btn)   btn.classList.add('active');
    if (panel) panel.classList.add('active');
}

function updateTime() {
    var now = new Date();
    var h = String(now.getHours()).padStart(2,'0');
    var m = String(now.getMinutes()).padStart(2,'0');
    var s = String(now.getSeconds()).padStart(2,'0');
    var el = document.getElementById('current-time');
    if (el) el.textContent = h + ':' + m + ':' + s;
}

function autoReload() {
    var now = new Date();
    if ((now.getHours() === 16 || now.getHours() === 20)
        && now.getMinutes() === 0 && now.getSeconds() === 0) {
        location.reload();
    }
}

/* ============================================================
   KONTEN MATERI — 12 topik lengkap
   ============================================================ */
var MATERI_DATA = {

    /* ==================== KELAS X ==================== */

    'eksponen-x': {
        kelas: 'Kelas X',
        judul: '⚡ Eksponen',
        isi: `
<p>Eksponen (pangkat) adalah cara menulis perkalian berulang suatu bilangan. Jika <strong>a</strong> adalah bilangan real dan <strong>n</strong> bilangan bulat positif, maka <strong>aⁿ = a × a × … × a</strong> (sebanyak n kali).</p>

<h2>Definisi Dasar</h2>
<div class="rumus-box">
aⁿ = a × a × a × … × a &nbsp; (n kali)<br>
Contoh: 2⁴ = 2 × 2 × 2 × 2 = 16
</div>

<h2>Sifat-Sifat Eksponen</h2>

<h3>1. Perkalian dengan Basis Sama</h3>
<div class="rumus-box">aᵐ × aⁿ = aᵐ⁺ⁿ</div>
<div class="contoh-box"><strong>Contoh:</strong> 3² × 3⁴ = 3⁶ = 729 &nbsp;|&nbsp; 2³ × 2⁵ = 2⁸ = 256</div>

<h3>2. Pembagian dengan Basis Sama</h3>
<div class="rumus-box">aᵐ ÷ aⁿ = aᵐ⁻ⁿ &nbsp; (a ≠ 0)</div>
<div class="contoh-box"><strong>Contoh:</strong> 5⁶ ÷ 5² = 5⁴ = 625 &nbsp;|&nbsp; 2⁷ ÷ 2³ = 2⁴ = 16</div>

<h3>3. Pangkat dari Pangkat</h3>
<div class="rumus-box">(aᵐ)ⁿ = aᵐˣⁿ</div>
<div class="contoh-box"><strong>Contoh:</strong> (2³)⁴ = 2¹² = 4096 &nbsp;|&nbsp; (5²)³ = 5⁶ = 15625</div>

<h3>4. Pangkat Perkalian</h3>
<div class="rumus-box">(a × b)ⁿ = aⁿ × bⁿ</div>
<div class="contoh-box"><strong>Contoh:</strong> (2 × 3)³ = 2³ × 3³ = 8 × 27 = 216</div>

<h3>5. Pangkat Pembagian</h3>
<div class="rumus-box">(a/b)ⁿ = aⁿ/bⁿ &nbsp; (b ≠ 0)</div>
<div class="contoh-box"><strong>Contoh:</strong> (4/2)³ = 4³/2³ = 64/8 = 8</div>

<h3>6. Pangkat Nol</h3>
<div class="rumus-box">a⁰ = 1 &nbsp; (a ≠ 0)</div>
<div class="contoh-box"><strong>Contoh:</strong> 5⁰ = 1 &nbsp;|&nbsp; 100⁰ = 1 &nbsp;|&nbsp; (−3)⁰ = 1</div>

<h3>7. Pangkat Negatif</h3>
<div class="rumus-box">a⁻ⁿ = 1/aⁿ &nbsp; (a ≠ 0)</div>
<div class="contoh-box"><strong>Contoh:</strong> 2⁻³ = 1/8 = 0,125 &nbsp;|&nbsp; 5⁻² = 1/25 = 0,04</div>

<h3>8. Pangkat Pecahan (Akar)</h3>
<div class="rumus-box">a^(1/n) = ⁿ√a &nbsp; dan &nbsp; a^(m/n) = ⁿ√(aᵐ)</div>
<div class="contoh-box"><strong>Contoh:</strong> 16^(1/2) = √16 = 4 &nbsp;|&nbsp; 8^(2/3) = ∛(8²) = ∛64 = 4</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Pangkat nol → hasilnya selalu 1 (a ≠ 0)</li>
  <li>Perkalian basis sama → eksponen dijumlah</li>
  <li>Pembagian basis sama → eksponen dikurang</li>
  <li>Pangkat dari pangkat → eksponen dikali</li>
  <li>Pangkat negatif → bentuk pecahan 1/aⁿ</li>
  <li>Pangkat pecahan → bentuk akar</li>
</ul>
</div>`
    },

    'logaritma-x': {
        kelas: 'Kelas X',
        judul: '📈 Logaritma',
        isi: `
<p>Logaritma adalah kebalikan (invers) dari operasi eksponen. Jika <strong>bˣ = y</strong>, maka <strong>ₒlog y = x</strong> (dibaca "log basis b dari y sama dengan x").</p>

<h2>Definisi</h2>
<div class="rumus-box">
ᵦlog y = x &nbsp; ⟺ &nbsp; bˣ = y<br>
Syarat: b > 0, b ≠ 1, y > 0
</div>
<div class="contoh-box">
<strong>Contoh dasar:</strong><br>
²log 8 = 3 karena 2³ = 8<br>
³log 81 = 4 karena 3⁴ = 81<br>
¹⁰log 1000 = 3 karena 10³ = 1000<br>
²log 1 = 0 karena 2⁰ = 1
</div>

<h2>Sifat-Sifat Logaritma</h2>

<h3>1. Logaritma Perkalian</h3>
<div class="rumus-box">ᵦlog (p × q) = ᵦlog p + ᵦlog q</div>
<div class="contoh-box"><strong>Contoh:</strong> ²log (4 × 8) = ²log 4 + ²log 8 = 2 + 3 = 5 ✓ (²log 32 = 5)</div>

<h3>2. Logaritma Pembagian</h3>
<div class="rumus-box">ᵦlog (p / q) = ᵦlog p − ᵦlog q</div>
<div class="contoh-box"><strong>Contoh:</strong> ²log (32/4) = ²log 32 − ²log 4 = 5 − 2 = 3 ✓ (²log 8 = 3)</div>

<h3>3. Logaritma Pangkat</h3>
<div class="rumus-box">ᵦlog pⁿ = n × ᵦlog p</div>
<div class="contoh-box"><strong>Contoh:</strong> ²log 64 = ²log 2⁶ = 6 × ²log 2 = 6 × 1 = 6</div>

<h3>4. Nilai Khusus</h3>
<div class="rumus-box">
ᵦlog b = 1 &nbsp; (log dari basis sendiri = 1)<br>
ᵦlog 1 = 0 &nbsp; (log dari 1 selalu 0)
</div>

<h3>5. Sifat Eksponen-Logaritma</h3>
<div class="rumus-box">b^(ᵦlog x) = x</div>

<h3>6. Pergantian Basis</h3>
<div class="rumus-box">ᵦlog x = (log x)/(log b) = (ln x)/(ln b)</div>

<div class="contoh-box">
<strong>Soal latihan:</strong> Hitung ²log 4 + ²log 8 − ²log 2<br>
= ²log (4 × 8 / 2) = ²log 16 = 4 ✓
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Logaritma = kebalikan eksponen: ᵦlog y = x ⟺ bˣ = y</li>
  <li>Perkalian dalam logaritma → penjumlahan</li>
  <li>Pembagian dalam logaritma → pengurangan</li>
  <li>Pangkat dalam logaritma → pengali di depan</li>
  <li>ᵦlog b = 1 dan ᵦlog 1 = 0 selalu berlaku</li>
</ul>
</div>`
    },

    'barisderet-x': {
        kelas: 'Kelas X',
        judul: '🔗 Baris & Deret',
        isi: `
<p><strong>Barisan</strong> adalah urutan bilangan yang disusun menurut aturan tertentu. <strong>Deret</strong> adalah hasil penjumlahan suku-suku barisan. Dua jenis utama: <strong>aritmetika</strong> (beda tetap) dan <strong>geometri</strong> (rasio tetap).</p>

<h2>A. Barisan & Deret Aritmetika</h2>
<p>Setiap suku berbeda secara konstan dengan beda <strong>b</strong>.</p>

<div class="rumus-box">
Suku ke-n: Uₙ = a + (n − 1)b<br>
a = suku pertama, b = beda = U₂ − U₁
</div>
<div class="contoh-box">
<strong>Contoh:</strong> 3, 7, 11, 15, ... (a = 3, b = 4)<br>
U₁₀ = 3 + (10−1) × 4 = 3 + 36 = 39
</div>

<div class="rumus-box">
Deret aritmetika (jumlah n suku pertama):<br>
Sₙ = n/2 × (2a + (n−1)b)<br>
atau: Sₙ = n/2 × (a + Uₙ)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Jumlah 10 suku pertama dari 3, 7, 11, ...<br>
S₁₀ = 10/2 × (2×3 + 9×4) = 5 × (6 + 36) = 5 × 42 = 210
</div>

<h2>B. Barisan & Deret Geometri</h2>
<p>Setiap suku memiliki rasio <strong>r</strong> yang tetap.</p>

<div class="rumus-box">
Suku ke-n: Uₙ = a × rⁿ⁻¹<br>
r = rasio = U₂/U₁
</div>
<div class="contoh-box">
<strong>Contoh:</strong> 2, 6, 18, 54, ... (a = 2, r = 3)<br>
U₆ = 2 × 3⁵ = 2 × 243 = 486
</div>

<div class="rumus-box">
Deret geometri hingga:<br>
Sₙ = a(rⁿ − 1)/(r − 1) &nbsp; untuk r ≠ 1<br><br>
Deret geometri tak hingga (|r| &lt; 1):<br>
S∞ = a / (1 − r)
</div>
<div class="contoh-box">
<strong>Contoh S∞:</strong> 8 + 4 + 2 + 1 + ... (a = 8, r = 1/2)<br>
S∞ = 8 / (1 − 1/2) = 8 / (1/2) = 16
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Aritmetika: beda (b) konstan → Uₙ = a + (n−1)b</li>
  <li>Geometri: rasio (r) konstan → Uₙ = a·rⁿ⁻¹</li>
  <li>Deret = jumlah suku-suku barisan</li>
  <li>Deret geometri tak hingga hanya ada jika |r| &lt; 1</li>
</ul>
</div>`
    },

    'trigonometri-x': {
        kelas: 'Kelas X',
        judul: '📐 Trigonometri',
        isi: `
<p>Trigonometri mempelajari hubungan antara sudut dan sisi pada segitiga. Tiga perbandingan dasar: <strong>sinus (sin)</strong>, <strong>cosinus (cos)</strong>, dan <strong>tangen (tan)</strong>.</p>

<h2>Perbandingan pada Segitiga Siku-Siku</h2>
<div class="rumus-box">
sin θ = sisi depan / sisi miring<br>
cos θ = sisi samping / sisi miring<br>
tan θ = sisi depan / sisi samping = sin θ / cos θ<br><br>
Kebalikannya:<br>
csc θ = 1/sin θ &nbsp;|&nbsp; sec θ = 1/cos θ &nbsp;|&nbsp; cot θ = 1/tan θ
</div>

<h2>Nilai Sudut Istimewa</h2>
<div class="contoh-box">
<strong>0°:</strong>  sin = 0,  cos = 1,   tan = 0<br>
<strong>30°:</strong> sin = ½,  cos = ½√3, tan = ⅓√3<br>
<strong>45°:</strong> sin = ½√2, cos = ½√2, tan = 1<br>
<strong>60°:</strong> sin = ½√3, cos = ½,  tan = √3<br>
<strong>90°:</strong> sin = 1,  cos = 0,   tan = ∞
</div>

<h2>Tanda di Setiap Kuadran</h2>
<div class="contoh-box">
<strong>Kuadran I</strong> (0°–90°):     sin +, cos +, tan +<br>
<strong>Kuadran II</strong> (90°–180°):   sin +, cos −, tan −<br>
<strong>Kuadran III</strong> (180°–270°): sin −, cos −, tan +<br>
<strong>Kuadran IV</strong> (270°–360°):  sin −, cos +, tan −<br>
<em>Ingat: "Semua – Sinus – Tangen – Cosinus" (searah jarum jam)</em>
</div>

<h2>Identitas Trigonometri Dasar</h2>
<div class="rumus-box">
sin²θ + cos²θ = 1<br>
1 + tan²θ = sec²θ<br>
1 + cot²θ = csc²θ
</div>

<h2>Aturan Sinus & Cosinus</h2>
<div class="rumus-box">
Aturan Sinus: a/sin A = b/sin B = c/sin C<br>
Aturan Cosinus: a² = b² + c² − 2bc·cos A
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Segitiga dengan A = 30°, B = 45°, a = 6.<br>
b/sin B = a/sin A → b = 6 × sin 45°/sin 30° = 6 × (½√2)/(½) = 6√2
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>sin, cos, tan = perbandingan sisi segitiga siku-siku</li>
  <li>Identitas utama: sin²θ + cos²θ = 1</li>
  <li>Tanda berubah tiap kuadran (ASTC/CAST)</li>
  <li>Aturan sinus & cosinus untuk segitiga sembarang</li>
</ul>
</div>`
    },

    /* ==================== KELAS XI ==================== */

    'fungsi-xi': {
        kelas: 'Kelas XI',
        judul: '🔄 Fungsi Komposisi',
        isi: `
<p><strong>Fungsi komposisi</strong> adalah operasi yang menggabungkan dua atau lebih fungsi secara berantai, sehingga <em>output</em> dari fungsi pertama menjadi <em>input</em> bagi fungsi berikutnya. Simbol komposisi adalah <strong>∘</strong> (dibaca "bundaran").</p>

<h2>Definisi Fungsi Komposisi</h2>
<div class="rumus-box">
(f ∘ g)(x) = f(g(x))<br><br>
Cara baca: "f komposisi g dari x"<br>
Urutan: masukkan x ke g dulu → hasilnya masukkan ke f
</div>

<h2>Cara Menghitung Komposisi</h2>
<div class="rumus-box">
Langkah:<br>
1. Hitung g(x) terlebih dahulu<br>
2. Substitusikan hasil g(x) ke dalam f<br>
3. Sederhanakan ekspresi akhir
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> f(x) = 2x + 1, &nbsp; g(x) = x²<br>
(f ∘ g)(x) = f(g(x)) = f(x²) = 2(x²) + 1 = <strong>2x² + 1</strong><br><br>
<strong>Contoh 2:</strong> f(x) = 3x − 2, &nbsp; g(x) = x + 4<br>
(f ∘ g)(x) = f(x+4) = 3(x+4) − 2 = 3x + 12 − 2 = <strong>3x + 10</strong><br><br>
<strong>Contoh 3:</strong> f(x) = x², &nbsp; g(x) = 2x − 1<br>
(g ∘ f)(x) = g(x²) = 2(x²) − 1 = <strong>2x² − 1</strong>
</div>

<h2>Komposisi Tidak Komutatif</h2>
<div class="contoh-box">
<strong>Bukti:</strong> f(x) = 2x + 1, &nbsp; g(x) = x²<br>
(f ∘ g)(x) = 2x² + 1<br>
(g ∘ f)(x) = g(2x+1) = (2x+1)² = 4x² + 4x + 1<br>
→ <strong>f ∘ g ≠ g ∘ f</strong> &nbsp; (urutan sangat berpengaruh!)
</div>

<h2>Sifat-Sifat Komposisi</h2>
<div class="contoh-box">
<strong>1. Asosiatif:</strong> (f ∘ g) ∘ h = f ∘ (g ∘ h) ✓<br>
<strong>2. Tidak Komutatif:</strong> f ∘ g ≠ g ∘ f (umumnya) ✓<br>
<strong>3. Elemen Identitas I(x) = x:</strong> f ∘ I = I ∘ f = f ✓<br>
<strong>4. Domain:</strong> Domain (f ∘ g) = {x ∈ Dg | g(x) ∈ Df}
</div>

<h2>Komposisi Tiga Fungsi</h2>
<div class="rumus-box">
(f ∘ g ∘ h)(x) = f(g(h(x)))<br>
Kerjakan dari dalam ke luar: h → g → f
</div>
<div class="contoh-box">
<strong>Contoh:</strong> f(x) = x + 1, &nbsp; g(x) = 2x, &nbsp; h(x) = x²<br>
(f ∘ g ∘ h)(3) = f(g(h(3))) = f(g(9)) = f(18) = 19
</div>

<h2>Mencari Fungsi dari Hasil Komposisi</h2>
<p>Jika diketahui hasil komposisi dan salah satu fungsi, cari fungsi yang lain dengan substitusi.</p>
<div class="contoh-box">
<strong>Contoh:</strong> (f ∘ g)(x) = 6x − 4 dan g(x) = 2x. Tentukan f(x)!<br>
Misalkan g(x) = 2x = t, maka x = t/2<br>
f(t) = 6·(t/2) − 4 = 3t − 4<br>
∴ <strong>f(x) = 3x − 4</strong> &nbsp; (cek: f(g(x)) = f(2x) = 3(2x)−4 = 6x−4 ✓)
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>(f ∘ g)(x) = f(g(x)) — kerjakan dari dalam ke luar</li>
  <li>Komposisi <strong>tidak komutatif</strong>: f∘g ≠ g∘f pada umumnya</li>
  <li>Komposisi <strong>asosiatif</strong>: urutan tanda kurung tidak berpengaruh</li>
  <li>Perhatikan domain: g(x) harus masuk wilayah domain f</li>
  <li>Untuk mencari fungsi dari hasil komposisi → gunakan substitusi</li>
</ul>
</div>`
    },

    'peluang-xi': {
        kelas: 'Kelas XI',
        judul: '🎲 Peluang',
        isi: `
<p><strong>Peluang</strong> (probabilitas) adalah ukuran seberapa besar kemungkinan suatu kejadian akan terjadi. Nilai peluang selalu berada di antara <strong>0</strong> (mustahil terjadi) dan <strong>1</strong> (pasti terjadi).</p>

<h2>Konsep Dasar: Ruang Sampel & Kejadian</h2>
<p><strong>Ruang sampel (S)</strong> adalah himpunan semua hasil yang mungkin. <strong>Kejadian (A)</strong> adalah himpunan bagian dari ruang sampel.</p>
<div class="rumus-box">
P(A) = n(A) / n(S)<br><br>
n(A) = banyak anggota kejadian A<br>
n(S) = banyak anggota ruang sampel
</div>
<div class="contoh-box">
<strong>Contoh 1 — Dadu:</strong> Satu dadu dilempar sekali.<br>
S = {1, 2, 3, 4, 5, 6} → n(S) = 6<br>
A = muncul bilangan ganjil = {1, 3, 5} → n(A) = 3<br>
P(A) = 3/6 = <strong>1/2</strong><br><br>
<strong>Contoh 2 — Koin:</strong> Dua koin dilempar bersamaan.<br>
S = {(G,G), (G,A), (A,G), (A,A)} → n(S) = 4<br>
B = muncul tepat satu Angka = {(G,A), (A,G)} → n(B) = 2<br>
P(B) = 2/4 = <strong>1/2</strong>
</div>

<h2>Sifat-Sifat Peluang</h2>
<div class="rumus-box">
0 ≤ P(A) ≤ 1 &nbsp; untuk setiap kejadian A<br>
P(S) = 1 &nbsp; (kejadian pasti)<br>
P(∅) = 0 &nbsp; (kejadian mustahil)<br>
P(Aᶜ) = 1 − P(A) &nbsp; (komplemen/kebalikan A)
</div>
<div class="contoh-box">
<strong>Contoh komplemen:</strong> Dadu dilempar. P(bukan angka 6)?<br>
P(muncul 6) = 1/6<br>
P(bukan 6) = 1 − 1/6 = <strong>5/6</strong>
</div>

<h2>Kejadian Majemuk: Gabungan (A ∪ B)</h2>
<div class="rumus-box">
P(A ∪ B) = P(A) + P(B) − P(A ∩ B)<br><br>
Khusus jika A dan B <strong>saling lepas</strong> (tidak bisa terjadi bersamaan):<br>
P(A ∩ B) = 0 &nbsp; → &nbsp; P(A ∪ B) = P(A) + P(B)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Dari 52 kartu bridge, diambil 1 kartu.<br>
A = kartu As, B = kartu Hati<br>
P(A) = 4/52, &nbsp; P(B) = 13/52, &nbsp; P(A∩B) = P(As Hati) = 1/52<br>
P(A ∪ B) = 4/52 + 13/52 − 1/52 = <strong>16/52 = 4/13</strong>
</div>

<h2>Kejadian Saling Bebas (Independen)</h2>
<p>Kejadian A dan B saling bebas jika terjadinya A tidak mempengaruhi peluang terjadinya B.</p>
<div class="rumus-box">
A dan B saling bebas ⟺ P(A ∩ B) = P(A) × P(B)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Sebuah dadu dan sebuah koin dilempar bersamaan.<br>
A = dadu muncul angka 6 → P(A) = 1/6<br>
B = koin muncul Gambar → P(B) = 1/2<br>
P(A ∩ B) = 1/6 × 1/2 = <strong>1/12</strong>
</div>

<h2>Peluang Bersyarat</h2>
<p>P(A|B) dibaca "peluang A terjadi <strong>dengan syarat</strong> B sudah terjadi".</p>
<div class="rumus-box">
P(A | B) = P(A ∩ B) / P(B) &nbsp; , P(B) ≠ 0
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Dalam sebuah kelas, 60% siswa suka Matematika (M), 40% suka Fisika (F), dan 25% suka keduanya.<br>
P(M|F) = P(M∩F) / P(F) = 0,25 / 0,40 = <strong>0,625</strong><br>
Artinya: dari siswa yang suka Fisika, 62,5% juga suka Matematika.
</div>

<h2>Frekuensi Harapan</h2>
<div class="rumus-box">
Fh = P(A) × n<br>
n = banyaknya percobaan yang dilakukan
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> Dadu dilempar 180 kali. Frekuensi harapan muncul angka 5?<br>
Fh = 1/6 × 180 = <strong>30 kali</strong><br><br>
<strong>Contoh 2:</strong> Koin dilempar 200 kali. Frekuensi harapan muncul Angka?<br>
Fh = 1/2 × 200 = <strong>100 kali</strong>
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>P(A) = n(A)/n(S), selalu antara 0 dan 1</li>
  <li>Komplemen: P(Aᶜ) = 1 − P(A)</li>
  <li>Gabungan: P(A∪B) = P(A) + P(B) − P(A∩B)</li>
  <li>Saling lepas: P(A∩B) = 0, sehingga P(A∪B) = P(A) + P(B)</li>
  <li>Saling bebas: P(A∩B) = P(A) × P(B)</li>
  <li>Bersyarat: P(A|B) = P(A∩B)/P(B)</li>
  <li>Frekuensi harapan: Fh = P(A) × n</li>
</ul>
</div>`
    },

    'statistika-xi': {
        kelas: 'Kelas XI',
        judul: '📊 Statistika',
        isi: `
<p>Statistika mempelajari cara mengumpulkan, mengolah, menyajikan, dan menginterpretasi data untuk mengambil kesimpulan. Dibagi menjadi statistika deskriptif dan inferensial.</p>

<h2>Ukuran Pemusatan Data</h2>

<h3>1. Mean (Rata-rata)</h3>
<div class="rumus-box">
Data tunggal: x̄ = (Σxᵢ) / n<br>
Data berkelompok: x̄ = Σ(fᵢ · xᵢ) / Σfᵢ
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Data: 5, 7, 8, 6, 9<br>
x̄ = (5+7+8+6+9)/5 = 35/5 = 7
</div>

<h3>2. Median (Nilai Tengah)</h3>
<div class="rumus-box">
n ganjil: nilai tengah setelah diurutkan<br>
n genap: rata-rata dua nilai tengah
</div>
<div class="contoh-box">
<strong>Contoh ganjil:</strong> 3, 5, 7, 9, 11 → Median = 7<br>
<strong>Contoh genap:</strong> 2, 4, 6, 8 → Median = (4+6)/2 = 5
</div>

<h3>3. Modus</h3>
<p>Nilai yang paling sering muncul. Bisa unimodal, bimodal, atau tidak ada.</p>
<div class="contoh-box"><strong>Contoh:</strong> 3, 5, 7, 5, 8, 5, 9 → Modus = 5</div>

<h2>Ukuran Penyebaran Data</h2>

<h3>Jangkauan & Kuartil</h3>
<div class="rumus-box">
Jangkauan (range): R = nilai maks − nilai min<br>
Jangkauan interkuartil: IQR = Q₃ − Q₁
</div>

<h3>Varians & Simpangan Baku</h3>
<div class="rumus-box">
Varians populasi: σ² = Σ(xᵢ − x̄)² / n<br>
Varians sampel:   s² = Σ(xᵢ − x̄)² / (n − 1)<br>
Simpangan baku: σ = √σ² &nbsp; atau &nbsp; s = √s²
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Data: 2, 4, 4, 4, 5, 5, 7, 9 &nbsp; (n=8, x̄=5)<br>
σ² = [(9)+(1)+(1)+(1)+(0)+(0)+(4)+(16)] / 8 = 32/8 = 4<br>
σ = √4 = 2
</div>

<h2>Penyajian Data</h2>
<div class="contoh-box">
• Tabel distribusi frekuensi<br>
• Histogram dan poligon frekuensi<br>
• Diagram batang, lingkaran, garis<br>
• Ogive (kurva frekuensi kumulatif)<br>
• Diagram kotak-garis (box plot)
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Mean = jumlah data / banyak data</li>
  <li>Median = nilai tengah data terurut</li>
  <li>Modus = nilai paling sering muncul</li>
  <li>Simpangan baku mengukur sebaran dari rata-rata</li>
  <li>IQR = Q₃ − Q₁ mengukur penyebaran data tengah</li>
</ul>
</div>`
    },

    'relasifungsi-xi': {
        kelas: 'Kelas XI',
        judul: '🗺️ Relasi & Fungsi',
        isi: `
<p><strong>Relasi</strong> adalah aturan yang menghubungkan anggota satu himpunan dengan anggota himpunan lainnya. <strong>Fungsi</strong> adalah relasi khusus di mana setiap anggota domain dipasangkan dengan <em>tepat satu</em> anggota kodomain.</p>

<h2>Relasi dan Cara Penyajiannya</h2>
<p>Relasi dari himpunan A ke himpunan B dapat dinyatakan dengan empat cara:</p>
<div class="contoh-box">
<strong>Contoh:</strong> A = {1, 2, 3}, B = {1, 2, 4, 6, 9}, relasi "kuadrat dari"<br><br>
<strong>1. Diagram Panah:</strong> &nbsp; 1 → 1, &nbsp; 2 → 4, &nbsp; 3 → 9<br>
<strong>2. Himpunan Pasangan Berurutan:</strong> &nbsp; {(1,1), (2,4), (3,9)}<br>
<strong>3. Tabel:</strong><br>
&nbsp;&nbsp; x &nbsp;|&nbsp; y<br>
&nbsp;&nbsp; 1 &nbsp;|&nbsp; 1<br>
&nbsp;&nbsp; 2 &nbsp;|&nbsp; 4<br>
&nbsp;&nbsp; 3 &nbsp;|&nbsp; 9<br>
<strong>4. Grafik Cartesius:</strong> titik-titik (1,1), (2,4), (3,9) pada bidang koordinat
</div>

<h2>Definisi Fungsi (Pemetaan)</h2>
<p>Fungsi f: A → B adalah relasi yang memenuhi dua syarat:</p>
<div class="rumus-box">
Syarat fungsi f: A → B:<br>
1. Setiap anggota A harus punya pasangan di B (total/terdefinisi)<br>
2. Setiap anggota A dipasangkan ke tepat SATU anggota B (tunggal/unik)
</div>
<div class="contoh-box">
<strong>Fungsi:</strong> {(1,a), (2,b), (3,c)} ✓ — setiap x punya tepat satu pasangan<br>
<strong>Bukan Fungsi:</strong> {(1,a), (1,b), (2,c)} ✗ — x=1 punya dua pasangan<br>
<strong>Bukan Fungsi:</strong> {(1,a), (3,c)} ✗ — x=2 tidak punya pasangan (jika domain = {1,2,3})
</div>

<h2>Domain, Kodomain, dan Range</h2>
<div class="rumus-box">
Domain (Df): himpunan semua nilai x yang "boleh masuk" ke fungsi<br>
Kodomain: himpunan B (semua nilai yang "mungkin" jadi output)<br>
Range (Rf): himpunan nilai f(x) yang benar-benar dihasilkan (Rf ⊆ Kodomain)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> f: A → B, f = {(1,3), (2,5), (3,7)}<br>
Domain = {1, 2, 3}<br>
Kodomain = {3, 5, 7, 9} (misalkan B = {3,5,7,9})<br>
Range = {3, 5, 7} &nbsp; ← nilai 9 tidak tercapai, jadi 9 ∉ Range
</div>

<h2>Menentukan Domain Fungsi Aljabar</h2>
<div class="rumus-box">
Fungsi akar: f(x) = √g(x) &nbsp; → &nbsp; syarat g(x) ≥ 0<br>
Fungsi pecahan: f(x) = 1/g(x) &nbsp; → &nbsp; syarat g(x) ≠ 0<br>
Fungsi logaritma: f(x) = log(g(x)) &nbsp; → &nbsp; syarat g(x) > 0
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> f(x) = √(2x − 6)<br>
Syarat: 2x − 6 ≥ 0 → x ≥ 3 → <strong>Df = [3, ∞)</strong><br><br>
<strong>Contoh 2:</strong> f(x) = 3/(x² − 9)<br>
Syarat: x² − 9 ≠ 0 → x ≠ ±3 → <strong>Df = ℝ \ {−3, 3}</strong><br><br>
<strong>Contoh 3:</strong> f(x) = √(x−1) / (x−4)<br>
Syarat: x−1 ≥ 0 dan x ≠ 4 → x ≥ 1 dan x ≠ 4 → <strong>Df = [1,∞) \ {4}</strong>
</div>

<h2>Jenis-Jenis Fungsi</h2>
<div class="contoh-box">
<strong>Injektif (satu-satu):</strong><br>
x₁ ≠ x₂ ⟹ f(x₁) ≠ f(x₂) — tidak ada dua input yang menghasilkan output sama<br>
Contoh: f(x) = 2x + 1 ✓ (setiap nilai y hanya punya satu x)<br><br>
<strong>Surjektif (onto/kepada):</strong><br>
Setiap y ∈ kodomain punya pasangan x ∈ domain, sehingga Range = Kodomain<br>
Contoh: f: ℝ → ℝ, f(x) = x³ ✓<br><br>
<strong>Bijektif (korespondensi satu-satu):</strong><br>
Injektif DAN surjektif sekaligus<br>
Syarat fungsi memiliki invers!<br>
Contoh: f(x) = 2x + 3 di f: ℝ → ℝ ✓
</div>

<h2>Operasi Aljabar pada Fungsi</h2>
<div class="rumus-box">
(f + g)(x) = f(x) + g(x)<br>
(f − g)(x) = f(x) − g(x)<br>
(f · g)(x) = f(x) · g(x)<br>
(f/g)(x)  = f(x) / g(x), &nbsp; syarat g(x) ≠ 0
</div>
<div class="contoh-box">
<strong>Contoh:</strong> f(x) = x + 2, &nbsp; g(x) = x² − 1<br>
(f + g)(x) = x + 2 + x² − 1 = x² + x + 1<br>
(f · g)(x) = (x+2)(x²−1) = x³ + 2x² − x − 2<br>
(f/g)(3) = f(3)/g(3) = 5/8
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Relasi: aturan menghubungkan dua himpunan — bisa disajikan 4 cara</li>
  <li>Fungsi: tiap anggota domain punya tepat SATU pasangan di kodomain</li>
  <li>Domain ≠ Kodomain ≠ Range (Range ⊆ Kodomain)</li>
  <li>Syarat domain: akar → ≥ 0; pecahan → ≠ 0; log → > 0</li>
  <li>Bijektif = injektif + surjektif = syarat fungsi memiliki invers</li>
</ul>
</div>`
    },

    /* ==================== KELAS XII ==================== */

    'limitturunan-xii': {
        kelas: 'Kelas XII',
        judul: '📉 Limit & Turunan Fungsi',
        isi: `
<p><strong>Limit</strong> menggambarkan nilai yang didekati suatu fungsi ketika variabel bebasnya mendekati titik tertentu. <strong>Turunan</strong> adalah laju perubahan sesaat fungsi di suatu titik, dan didefinisikan menggunakan konsep limit.</p>

<h2>A. Limit Fungsi</h2>

<h3>Definisi Intuitif</h3>
<div class="rumus-box">
lim f(x) = L
(x→a)
berarti: nilai f(x) semakin mendekati L ketika x semakin mendekati a
(x boleh mendekati a dari kiri maupun kanan, tapi tidak harus x = a)
</div>

<h3>Teknik 1 — Substitusi Langsung</h3>
<p>Berlaku jika fungsi terdefinisi di titik tersebut (tidak menghasilkan bentuk tak tentu).</p>
<div class="contoh-box">
<strong>Contoh:</strong><br>
lim(x→3) (x² + 2x − 1) = 9 + 6 − 1 = <strong>14</strong><br>
lim(x→2) (3x³ − 5) = 24 − 5 = <strong>19</strong>
</div>

<h3>Teknik 2 — Faktorisasi (Bentuk 0/0)</h3>
<div class="contoh-box">
<strong>Contoh 1:</strong> lim(x→2) (x²−4)/(x−2)<br>
= lim(x→2) (x+2)(x−2)/(x−2) &nbsp; ← faktorkan<br>
= lim(x→2) (x+2) = <strong>4</strong><br><br>
<strong>Contoh 2:</strong> lim(x→3) (x²−9)/(x²−x−6)<br>
= lim(x→3) (x+3)(x−3)/[(x−3)(x+2)]<br>
= lim(x→3) (x+3)/(x+2) = 6/5 = <strong>1,2</strong>
</div>

<h3>Teknik 3 — Kali Sekawan (Bentuk Akar)</h3>
<div class="contoh-box">
<strong>Contoh:</strong> lim(x→0) (√(x+4) − 2)/x<br>
× (√(x+4)+2)/(√(x+4)+2):<br>
= lim(x→0) (x+4−4) / [x·(√(x+4)+2)]<br>
= lim(x→0) x / [x·(√(x+4)+2)]<br>
= lim(x→0) 1/(√(x+4)+2) = 1/4 = <strong>0,25</strong>
</div>

<h3>Limit Trigonometri Penting</h3>
<div class="rumus-box">
lim(x→0) sin x / x = 1<br>
lim(x→0) tan x / x = 1<br>
lim(x→0) (1 − cos x) / x = 0<br>
lim(x→0) (1 − cos x) / x² = 1/2
</div>
<div class="contoh-box">
<strong>Contoh:</strong> lim(x→0) sin 3x / x<br>
= lim(x→0) 3 · sin(3x)/(3x) = 3 · 1 = <strong>3</strong>
</div>

<h2>B. Turunan Fungsi</h2>

<h3>Definisi Turunan (dari Limit)</h3>
<div class="rumus-box">
f′(x) = lim [f(x+h) − f(x)] / h
       (h→0)
f′(x) juga ditulis: dy/dx atau df/dx
</div>
<div class="contoh-box">
<strong>Contoh dengan definisi:</strong> f(x) = x²<br>
f′(x) = lim [(x+h)² − x²]/h = lim [x²+2xh+h²−x²]/h<br>
= lim [2xh + h²]/h = lim (2x + h) = <strong>2x</strong>
</div>

<h3>Rumus Turunan Dasar</h3>
<div class="rumus-box">
(c)′ = 0 &nbsp; (c = konstanta)<br>
(xⁿ)′ = n·xⁿ⁻¹ &nbsp; ← paling penting!<br>
(sin x)′ = cos x<br>
(cos x)′ = −sin x<br>
(tan x)′ = sec²x = 1/cos²x<br>
(eˣ)′ = eˣ<br>
(ln x)′ = 1/x &nbsp; (x > 0)
</div>

<h3>Aturan Turunan</h3>
<div class="rumus-box">
Aturan Konstanta: (c·f)′ = c·f′<br>
Aturan Jumlah:    (f ± g)′ = f′ ± g′<br>
Aturan Perkalian: (f·g)′ = f′g + fg′<br>
Aturan Pembagian: (f/g)′ = (f′g − fg′)/g²<br>
Aturan Rantai:    [f(g(x))]′ = f′(g(x)) · g′(x)
</div>
<div class="contoh-box">
<strong>Aturan perkalian:</strong> h(x) = (x²)(sin x)<br>
h′(x) = 2x·sin x + x²·cos x<br><br>
<strong>Aturan rantai:</strong> h(x) = sin(3x²)<br>
h′(x) = cos(3x²) · 6x = <strong>6x cos(3x²)</strong><br><br>
<strong>Polinom biasa:</strong> f(x) = 5x⁴ − 3x² + 7x − 2<br>
f′(x) = 20x³ − 6x + 7
</div>

<h2>Aplikasi Turunan</h2>
<div class="contoh-box">
<strong>1. Gradien garis singgung</strong> kurva y = f(x) di titik (x₀, f(x₀)):<br>
m = f′(x₀)<br>
Persamaan garis: y − f(x₀) = m(x − x₀)<br><br>
<strong>2. Nilai Stasioner (Ekstrim Lokal)</strong><br>
Syarat: f′(x) = 0 → cari nilai x<br>
Uji turunan kedua:<br>
  f″(x) &lt; 0 → titik maksimum lokal<br>
  f″(x) > 0 → titik minimum lokal<br><br>
<strong>3. Gerak Lurus</strong><br>
s(t) = fungsi posisi<br>
v(t) = s′(t) = kecepatan<br>
a(t) = v′(t) = s″(t) = percepatan
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Limit: nilai pendekatan f(x) saat x→a; atasi 0/0 dengan faktorisasi atau sekawan</li>
  <li>Turunan: f′(x) = lim[f(x+h)−f(x)]/h saat h→0</li>
  <li>(xⁿ)′ = n·xⁿ⁻¹ adalah rumus dasar terpenting</li>
  <li>Aturan rantai: turunan fungsi komposit → kalikan dengan turunan "dalam"</li>
  <li>f′(x) = 0 → titik stasioner; uji f″ untuk tentukan maks/min</li>
  <li>lim(x→0) sinx/x = 1 adalah limit trigonometri yang paling sering muncul</li>
</ul>
</div>`
    },

    'kaidah-xii': {
        kelas: 'Kelas XII',
        judul: '🔢 Kaidah Pencacahan',
        isi: `
<p><strong>Kaidah pencacahan</strong> adalah teknik matematika untuk menghitung jumlah cara suatu kejadian dapat terjadi secara sistematis, tanpa perlu mendaftar semua kemungkinan satu per satu.</p>

<h2>Aturan Penjumlahan</h2>
<p>Digunakan saat memilih <strong>salah satu</strong> dari beberapa kelompok yang terpisah (OR).</p>
<div class="rumus-box">
Jika kejadian A terjadi dengan m cara DAN kejadian B terjadi dengan n cara,<br>
dan keduanya tidak bisa terjadi bersamaan:<br>
Total cara = m + n
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> Hendak pergi ke sekolah, bisa naik 3 jenis bus atau 2 jenis ojek.<br>
Total cara = 3 + 2 = <strong>5 cara</strong><br><br>
<strong>Contoh 2:</strong> Memilih 1 mata pelajaran dari 4 pilihan IPA atau 3 pilihan IPS.<br>
Total = 4 + 3 = <strong>7 cara</strong>
</div>

<h2>Aturan Perkalian (Kaidah Dasar Pencacahan)</h2>
<p>Digunakan saat melakukan beberapa tahap berturutan (AND).</p>
<div class="rumus-box">
Jika tahap 1 bisa dilakukan p cara, tahap 2 bisa dilakukan q cara, dst:<br>
Total cara = p × q × r × …
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> PIN 4 digit (tiap digit 0–9, boleh ulang)<br>
Total = 10 × 10 × 10 × 10 = <strong>10.000 cara</strong><br><br>
<strong>Contoh 2:</strong> Nomor plat 2 huruf + 4 angka (huruf dan angka tidak boleh ulang)<br>
Huruf: 26 × 25 = 650, Angka: 10 × 9 × 8 × 7 = 5040<br>
Total = 650 × 5040 = <strong>3.276.000 cara</strong>
</div>

<h2>Faktorial</h2>
<div class="rumus-box">
n! = n × (n−1) × (n−2) × … × 2 × 1<br>
0! = 1 &nbsp; (by definisi)
</div>
<div class="contoh-box">
1! = 1 &nbsp;|&nbsp; 2! = 2 &nbsp;|&nbsp; 3! = 6 &nbsp;|&nbsp; 4! = 24 &nbsp;|&nbsp; 5! = 120 &nbsp;|&nbsp; 6! = 720
</div>

<h2>Permutasi — Urutan DIPERHATIKAN</h2>
<div class="rumus-box">
P(n, r) = ⁿPᵣ = n! / (n − r)!<br><br>
n = banyak objek tersedia, r = banyak objek dipilih
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> Berapa banyak susunan 3 huruf berbeda dari {A, B, C, D, E}?<br>
P(5,3) = 5!/(5−3)! = 120/2 = <strong>60 susunan</strong><br><br>
<strong>Contoh 2:</strong> Berapa banyak cara 8 peserta lomba mendapatkan juara 1, 2, 3?<br>
P(8,3) = 8!/(8−3)! = 8!/5! = 8×7×6 = <strong>336 cara</strong>
</div>

<h3>Permutasi Melingkar</h3>
<div class="rumus-box">
Pmeling = (n − 1)!<br>
(untuk n objek berbeda yang disusun melingkar)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> 5 orang duduk melingkar di meja bundar.<br>
P = (5−1)! = 4! = <strong>24 cara</strong>
</div>

<h3>Permutasi dengan Unsur yang Sama</h3>
<div class="rumus-box">
P = n! / (n₁! × n₂! × n₃! × …)<br>
nᵢ = banyak unsur yang sama jenis ke-i
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> Susunan huruf dari kata "MATEMATIKA" (10 huruf)<br>
M=2, A=3, T=2, E=1, I=1, K=1<br>
P = 10! / (2! × 3! × 2!) = 3.628.800 / (2×6×2) = <strong>151.200 susunan</strong><br><br>
<strong>Contoh 2:</strong> Susunan kata "BUKU" = 4!/(2!) = 24/2 = <strong>12 susunan</strong>
</div>

<h2>Kombinasi — Urutan TIDAK Diperhatikan</h2>
<div class="rumus-box">
C(n, r) = ⁿCᵣ = n! / [r! × (n − r)!]<br><br>
Sifat penting: C(n, r) = C(n, n−r)
</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> Memilih 3 orang dari 10 untuk panitia (posisi sama).<br>
C(10,3) = 10! / (3! × 7!) = 720/6 = <strong>120 cara</strong><br><br>
<strong>Contoh 2:</strong> Dari 6 pria dan 4 wanita dipilih 4 orang, terdiri 2 pria dan 2 wanita.<br>
C(6,2) × C(4,2) = 15 × 6 = <strong>90 cara</strong><br><br>
<strong>Contoh 3:</strong> Dari 8 titik pada lingkaran, berapa banyak tali busur yang terbentuk?<br>
C(8,2) = 8!/(2!×6!) = 56/2 = <strong>28 tali busur</strong>
</div>

<h2>Perbedaan Permutasi vs Kombinasi</h2>
<div class="contoh-box">
<strong>Permutasi:</strong> Tim relay 4 orang dari 8 (posisi 1,2,3,4 berbeda) → P(8,4) = 1680<br>
<strong>Kombinasi:</strong> Tim 4 orang dari 8 (semua posisi sama) → C(8,4) = 70<br>
<em>Kunci: jika "AB" berbeda dengan "BA" → Permutasi. Jika sama → Kombinasi.</em>
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Aturan jumlah (OR): pilih salah satu → total = m + n</li>
  <li>Aturan kali (AND): lakukan berurutan → total = p × q × r</li>
  <li>Permutasi: urutan penting → P(n,r) = n!/(n−r)!</li>
  <li>Permutasi melingkar: (n−1)!</li>
  <li>Permutasi unsur sama: n!/(n₁!·n₂!·…)</li>
  <li>Kombinasi: urutan tidak penting → C(n,r) = n!/[r!(n−r)!]</li>
  <li>C(n,r) = C(n, n−r) sehingga C(10,7) = C(10,3) = 120</li>
</ul>
</div>`
    },

    'logika-xii': {
        kelas: 'Kelas XII',
        judul: '🧠 Logika Matematika',
        isi: `
<p><strong>Logika matematika</strong> mempelajari cara berpikir dan bernalar secara tepat dan sistematis menggunakan pernyataan-pernyataan yang nilai kebenarannya dapat ditentukan. Logika merupakan fondasi pembuktian matematika dan pemrograman komputer.</p>

<h2>Pernyataan (Proposisi)</h2>
<p>Pernyataan adalah kalimat yang nilai kebenarannya dapat ditentukan: <strong>Benar (B)</strong> atau <strong>Salah (S)</strong>, tidak keduanya sekaligus.</p>
<div class="contoh-box">
<strong>Pernyataan:</strong><br>
✓ "Bilangan 7 adalah bilangan prima" → Benar<br>
✓ "2 + 3 = 8" → Salah<br>
✓ "Jakarta adalah ibu kota Indonesia" → Benar<br><br>
<strong>Bukan Pernyataan:</strong><br>
✗ "Apakah kamu sudah makan?" (kalimat tanya)<br>
✗ "Tolong tutup pintunya!" (kalimat perintah)<br>
✗ "x + 5 = 10" (nilai kebenarannya bergantung pada x → kalimat terbuka)
</div>

<h2>Negasi / Ingkaran (¬p atau ~p)</h2>
<div class="rumus-box">
¬p adalah kebalikan nilai kebenaran p<br>
Jika p Benar → ¬p Salah<br>
Jika p Salah → ¬p Benar
</div>
<div class="contoh-box">
p: "Hari ini cerah" (B) → ¬p: "Hari ini tidak cerah" (S)<br>
p: "3 adalah bilangan genap" (S) → ¬p: "3 bukan bilangan genap" (B)
</div>

<h2>Konjungsi (p ∧ q) — "dan"</h2>
<div class="rumus-box">p ∧ q bernilai BENAR hanya jika p dan q keduanya Benar</div>
<div class="contoh-box">
B ∧ B = B &nbsp;|&nbsp; B ∧ S = S &nbsp;|&nbsp; S ∧ B = S &nbsp;|&nbsp; S ∧ S = S<br><br>
<strong>Contoh:</strong> p: "5 > 3" (B), q: "7 < 10" (B)<br>
p ∧ q: "5 > 3 dan 7 < 10" → <strong>Benar</strong>
</div>

<h2>Disjungsi (p ∨ q) — "atau"</h2>
<div class="rumus-box">p ∨ q bernilai SALAH hanya jika p dan q keduanya Salah</div>
<div class="contoh-box">
B ∨ B = B &nbsp;|&nbsp; B ∨ S = B &nbsp;|&nbsp; S ∨ B = B &nbsp;|&nbsp; S ∨ S = S<br><br>
<strong>Contoh:</strong> p: "2 × 5 = 11" (S), q: "Segitiga punya 3 sisi" (B)<br>
p ∨ q: "2×5=11 atau segitiga punya 3 sisi" → <strong>Benar</strong>
</div>

<h2>Implikasi (p → q) — "jika … maka …"</h2>
<div class="rumus-box">p → q bernilai SALAH hanya jika p Benar dan q Salah</div>
<div class="contoh-box">
B→B = B &nbsp;|&nbsp; <strong>B→S = S</strong> &nbsp;|&nbsp; S→B = B &nbsp;|&nbsp; S→S = B<br><br>
<strong>Contoh:</strong> "Jika hujan, maka jalanan basah"<br>
Hanya salah jika: hujan (B) tapi jalanan tidak basah (S)
</div>

<h3>Pernyataan-Pernyataan Terkait Implikasi</h3>
<div class="rumus-box">
Dari implikasi p → q :<br>
Konvers       : q → p<br>
Invers        : ¬p → ¬q<br>
Kontraposisi  : ¬q → ¬p  &nbsp; ← ekuivalen dengan p → q !
</div>
<div class="contoh-box">
<strong>Contoh:</strong> p → q: "Jika hujan (p) maka tanah basah (q)"<br>
Konvers: "Jika tanah basah maka hujan"<br>
Invers: "Jika tidak hujan maka tanah tidak basah"<br>
Kontraposisi: "Jika tanah tidak basah maka tidak hujan" ← sama kuat dengan implikasi asal
</div>

<h2>Biimplikasi (p ↔ q) — "… jika dan hanya jika …"</h2>
<div class="rumus-box">
p ↔ q bernilai BENAR jika p dan q memiliki nilai kebenaran yang SAMA<br>
p ↔ q ≡ (p → q) ∧ (q → p)
</div>
<div class="contoh-box">
B↔B = B &nbsp;|&nbsp; B↔S = S &nbsp;|&nbsp; S↔B = S &nbsp;|&nbsp; S↔S = B<br><br>
<strong>Contoh:</strong> "x = 4 jika dan hanya jika x² = 16"<br>
Untuk x = 4: p Benar, q Benar → p ↔ q <strong>Benar</strong><br>
Untuk x = −4: p Salah, q Benar → p ↔ q <strong>Salah</strong>
</div>

<h2>Tabel Kebenaran Lengkap</h2>
<div class="contoh-box">
p &nbsp; q &nbsp;| ¬p | p∧q | p∨q | p→q | p↔q<br>
B &nbsp; B &nbsp;|  S  |  B  |  B  |  B  |  B<br>
B &nbsp; S &nbsp;|  S  |  S  |  B  |  S  |  S<br>
S &nbsp; B &nbsp;|  B  |  S  |  B  |  B  |  S<br>
S &nbsp; S &nbsp;|  B  |  S  |  S  |  B  |  B
</div>

<h2>Penarikan Kesimpulan</h2>
<div class="rumus-box">
Modus Ponens (MP):<br>
  Premis 1: p → q<br>
  Premis 2: p (benar)<br>
  Kesimpulan: ∴ q<br><br>
Modus Tollens (MT):<br>
  Premis 1: p → q<br>
  Premis 2: ¬q (benar)<br>
  Kesimpulan: ∴ ¬p<br><br>
Silogisme Hipotesis (SH):<br>
  Premis 1: p → q<br>
  Premis 2: q → r<br>
  Kesimpulan: ∴ p → r
</div>
<div class="contoh-box">
<strong>Modus Ponens:</strong><br>
P1: Jika Ali rajin belajar, maka Ali lulus ujian.<br>
P2: Ali rajin belajar.<br>
∴ Ali lulus ujian. ✓<br><br>
<strong>Modus Tollens:</strong><br>
P1: Jika Ali rajin belajar, maka Ali lulus ujian.<br>
P2: Ali tidak lulus ujian.<br>
∴ Ali tidak rajin belajar. ✓<br><br>
<strong>Silogisme:</strong><br>
P1: Jika hujan, maka tanah basah.<br>
P2: Jika tanah basah, maka tanaman tumbuh subur.<br>
∴ Jika hujan, maka tanaman tumbuh subur. ✓
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Pernyataan: kalimat yang bisa dinilai B atau S (bukan tanya/perintah/terbuka)</li>
  <li>Konjungsi (∧): B hanya jika keduanya B</li>
  <li>Disjungsi (∨): S hanya jika keduanya S</li>
  <li>Implikasi (→): S hanya jika depan B dan belakang S</li>
  <li>Kontraposisi (¬q→¬p) selalu ekuivalen dengan implikasi asalnya (p→q)</li>
  <li>Biimplikasi (↔): B hanya jika kedua pernyataan bernilai sama</li>
  <li>MP: dari p→q dan p, simpulkan q</li>
  <li>MT: dari p→q dan ¬q, simpulkan ¬p</li>
  <li>Silogisme: dari p→q dan q→r, simpulkan p→r</li>
</ul>
</div>`
    },

    'integral-xii': {
        kelas: 'Kelas XII',
        judul: '∫ Integral',
        isi: `
<p>Integral adalah operasi kebalikan dari turunan (antideferensiasi). Integral digunakan untuk menghitung luas daerah, volume benda putar, panjang busur, dan banyak aplikasi lainnya.</p>

<h2>Integral Tak Tentu</h2>
<div class="rumus-box">
∫ xⁿ dx = xⁿ⁺¹/(n+1) + C &nbsp; (n ≠ −1)<br>
∫ k dx = kx + C<br>
∫ sin x dx = −cos x + C<br>
∫ cos x dx = sin x + C<br>
∫ sec²x dx = tan x + C<br>
∫ eˣ dx = eˣ + C<br>
∫ (1/x) dx = ln|x| + C
</div>
<div class="contoh-box">
<strong>Contoh:</strong><br>
∫ (6x² − 4x + 3) dx = 2x³ − 2x² + 3x + C<br>
∫ 5eˣ dx = 5eˣ + C
</div>

<h2>Sifat Integral</h2>
<div class="rumus-box">
∫ [f(x) ± g(x)] dx = ∫f(x)dx ± ∫g(x)dx<br>
∫ k·f(x) dx = k · ∫f(x)dx
</div>

<h2>Teknik Integral</h2>

<h3>Substitusi</h3>
<div class="contoh-box">
<strong>Contoh:</strong> ∫ 2x(x²+1)⁵ dx<br>
Misal u = x²+1 → du = 2x dx<br>
= ∫ u⁵ du = u⁶/6 + C = (x²+1)⁶/6 + C
</div>

<h3>Parsial: ∫ u dv = uv − ∫ v du</h3>
<div class="contoh-box">
<strong>Contoh:</strong> ∫ x·eˣ dx<br>
u = x → du = dx; &nbsp; dv = eˣ dx → v = eˣ<br>
= x·eˣ − ∫ eˣ dx = x·eˣ − eˣ + C = eˣ(x − 1) + C
</div>

<h2>Integral Tentu — Teorema Dasar Kalkulus</h2>
<div class="rumus-box">∫ₐᵇ f(x) dx = F(b) − F(a) &nbsp; di mana F′ = f</div>
<div class="contoh-box">
<strong>Contoh 1:</strong> ∫₁³ (2x + 1) dx = [x² + x]₁³ = (9+3) − (1+1) = 12 − 2 = 10<br>
<strong>Contoh 2:</strong> ∫₀^(π/2) cos x dx = [sin x]₀^(π/2) = 1 − 0 = 1
</div>

<h2>Aplikasi Integral</h2>
<div class="rumus-box">
Luas daerah: L = ∫ₐᵇ |f(x)| dx<br>
Antara dua kurva: L = ∫ₐᵇ |f(x) − g(x)| dx<br>
Volume (rotasi sumbu-x): V = π ∫ₐᵇ [f(x)]² dx
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Integral tak tentu = antiderivatif + konstanta C</li>
  <li>∫xⁿdx = xⁿ⁺¹/(n+1) + C adalah rumus utama</li>
  <li>Integral tentu: F(b) − F(a) (tidak ada C)</li>
  <li>Substitusi untuk fungsi komposit</li>
  <li>Parsial: ∫u dv = uv − ∫v du</li>
  <li>Digunakan untuk luas, volume, panjang busur</li>
</ul>
</div>`
    }

}; // end MATERI_DATA

/* ---- Buka Modal Materi ---- */
function bukaMateri(id) {
    var data = MATERI_DATA[id];
    if (!data) return;
    document.getElementById('modal-kelas-badge').textContent  = data.kelas;
    document.getElementById('materiModalLabel').textContent   = data.judul;
    document.getElementById('materiModalBody').innerHTML      = data.isi;
    var modal = new bootstrap.Modal(document.getElementById('materiModal'));
    modal.show();
}

/* =============================================
   AI TUTOR — FamorAI
   Uses local PHP backend + OpenAI Responses API
   ============================================= */

var aiConversation = [];
var aiTyping = false;

function scrollAIChat() {
    var msgs = document.getElementById('ai-messages');
    if (msgs) msgs.scrollTop = msgs.scrollHeight;
}

function addMessage(role, text) {
    var msgs = document.getElementById('ai-messages');
    if (!msgs) return;
    var div = document.createElement('div');
    div.className = 'msg-bubble msg-' + (role === 'ai' ? 'ai' : 'user');
    div.innerHTML = '<div class="msg-sender">' + (role === 'ai' ? '🤖 FamorAI' : '👤 Kamu') + '</div>' + escapeHtml(text);
    msgs.appendChild(div);
    scrollAIChat();
}

function addThinking() {
    var msgs = document.getElementById('ai-messages');
    if (!msgs) return;
    var div = document.createElement('div');
    div.className = 'msg-bubble msg-ai';
    div.id = 'ai-thinking-bubble';
    div.innerHTML = '<div class="msg-sender">🤖 FamorAI</div><div class="ai-thinking"><span></span><span></span><span></span></div>';
    msgs.appendChild(div);
    scrollAIChat();
}

function removeThinking() {
    var t = document.getElementById('ai-thinking-bubble');
    if (t) t.remove();
}

function escapeHtml(text) {
    return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

function formatAIText(text) {
    var html = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    html = html.replace(/\$([^$]+)\$/g, '<code>$1</code>');
    html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
    html = html.replace(/\bsqrt\(([^)]+)\)/gi, 'akar($1)');
    html = html.replace(/\b([A-Za-z]+)_([A-Za-z0-9+\-]+)/g, '$1<sub>$2</sub>');
    html = html.replace(/([A-Za-z0-9)\]])\^([A-Za-z0-9+\-]+)/g, '$1<sup>$2</sup>');
    html = html.replace(/\n\n+/g, '</p><p>');
    html = html.replace(/\n/g, '<br>');
    html = '<p>' + html + '</p>';
    html = html.replace(/<br>(\d+\.\s)/g, '<br><strong>$1</strong>');
    html = html.replace(/<br>([-*]\s)/g, '<br><strong>$1</strong>');
    return html;
}

function enhanceLastAIMessage(text) {
    var aiMessages = document.querySelectorAll('.msg-bubble.msg-ai');
    var lastBubble = aiMessages[aiMessages.length - 1];
    if (!lastBubble) return;
    lastBubble.innerHTML = '<div class="msg-sender">FamorAI</div>' + formatAIText(text);
}

async function sendAIMessage() {
    if (aiTyping) return;
    var input = document.getElementById('ai-input');
    var msg = input.value.trim();
    if (!msg) return;

    input.value = '';
    addMessage('user', msg);
    aiConversation.push({ role: 'user', content: msg });

    aiTyping = true;
    var btn = document.getElementById('ai-send-btn');
    if (btn) btn.disabled = true;
    addThinking();

    try {
        var response = await fetch('ai-chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                messages: aiConversation
            })
        });

        var data = await response.json();
        removeThinking();

        var replyText = '';
        if (response.ok && data.reply) {
            replyText = data.reply;
        } else if (data.error) {
            replyText = 'Maaf, terjadi kesalahan. Coba lagi ya! 😅';
        } else {
            replyText = 'Hmm, aku tidak bisa menjawab saat ini. Coba tanya ulang! 🙏';
        }

        if (!response.ok && data.error) {
            replyText = 'Maaf, ' + data.error;
        }

        aiConversation.push({ role: 'assistant', content: replyText });
        addMessage('ai', replyText);
        enhanceLastAIMessage(replyText);

    } catch (err) {
        removeThinking();
        addMessage('ai', 'Koneksi bermasalah nih 😅 Pastikan kamu terhubung ke internet, lalu coba lagi!');
    }

    aiTyping = false;
    if (btn) btn.disabled = false;
    if (input) input.focus();
}

function askAI(prompt) {
    var input = document.getElementById('ai-input');
    if (input) { input.value = prompt; sendAIMessage(); }
}

// Enter key to send
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('ai-input');
    if (input) {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendAIMessage(); }
        });
    }
});


/* ---- Init ---- */
document.addEventListener('DOMContentLoaded', function() {
    var userClass = document.body.dataset.userClass || 'X';
    selectMateri(userClass);
    selectLatihan(userClass);
    updateTime();
    setInterval(updateTime, 1000);
    setInterval(autoReload, 1000);
});
