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
        judul: '🔄 Fungsi Komposisi & Invers',
        isi: `
<p><strong>Fungsi komposisi</strong> menggabungkan dua fungsi sehingga output satu menjadi input yang lain. <strong>Fungsi invers</strong> membalikkan relasi suatu fungsi — input dan output ditukar.</p>

<h2>Fungsi Komposisi</h2>
<div class="rumus-box">
(f ∘ g)(x) = f(g(x))<br>
Artinya: masukkan x ke g lebih dulu, hasilnya masukkan ke f.
</div>
<div class="contoh-box">
<strong>Contoh:</strong> f(x) = 2x + 1, g(x) = x²<br>
(f ∘ g)(x) = f(g(x)) = f(x²) = 2x² + 1<br>
(g ∘ f)(x) = g(f(x)) = g(2x+1) = (2x+1)² = 4x² + 4x + 1<br>
→ f ∘ g ≠ g ∘ f &nbsp; (tidak komutatif)
</div>

<h3>Sifat Komposisi</h3>
<div class="contoh-box">
• Asosiatif: (f ∘ g) ∘ h = f ∘ (g ∘ h)<br>
• Ada elemen identitas: f ∘ I = I ∘ f = f<br>
• Umumnya tidak komutatif: f ∘ g ≠ g ∘ f
</div>

<h2>Fungsi Invers</h2>
<p>f⁻¹ adalah invers dari f jika (f ∘ f⁻¹)(x) = (f⁻¹ ∘ f)(x) = x.</p>

<div class="rumus-box">
Cara mencari f⁻¹(x):<br>
1. Tulis y = f(x)<br>
2. Tukar x dan y → x = f(y)<br>
3. Selesaikan y dalam x → y = f⁻¹(x)
</div>

<div class="contoh-box">
<strong>Contoh 1:</strong> f(x) = 3x − 2<br>
y = 3x − 2 → x = (y + 2)/3 → f⁻¹(x) = (x + 2)/3<br><br>
<strong>Contoh 2:</strong> f(x) = (2x + 1)/(x − 3)<br>
y(x − 3) = 2x + 1 → yx − 3y = 2x + 1 → x(y − 2) = 3y + 1<br>
→ f⁻¹(x) = (3x + 1)/(x − 2)
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>(f ∘ g)(x) = f(g(x)) — output g → input f</li>
  <li>Komposisi tidak komutatif secara umum</li>
  <li>Invers: tukar x dan y lalu selesaikan</li>
  <li>Syarat invers ada: fungsi harus bijektif (1-1 dan onto)</li>
  <li>Grafik f dan f⁻¹ simetri terhadap garis y = x</li>
</ul>
</div>`
    },

    'peluang-xi': {
        kelas: 'Kelas XI',
        judul: '🎲 Peluang',
        isi: `
<p><strong>Peluang</strong> adalah ukuran kemungkinan suatu kejadian terjadi. Nilainya antara 0 (mustahil) dan 1 (pasti terjadi).</p>

<h2>Konsep Dasar</h2>
<div class="rumus-box">
P(A) = n(A) / n(S)<br>
n(A) = banyak kejadian A, &nbsp; n(S) = banyak ruang sampel
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Dadu dilempar. P(muncul angka ganjil)?<br>
S = {1,2,3,4,5,6}, A = {1,3,5}<br>
P(A) = 3/6 = 1/2 = 0,5
</div>

<h2>Sifat-Sifat Peluang</h2>
<div class="rumus-box">
0 ≤ P(A) ≤ 1 untuk setiap kejadian A<br>
P(S) = 1 &nbsp;|&nbsp; P(∅) = 0<br>
P(Aᶜ) = 1 − P(A) &nbsp; (komplemen)
</div>

<h2>Peluang Gabungan (Penjumlahan)</h2>
<div class="rumus-box">P(A ∪ B) = P(A) + P(B) − P(A ∩ B)</div>
<div class="rumus-box">
Jika A dan B saling lepas (P(A ∩ B) = 0):<br>
P(A ∪ B) = P(A) + P(B)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Kartu diambil dari 52 kartu. P(As atau Hati)?<br>
P(As) = 4/52, P(Hati) = 13/52, P(As Hati) = 1/52<br>
P(As ∪ Hati) = 4/52 + 13/52 − 1/52 = 16/52 = 4/13
</div>

<h2>Kejadian Bebas (Independen)</h2>
<div class="rumus-box">P(A ∩ B) = P(A) × P(B)</div>
<div class="contoh-box">
<strong>Contoh:</strong> Dua koin dilempar. P(keduanya muka)?<br>
P = 1/2 × 1/2 = 1/4
</div>

<h2>Peluang Bersyarat</h2>
<div class="rumus-box">P(A | B) = P(A ∩ B) / P(B) &nbsp; (P(B) ≠ 0)</div>
<div class="contoh-box">
<strong>Contoh:</strong> P(A) = 0,3, P(B) = 0,4, P(A∩B) = 0,12<br>
P(A|B) = 0,12 / 0,4 = 0,3 → A dan B saling bebas karena P(A|B) = P(A)
</div>

<h2>Frekuensi Harapan</h2>
<div class="rumus-box">fh = P(A) × n &nbsp; (n = banyak percobaan)</div>
<div class="contoh-box">
<strong>Contoh:</strong> Dadu dilempar 120 kali. Harapan muncul angka 6?<br>
fh = 1/6 × 120 = 20 kali
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>P(A) = n(A)/n(S), nilainya 0 sampai 1</li>
  <li>Komplemen: P(Aᶜ) = 1 − P(A)</li>
  <li>Saling lepas: P(A∪B) = P(A) + P(B)</li>
  <li>Bebas: P(A∩B) = P(A) × P(B)</li>
  <li>Bersyarat: P(A|B) = P(A∩B)/P(B)</li>
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
<p><strong>Relasi</strong> menghubungkan anggota dua himpunan. <strong>Fungsi</strong> adalah relasi khusus di mana setiap elemen domain dipetakan ke tepat satu elemen kodomain.</p>

<h2>Relasi</h2>
<div class="contoh-box">
<strong>Contoh:</strong> A = {1, 2, 3}, B = {2, 4, 6}<br>
Relasi "dikali 2": {(1,2), (2,4), (3,6)}<br>
Cara menyatakan: diagram panah, himpunan pasangan, tabel, atau grafik
</div>

<h2>Fungsi (Pemetaan)</h2>
<p>Fungsi f: A → B jika <strong>setiap</strong> a ∈ A memiliki tepat <strong>satu</strong> pasangan b ∈ B.</p>
<div class="rumus-box">
Domain (Dₓ): nilai x yang boleh dimasukkan<br>
Kodomain: himpunan B (tujuan pemetaan)<br>
Range (Rf): himpunan nilai f(x) yang benar-benar tercapai
</div>

<h2>Jenis-Jenis Fungsi</h2>
<div class="contoh-box">
<strong>Injektif (satu-satu):</strong> x₁ ≠ x₂ → f(x₁) ≠ f(x₂)<br>
<strong>Surjektif (onto):</strong> setiap y di kodomain punya pasangan di domain<br>
<strong>Bijektif:</strong> injektif sekaligus surjektif (korespondensi satu-satu)
</div>

<h2>Domain Fungsi Khusus</h2>
<div class="rumus-box">
Fungsi akar: f(x) = √g(x) → syarat g(x) ≥ 0<br>
Fungsi pecahan: f(x) = p(x)/q(x) → syarat q(x) ≠ 0<br>
Fungsi log: f(x) = log g(x) → syarat g(x) > 0
</div>
<div class="contoh-box">
<strong>Contoh:</strong> f(x) = √(x − 3)<br>
Domain: x − 3 ≥ 0 → x ≥ 3 → Dₓ = [3, ∞)<br><br>
<strong>Contoh:</strong> f(x) = 1/(x² − 4)<br>
Domain: x² − 4 ≠ 0 → x ≠ ±2 → Dₓ = ℝ \ {−2, 2}
</div>

<h2>Operasi pada Fungsi</h2>
<div class="rumus-box">
(f + g)(x) = f(x) + g(x)<br>
(f − g)(x) = f(x) − g(x)<br>
(f · g)(x) = f(x) · g(x)<br>
(f/g)(x) = f(x)/g(x), &nbsp; g(x) ≠ 0
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Fungsi = relasi khusus: satu domain → tepat satu nilai</li>
  <li>Domain: nilai x yang diperbolehkan</li>
  <li>Range: himpunan nilai fungsi yang sesungguhnya</li>
  <li>Injektif: beda input → beda output</li>
  <li>Bijektif: korespondensi satu-satu, syarat memiliki invers</li>
</ul>
</div>`
    },

    /* ==================== KELAS XII ==================== */

    'limitturunan-xii': {
        kelas: 'Kelas XII',
        judul: '📉 Limit & Turunan Fungsi',
        isi: `
<p><strong>Limit</strong> adalah nilai yang didekati fungsi ketika variabelnya mendekati suatu titik. <strong>Turunan</strong> adalah laju perubahan sesaat suatu fungsi, didefinisikan sebagai limit.</p>

<h2>Limit Fungsi</h2>
<div class="rumus-box">lim f(x) = L &nbsp; berarti f(x) mendekati L ketika x → a
    (x→a)</div>

<h3>Teknik Menghitung Limit</h3>
<div class="contoh-box">
<strong>1. Substitusi langsung:</strong><br>
lim(x→3) (x² + 2x) = 9 + 6 = 15<br><br>
<strong>2. Faktorisasi (bentuk 0/0):</strong><br>
lim(x→2) (x²−4)/(x−2) = lim(x→2) (x+2)(x−2)/(x−2) = lim(x→2) (x+2) = 4<br><br>
<strong>3. Kali sekawan (untuk akar):</strong><br>
lim(x→0) (√(x+1)−1)/x × (√(x+1)+1)/(√(x+1)+1)<br>
= lim(x→0) x / [x(√(x+1)+1)] = 1/(1+1) = 1/2
</div>

<h3>Limit Trigonometri Penting</h3>
<div class="rumus-box">
lim(x→0) sin x / x = 1<br>
lim(x→0) tan x / x = 1<br>
lim(x→0) (1 − cos x) / x² = 1/2
</div>

<h2>Turunan Fungsi</h2>
<div class="rumus-box">
f′(x) = lim [f(x+h) − f(x)] / h
       (h→0)
</div>

<h3>Rumus Turunan Dasar</h3>
<div class="rumus-box">
d/dx (c) = 0 &nbsp; (c = konstanta)<br>
d/dx (xⁿ) = n·xⁿ⁻¹<br>
d/dx (sin x) = cos x<br>
d/dx (cos x) = −sin x<br>
d/dx (tan x) = sec²x<br>
d/dx (eˣ) = eˣ<br>
d/dx (ln x) = 1/x
</div>

<h3>Aturan Turunan</h3>
<div class="rumus-box">
Konstanta: d/dx [c·f(x)] = c·f′(x)<br>
Jumlah:    [f + g]′ = f′ + g′<br>
Perkalian: [f·g]′ = f′g + fg′<br>
Pembagian: [f/g]′ = (f′g − fg′)/g²<br>
Rantai:    [f(g(x))]′ = f′(g(x))·g′(x)
</div>

<div class="contoh-box">
<strong>Contoh:</strong><br>
f(x) = 4x³ − 3x² + 2x → f′(x) = 12x² − 6x + 2<br>
f(x) = sin(3x) → f′(x) = 3cos(3x)<br>
f(x) = x²·eˣ → f′(x) = 2x·eˣ + x²·eˣ = eˣ(x² + 2x)
</div>

<h2>Aplikasi Turunan</h2>
<div class="contoh-box">
• Gradien garis singgung kurva di (x₀, f(x₀)) = f′(x₀)<br>
• Nilai stasioner: f′(x) = 0 → cari titik maks/min<br>
• Uji turunan kedua: f″(x) &lt; 0 → maks; f″(x) > 0 → min<br>
• Kecepatan v(t) = s′(t); Percepatan a(t) = v′(t) = s″(t)
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Limit: nilai pendekatan, atasi 0/0 dengan faktorisasi/sekawan</li>
  <li>Turunan: f′(x) = lim [f(x+h)−f(x)]/h saat h→0</li>
  <li>d/dx (xⁿ) = n·xⁿ⁻¹ adalah rumus dasar paling penting</li>
  <li>Aturan rantai untuk fungsi komposit</li>
  <li>f′(x) = 0 → titik stasioner (kandidat maks/min)</li>
</ul>
</div>`
    },

    'kaidah-xii': {
        kelas: 'Kelas XII',
        judul: '🔢 Kaidah Pencacahan',
        isi: `
<p>Kaidah pencacahan adalah metode matematis untuk menghitung jumlah cara suatu peristiwa dapat terjadi tanpa harus mendaftarkan semua kemungkinan satu per satu.</p>

<h2>Aturan Penjumlahan</h2>
<p>Jika peristiwa A terjadi dengan <em>m</em> cara, dan peristiwa B dengan <em>n</em> cara, dan <strong>tidak bisa terjadi bersamaan</strong>:</p>
<div class="rumus-box">Total cara = m + n</div>
<div class="contoh-box">
<strong>Contoh:</strong> Memilih 1 mata pelajaran dari 4 IPA atau 3 IPS<br>
Total = 4 + 3 = 7 cara
</div>

<h2>Aturan Perkalian (Prinsip Fundamental)</h2>
<p>Jika peristiwa A dilakukan dengan <em>m</em> cara, kemudian diikuti peristiwa B dengan <em>n</em> cara:</p>
<div class="rumus-box">Total cara = m × n × ...</div>
<div class="contoh-box">
<strong>Contoh:</strong> Membuat kode PIN 4 digit (0-9, boleh ulang)<br>
Total = 10 × 10 × 10 × 10 = 10.000 cara
</div>

<h2>Faktorial</h2>
<div class="rumus-box">n! = n × (n−1) × (n−2) × … × 2 × 1 &nbsp;|&nbsp; 0! = 1!</div>
<div class="contoh-box">5! = 120 &nbsp;|&nbsp; 4! = 24 &nbsp;|&nbsp; 3! = 6 &nbsp;|&nbsp; 2! = 2 &nbsp;|&nbsp; 1! = 1</div>

<h2>Permutasi — Urutan Diperhatikan</h2>
<div class="rumus-box">
P(n, r) = n! / (n − r)! &nbsp; (r unsur dari n, urutan penting)
</div>
<div class="contoh-box">
<strong>Contoh:</strong> Berapa susunan 3 huruf dari {A, B, C, D, E}?<br>
P(5, 3) = 5!/(5−3)! = 120/2 = 60 susunan
</div>

<h3>Permutasi Khusus</h3>
<div class="contoh-box">
<strong>Melingkar:</strong> P = (n−1)! &nbsp; (kursi bundar, dll.)<br>
<strong>Ada unsur sama:</strong> P = n! / (n₁! × n₂! × …)<br>
Contoh: susunan huruf "MAMA" = 4!/(2!×2!) = 24/4 = 6
</div>

<h2>Kombinasi — Urutan Tidak Diperhatikan</h2>
<div class="rumus-box">C(n, r) = n! / [r! × (n − r)!]</div>
<div class="contoh-box">
<strong>Contoh:</strong> Memilih 3 siswa dari 8 untuk mewakili sekolah<br>
C(8, 3) = 8! / (3! × 5!) = 40320 / (6 × 120) = 56 cara
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Aturan jumlah: OR (pilih salah satu) → tambah</li>
  <li>Aturan kali: AND (lakukan berturutan) → kali</li>
  <li>Permutasi: urutan penting → P(n,r) = n!/(n−r)!</li>
  <li>Kombinasi: urutan tidak penting → C(n,r) = n!/[r!(n−r)!]</li>
  <li>C(n,r) = C(n, n−r) selalu berlaku</li>
</ul>
</div>`
    },

    'logika-xii': {
        kelas: 'Kelas XII',
        judul: '🧠 Logika Matematika',
        isi: `
<p>Logika matematika mempelajari penalaran yang valid berdasarkan pernyataan yang dapat dinilai <strong>benar (B)</strong> atau <strong>salah (S)</strong>. Menjadi fondasi pembuktian matematis dan ilmu komputer.</p>

<h2>Pernyataan (Proposisi)</h2>
<p>Kalimat yang nilai kebenarannya dapat ditentukan (tidak bisa keduanya sekaligus).</p>
<div class="contoh-box">
<strong>Pernyataan:</strong> "7 adalah bilangan prima" (B) &nbsp;|&nbsp; "2 + 3 = 6" (S)<br>
<strong>Bukan pernyataan:</strong> "x + 3 = 7" (tergantung x) &nbsp;|&nbsp; "Tutup pintunya!" (perintah)
</div>

<h2>Negasi (¬p atau ~p)</h2>
<div class="rumus-box">¬p membalik nilai kebenaran p</div>
<div class="contoh-box">p: "Hari ini hujan" → ¬p: "Hari ini tidak hujan"<br>
Tabel: p=B → ¬p=S; &nbsp; p=S → ¬p=B</div>

<h2>Konjungsi (p ∧ q)</h2>
<div class="rumus-box">p ∧ q bernilai B hanya jika KEDUANYA B</div>
<div class="contoh-box">B∧B=B &nbsp;|&nbsp; B∧S=S &nbsp;|&nbsp; S∧B=S &nbsp;|&nbsp; S∧S=S</div>

<h2>Disjungsi (p ∨ q)</h2>
<div class="rumus-box">p ∨ q bernilai S hanya jika KEDUANYA S</div>
<div class="contoh-box">B∨B=B &nbsp;|&nbsp; B∨S=B &nbsp;|&nbsp; S∨B=B &nbsp;|&nbsp; S∨S=S</div>

<h2>Implikasi (p → q)</h2>
<div class="rumus-box">p → q bernilai S hanya jika p=B dan q=S</div>
<div class="contoh-box">B→B=B &nbsp;|&nbsp; B→S=<strong>S</strong> &nbsp;|&nbsp; S→B=B &nbsp;|&nbsp; S→S=B</div>

<h3>Implikasi Terkait</h3>
<div class="contoh-box">
Dari p → q:<br>
<strong>Konvers:</strong> q → p<br>
<strong>Invers:</strong> ¬p → ¬q<br>
<strong>Kontraposisi:</strong> ¬q → ¬p &nbsp; ← ekuivalen dengan p → q!
</div>

<h2>Biimplikasi (p ↔ q)</h2>
<div class="rumus-box">p ↔ q bernilai B jika p dan q memiliki nilai kebenaran SAMA</div>
<div class="contoh-box">B↔B=B &nbsp;|&nbsp; B↔S=S &nbsp;|&nbsp; S↔B=S &nbsp;|&nbsp; S↔S=B</div>

<h2>Penarikan Kesimpulan</h2>
<div class="rumus-box">
Modus Ponens: &nbsp; p→q, &nbsp; p &nbsp; ∴ q<br>
Modus Tollens: &nbsp; p→q, &nbsp; ¬q &nbsp; ∴ ¬p<br>
Silogisme: &nbsp; p→q, &nbsp; q→r &nbsp; ∴ p→r
</div>
<div class="contoh-box">
<strong>Modus Ponens:</strong> Jika hujan maka basah. Sekarang hujan. ∴ Sekarang basah.<br>
<strong>Modus Tollens:</strong> Jika hujan maka basah. Tidak basah. ∴ Tidak hujan.
</div>

<div class="kesimpulan-box">
<h3>📌 Kesimpulan</h3>
<ul>
  <li>Konjungsi (∧): benar hanya jika keduanya benar</li>
  <li>Disjungsi (∨): salah hanya jika keduanya salah</li>
  <li>Implikasi (→): salah hanya jika depan B, belakang S</li>
  <li>Kontraposisi ekuivalen dengan implikasi aslinya</li>
  <li>Tiga metode penarikan kesimpulan: MP, MT, Silogisme</li>
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

/* ---- Init ---- */
document.addEventListener('DOMContentLoaded', function() {
    var userClass = document.body.dataset.userClass || 'X';
    selectMateri(userClass);
    selectLatihan(userClass);
    updateTime();
    setInterval(updateTime, 1000);
    setInterval(autoReload, 1000);
});
