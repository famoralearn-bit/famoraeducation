/* =============================================
   FamoraLearn - Dashboard JS
   ============================================= */

// ---- Class tab selection (Materi) ----
function selectMateri(className) {
    document.querySelectorAll('.materi-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.materi-panel').forEach(p => p.classList.remove('active'));
    const btn   = document.getElementById('materi-btn-' + className);
    const panel = document.getElementById('materi-' + className);
    if (btn)   btn.classList.add('active');
    if (panel) panel.classList.add('active');
}

// ---- Class tab selection (Latihan Soal) ----
function selectLatihan(className) {
    document.querySelectorAll('.latihan-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.latihan-panel').forEach(p => p.classList.remove('active'));
    const btn   = document.getElementById('latihan-btn-' + className);
    const panel = document.getElementById('latihan-' + className);
    if (btn)   btn.classList.add('active');
    if (panel) panel.classList.add('active');
}

// ---- Real-time clock ----
function updateTime() {
    const now = new Date();
    const hms = [now.getHours(), now.getMinutes(), now.getSeconds()]
        .map(n => String(n).padStart(2, '0')).join(':');
    const el = document.getElementById('current-time');
    if (el) el.textContent = hms;
}

// ---- Auto reload on 16:00 and 20:00 ----
function autoReload() {
    const now = new Date();
    if ((now.getHours() === 16 || now.getHours() === 20)
        && now.getMinutes() === 0 && now.getSeconds() === 0) {
        location.reload();
    }
}

// ============================================================
//   KONTEN MATERI
// ============================================================
const MATERI_DATA = {

    // ===================== KELAS X =====================
    'eksponen-x': {
        kelas: 'Kelas X',
        judul: '⚡ Eksponen',
        isi: `
<p>Eksponen adalah cara menulis perkalian berulang dari suatu bilangan. Dengan eksponen, kita bisa menyingkat penulisan dan menghitung angka-angka yang besar atau rumit dengan lebih mudah. Dalam notasi eksponen, ada dua bagian penting: <strong>basis</strong> dan <strong>eksponen</strong>. Basis adalah bilangan yang dikalikan berulang kali, sedangkan eksponen menunjukkan berapa kali bilangan itu dikalikan dengan dirinya sendiri. Misalnya, <strong>aⁿ</strong> berarti <em>a</em> dikalikan sebanyak <em>n</em> kali.</p>
<p>Eksponen memiliki sejumlah sifat penting yang memudahkan dalam perhitungan. Sifat pertama adalah perkalian dengan basis yang sama — eksponennya dijumlahkan. Sebaliknya, pembagian dengan basis yang sama dilakukan dengan mengurangkan eksponennya.</p>
<p>Selanjutnya, ada aturan pangkat dari pangkat, di mana eksponen dikalikan. Selain itu, eksponen memiliki aturan khusus untuk bilangan berpangkat nol dan negatif. Setiap bilangan selain nol yang dipangkatkan nol selalu bernilai satu, dan eksponen negatif menunjukkan kebalikan dari bilangan berpangkat positif.</p>

<h2>Sifat-Sifat Eksponen</h2>

<h3>1. Perkalian dengan Basis Sama</h3>
<p>Jika dua bilangan dengan basis sama dikalikan, maka eksponennya dijumlahkan.</p>
<div class="rumus-box">aᵐ × aⁿ = aᵐ⁺ⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  2³ × 2⁴ = 2³⁺⁴ = 2⁷ = 128<br>
  5² × 5³ = 5⁵ = 3125
</div>

<h3>2. Pembagian dengan Basis Sama</h3>
<p>Jika dua bilangan dengan basis sama dibagi, maka eksponennya dikurangkan.</p>
<div class="rumus-box">aᵐ ÷ aⁿ = aᵐ⁻ⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  3⁵ ÷ 3² = 3³ = 27<br>
  10⁴ ÷ 10¹ = 10³ = 1000
</div>

<h3>3. Pangkat dari Pangkat</h3>
<p>Jika sebuah bilangan berpangkat dipangkatkan lagi, maka eksponennya dikalikan.</p>
<div class="rumus-box">(aᵐ)ⁿ = aᵐˣⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  (2³)² = 2⁶ = 64<br>
  (5²)³ = 5⁶ = 15625
</div>

<h3>4. Pangkat dari Perkalian</h3>
<p>Jika suatu perkalian dipangkatkan, maka setiap faktor ikut dipangkatkan.</p>
<div class="rumus-box">(ab)ⁿ = aⁿ × bⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  (2 × 3)² = 2² × 3² = 4 × 9 = 36<br>
  (4 × 5)² = 4² × 5² = 16 × 25 = 400
</div>

<h3>5. Pangkat dari Pembagian</h3>
<p>Jika suatu pembagian dipangkatkan, maka pembilang dan penyebut dipangkatkan.</p>
<div class="rumus-box">(a/b)ⁿ = aⁿ / bⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  (4/2)² = 4²/2² = 16/4 = 4<br>
  (6/3)² = 36/9 = 4
</div>

<h3>6. Eksponen Nol</h3>
<p>Setiap bilangan selain nol yang dipangkatkan nol bernilai 1.</p>
<div class="rumus-box">a⁰ = 1 &nbsp; (a ≠ 0)</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  5⁰ = 1 &nbsp;&nbsp; 10⁰ = 1 &nbsp;&nbsp; 99⁰ = 1
</div>

<h3>7. Eksponen Negatif</h3>
<p>Eksponen negatif menunjukkan kebalikan dari pangkat positif.</p>
<div class="rumus-box">a⁻ⁿ = 1 / aⁿ</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  2⁻³ = 1/2³ = 1/8<br>
  5⁻² = 1/25
</div>

<h3>8. Pangkat Pecahan</h3>
<p>Eksponen pecahan menunjukkan akar dari bilangan.</p>
<div class="rumus-box">a^(1/n) = ⁿ√a</div>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  16^(1/2) = √16 = 4<br>
  27^(1/3) = ³√27 = 3
</div>

<h3>9. Pangkat Desimal</h3>
<p>Eksponen desimal adalah bentuk lain dari pangkat pecahan.</p>
<div class="contoh-box">
  <strong>Contoh:</strong><br>
  9^0.5 = 9^(1/2) = √9 = 3<br>
  16^0.5 = 4
</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <p>Eksponen digunakan untuk menyederhanakan perkalian berulang. Aturan-aturan penting:</p>
  <ul>
    <li>Perkalian pangkat → eksponen dijumlah</li>
    <li>Pembagian pangkat → eksponen dikurang</li>
    <li>Pangkat dari pangkat → eksponen dikali</li>
    <li>Pangkat nol → hasilnya 1</li>
    <li>Pangkat negatif → bentuk pecahan (1/aⁿ)</li>
    <li>Pangkat pecahan → bentuk akar</li>
  </ul>
</div>`
    },

    'logaritma-x': {
        kelas: 'Kelas X',
        judul: '📈 Logaritma',
        isi: `
<p>Logaritma adalah operasi kebalikan dari eksponen. Jika aⁿ = b, maka <strong>ₐlog b = n</strong>. Logaritma menjawab pertanyaan: "Pangkat berapa yang harus kita berikan pada basis untuk mendapatkan suatu bilangan?"</p>

<h2>Bentuk Umum</h2>
<div class="rumus-box">ₐlog b = n  ⟺  aⁿ = b</div>
<div class="contoh-box"><strong>Contoh:</strong><br>²log 8 = 3 karena 2³ = 8<br>³log 27 = 3 karena 3³ = 27</div>

<h2>Sifat-Sifat Logaritma</h2>
<h3>1. Logaritma Perkalian</h3>
<div class="rumus-box">ₐlog (b × c) = ₐlog b + ₐlog c</div>

<h3>2. Logaritma Pembagian</h3>
<div class="rumus-box">ₐlog (b / c) = ₐlog b − ₐlog c</div>

<h3>3. Logaritma Pangkat</h3>
<div class="rumus-box">ₐlog bⁿ = n × ₐlog b</div>

<h3>4. Logaritma Basis Sendiri</h3>
<div class="rumus-box">ₐlog a = 1</div>

<h3>5. Logaritma 1</h3>
<div class="rumus-box">ₐlog 1 = 0</div>

<h3>6. Pergantian Basis</h3>
<div class="rumus-box">ₐlog b = (log b) / (log a)</div>

<div class="contoh-box">
  <strong>Contoh Penerapan:</strong><br>
  ²log 32 = ²log 2⁵ = 5<br>
  ¹⁰log 1000 = 3 karena 10³ = 1000
</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Logaritma adalah kebalikan dari eksponen</li>
    <li>ₐlog b = n berarti aⁿ = b</li>
    <li>Logaritma memiliki sifat perkalian, pembagian, dan pangkat</li>
    <li>Log basis 10 disebut logaritma umum, basis e disebut logaritma natural (ln)</li>
  </ul>
</div>`
    },

    'barisderet-x': {
        kelas: 'Kelas X',
        judul: '🔗 Baris & Deret',
        isi: `
<p>Barisan adalah urutan bilangan yang memiliki pola tertentu. Deret adalah jumlah dari suku-suku suatu barisan.</p>

<h2>Barisan Aritmetika</h2>
<p>Barisan di mana setiap suku memiliki selisih tetap (beda = <strong>b</strong>).</p>
<div class="rumus-box">Uₙ = a + (n−1)b</div>
<div class="contoh-box"><strong>Contoh:</strong> 2, 5, 8, 11, ... (b = 3)<br>U₅ = 2 + (5−1)×3 = 14</div>

<h2>Deret Aritmetika</h2>
<div class="rumus-box">Sₙ = n/2 × (2a + (n−1)b)  atau  Sₙ = n/2 × (a + Uₙ)</div>

<h2>Barisan Geometri</h2>
<p>Barisan di mana setiap suku memiliki rasio tetap (<strong>r</strong>).</p>
<div class="rumus-box">Uₙ = a × rⁿ⁻¹</div>
<div class="contoh-box"><strong>Contoh:</strong> 3, 6, 12, 24, ... (r = 2)<br>U₅ = 3 × 2⁴ = 48</div>

<h2>Deret Geometri</h2>
<div class="rumus-box">Sₙ = a(rⁿ − 1)/(r − 1)  untuk r ≠ 1</div>

<h2>Deret Geometri Tak Hingga</h2>
<div class="rumus-box">S∞ = a/(1−r)  untuk |r| &lt; 1</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Barisan Aritmetika: beda (b) tetap → Uₙ = a + (n−1)b</li>
    <li>Barisan Geometri: rasio (r) tetap → Uₙ = a·rⁿ⁻¹</li>
    <li>Deret = jumlah suku-suku barisan</li>
    <li>Deret geometri tak hingga berlaku jika |r| &lt; 1</li>
  </ul>
</div>`
    },

    'trigonometri-x': {
        kelas: 'Kelas X',
        judul: '📐 Trigonometri',
        isi: `
<p>Trigonometri adalah cabang matematika yang mempelajari hubungan antara sudut dan sisi segitiga, terutama segitiga siku-siku.</p>

<h2>Perbandingan Trigonometri</h2>
<div class="rumus-box">
sin θ = sisi depan / sisi miring<br>
cos θ = sisi samping / sisi miring<br>
tan θ = sisi depan / sisi samping
</div>

<h2>Nilai Trigonometri Sudut Istimewa</h2>
<div class="contoh-box">
<strong>Sudut 30°:</strong> sin=1/2, cos=½√3, tan=⅓√3<br>
<strong>Sudut 45°:</strong> sin=½√2, cos=½√2, tan=1<br>
<strong>Sudut 60°:</strong> sin=½√3, cos=1/2, tan=√3<br>
<strong>Sudut 90°:</strong> sin=1, cos=0, tan=∞
</div>

<h2>Identitas Trigonometri Dasar</h2>
<div class="rumus-box">
sin²θ + cos²θ = 1<br>
tan θ = sin θ / cos θ
</div>

<h2>Aturan Sinus & Cosinus</h2>
<div class="rumus-box">
Aturan Sinus: a/sin A = b/sin B = c/sin C<br>
Aturan Cosinus: a² = b² + c² − 2bc·cos A
</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Trigonometri menggunakan sin, cos, tan pada segitiga siku-siku</li>
    <li>Identitas dasar: sin²θ + cos²θ = 1</li>
    <li>Sudut istimewa: 0°, 30°, 45°, 60°, 90°</li>
    <li>Aturan sinus & cosinus untuk segitiga sembarang</li>
  </ul>
</div>`
    },

    // ===================== KELAS XI =====================
    'fungsi-xi': {
        kelas: 'Kelas XI',
        judul: '🔄 Fungsi Komposisi & Invers',
        isi: `
<p>Fungsi komposisi adalah penggabungan dua fungsi sehingga hasil satu fungsi menjadi input fungsi berikutnya. Fungsi invers adalah fungsi kebalikan yang mengembalikan output ke input semula.</p>

<h2>Fungsi Komposisi</h2>
<div class="rumus-box">(f∘g)(x) = f(g(x))</div>
<div class="contoh-box"><strong>Contoh:</strong><br>f(x) = 2x + 1, g(x) = x²<br>(f∘g)(x) = f(x²) = 2x² + 1<br>(g∘f)(x) = g(2x+1) = (2x+1)²</div>

<h2>Sifat Komposisi</h2>
<ul>
  <li>Umumnya f∘g ≠ g∘f (tidak komutatif)</li>
  <li>(f∘g)∘h = f∘(g∘h) (asosiatif)</li>
  <li>f∘I = I∘f = f (I = fungsi identitas)</li>
</ul>

<h2>Fungsi Invers</h2>
<p>Fungsi f⁻¹ adalah invers dari f jika (f∘f⁻¹)(x) = x</p>
<div class="rumus-box">Cara mencari invers: ganti f(x) dengan y, tukar x dan y, selesaikan untuk y</div>
<div class="contoh-box"><strong>Contoh:</strong><br>f(x) = 3x − 2<br>y = 3x − 2 → x = (y+2)/3<br>f⁻¹(x) = (x+2)/3</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Komposisi: (f∘g)(x) = f(g(x)) — output g jadi input f</li>
    <li>Komposisi tidak komutatif (f∘g ≠ g∘f)</li>
    <li>Invers: tukar x dan y lalu selesaikan</li>
    <li>(f∘f⁻¹)(x) = x</li>
  </ul>
</div>`
    },

    'matriks-xi': {
        kelas: 'Kelas XI',
        judul: '🎯 Matriks',
        isi: `
<p>Matriks adalah susunan bilangan dalam bentuk baris dan kolom. Matriks digunakan untuk menyederhanakan sistem persamaan linear dan berbagai aplikasi matematika.</p>

<h2>Operasi Matriks</h2>
<h3>Penjumlahan & Pengurangan</h3>
<p>Hanya bisa dilakukan pada matriks dengan ordo yang sama. Operasi dilakukan pada elemen-elemen yang bersesuaian.</p>
<div class="rumus-box">(A ± B)ᵢⱼ = Aᵢⱼ ± Bᵢⱼ</div>

<h3>Perkalian Matriks</h3>
<p>Matriks A (m×n) dapat dikalikan matriks B (n×p), hasilnya ordo m×p.</p>
<div class="rumus-box">(AB)ᵢⱼ = Σ Aᵢₖ × Bₖⱼ</div>

<h2>Determinan (Ordo 2×2)</h2>
<div class="rumus-box">det|a b; c d| = ad − bc</div>

<h2>Invers Matriks (Ordo 2×2)</h2>
<div class="rumus-box">A⁻¹ = (1/det A) × |d -b; -c a|</div>
<div class="contoh-box"><strong>Contoh:</strong><br>A = |2 1; 3 4| → det = 8−3 = 5<br>A⁻¹ = (1/5)|4 -1; -3 2|</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Penjumlahan/pengurangan: ordo harus sama</li>
    <li>Perkalian: kolom A = baris B</li>
    <li>Determinan 2×2: ad − bc</li>
    <li>Invers ada jika det ≠ 0</li>
  </ul>
</div>`
    },

    'statistika-xi': {
        kelas: 'Kelas XI',
        judul: '📉 Statistika',
        isi: `
<p>Statistika adalah ilmu yang mempelajari cara mengumpulkan, mengolah, menyajikan, dan menganalisis data untuk mengambil kesimpulan.</p>

<h2>Ukuran Pemusatan Data</h2>
<h3>Mean (Rata-rata)</h3>
<div class="rumus-box">x̄ = (Σxᵢ) / n</div>

<h3>Median</h3>
<p>Nilai tengah data setelah diurutkan.</p>
<div class="rumus-box">Data ganjil: nilai tengah<br>Data genap: rata-rata dua nilai tengah</div>

<h3>Modus</h3>
<p>Nilai yang paling sering muncul dalam data.</p>

<h2>Ukuran Penyebaran Data</h2>
<h3>Jangkauan (Range)</h3>
<div class="rumus-box">R = nilai max − nilai min</div>

<h3>Varians & Simpangan Baku</h3>
<div class="rumus-box">
σ² = Σ(xᵢ − x̄)² / n<br>
σ = √σ²
</div>

<div class="contoh-box"><strong>Contoh:</strong><br>Data: 4, 7, 8, 5, 6<br>Mean = (4+7+8+5+6)/5 = 30/5 = 6<br>Median (diurutkan: 4,5,6,7,8) = 6<br>Modus = tidak ada (semua muncul 1 kali)</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Mean = rata-rata semua data</li>
    <li>Median = nilai tengah data terurut</li>
    <li>Modus = nilai yang paling sering muncul</li>
    <li>Simpangan baku mengukur seberapa menyebar data dari rata-rata</li>
  </ul>
</div>`
    },

    'limit-xi': {
        kelas: 'Kelas XI',
        judul: '∞ Limit Fungsi',
        isi: `
<p>Limit adalah nilai yang didekati oleh suatu fungsi ketika variabelnya mendekati suatu titik tertentu.</p>

<h2>Notasi Limit</h2>
<div class="rumus-box">lim f(x) = L &nbsp; (x → a)</div>
<p>Artinya: ketika x mendekati a, nilai f(x) mendekati L.</p>

<h2>Limit Aljabar</h2>
<h3>Substitusi Langsung</h3>
<div class="contoh-box"><strong>Contoh:</strong><br>lim (x→2) (x² + 3x) = 4 + 6 = 10</div>

<h3>Limit Bentuk 0/0 (Faktorisasi)</h3>
<div class="contoh-box"><strong>Contoh:</strong><br>lim (x→2) (x²−4)/(x−2)<br>= lim (x→2) (x+2)(x−2)/(x−2)<br>= lim (x→2) (x+2) = 4</div>

<h2>Limit Trigonometri</h2>
<div class="rumus-box">
lim (x→0) sin x / x = 1<br>
lim (x→0) tan x / x = 1
</div>

<h2>Limit Tak Hingga</h2>
<div class="rumus-box">lim (x→∞) 1/x = 0</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Limit = nilai pendekatan fungsi saat x → a</li>
    <li>Bentuk 0/0 diselesaikan dengan faktorisasi atau L'Hôpital</li>
    <li>lim sin x/x = 1 (x→0) adalah limit trigonometri penting</li>
    <li>Limit tak hingga: lim 1/x = 0 saat x → ∞</li>
  </ul>
</div>`
    },

    // ===================== KELAS XII =====================
    'transformasi-xii': {
        kelas: 'Kelas XII',
        judul: '🌀 Transformasi Fungsi',
        isi: `
<p>Transformasi fungsi adalah perubahan posisi, ukuran, atau bentuk grafik fungsi. Ada empat jenis transformasi dasar: translasi, refleksi, dilatasi, dan rotasi.</p>

<h2>Translasi (Pergeseran)</h2>
<div class="rumus-box">f(x) → f(x−h) + k<br>Geser h satuan ke kanan, k satuan ke atas</div>
<div class="contoh-box"><strong>Contoh:</strong><br>y = x² digeser 3 ke kanan dan 2 ke atas → y = (x−3)² + 2</div>

<h2>Refleksi (Pencerminan)</h2>
<div class="rumus-box">
Terhadap sumbu-x: f(x) → −f(x)<br>
Terhadap sumbu-y: f(x) → f(−x)<br>
Terhadap y=x: tukar x dan y
</div>

<h2>Dilatasi (Peregangan)</h2>
<div class="rumus-box">
Arah vertikal: f(x) → a·f(x)<br>
Arah horizontal: f(x) → f(x/b)
</div>
<div class="contoh-box"><strong>Contoh:</strong><br>y = sin x diperlebar 2× secara horizontal → y = sin(x/2)</div>

<h2>Rotasi</h2>
<p>Rotasi 90° berlawanan jarum jam: (x, y) → (−y, x)</p>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Translasi: geser posisi grafik</li>
    <li>Refleksi: cerminkan grafik terhadap sumbu</li>
    <li>Dilatasi: regangkan atau kompreskan grafik</li>
    <li>Semua transformasi mempengaruhi bentuk/posisi grafik, bukan nilai domain</li>
  </ul>
</div>`
    },

    'matriks-xii': {
        kelas: 'Kelas XII',
        judul: '🎯 Matriks Lanjutan',
        isi: `
<p>Materi matriks kelas XII berfokus pada penerapan matriks untuk menyelesaikan sistem persamaan linear (SPL) dan transformasi geometri.</p>

<h2>Sistem Persamaan Linear dengan Matriks</h2>
<p>SPL: ax + by = p dan cx + dy = q dapat ditulis dalam bentuk matriks:</p>
<div class="rumus-box">
|a b| |x|   |p|<br>
|c d| |y| = |q|<br><br>
Solusi: X = A⁻¹ · B
</div>

<h2>Eliminasi Gauss</h2>
<p>Metode sistematis menyelesaikan SPL menggunakan matriks augmentasi, dengan operasi baris elementer (OBE).</p>

<h2>Transformasi Geometri dengan Matriks</h2>
<div class="rumus-box">
Refleksi terhadap sumbu-x: |1  0|<br>
                            |0 -1|<br><br>
Rotasi 90°: | 0 -1|<br>
            | 1  0|<br><br>
Dilatasi k: |k 0|<br>
            |0 k|
</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>SPL bisa diselesaikan dengan X = A⁻¹B</li>
    <li>Eliminasi Gauss menggunakan matriks augmentasi</li>
    <li>Transformasi geometri bisa diwakili matriks transformasi</li>
  </ul>
</div>`
    },

    'logaritma-xii': {
        kelas: 'Kelas XII',
        judul: '📈 Logaritma Lanjutan',
        isi: `
<p>Di kelas XII, logaritma diperdalam dengan persamaan dan pertidaksamaan logaritma serta penerapannya dalam berbagai masalah.</p>

<h2>Persamaan Logaritma</h2>
<p>Persamaan yang memuat variabel di dalam logaritma.</p>
<div class="rumus-box">ₐlog f(x) = ₐlog g(x)  ⟺  f(x) = g(x)</div>
<div class="contoh-box"><strong>Contoh:</strong><br>²log(x+3) = ²log(2x−1)<br>x + 3 = 2x − 1<br>x = 4</div>

<h2>Persamaan Logaritma Bentuk Kuadrat</h2>
<div class="contoh-box"><strong>Contoh:</strong><br>(²log x)² − 3(²log x) + 2 = 0<br>Misal p = ²log x → p² − 3p + 2 = 0<br>(p−1)(p−2) = 0 → p=1 atau p=2<br>x = 2 atau x = 4</div>

<h2>Pertidaksamaan Logaritma</h2>
<div class="rumus-box">
Jika a > 1: ₐlog f(x) > ₐlog g(x) ⟺ f(x) > g(x)<br>
Jika 0 &lt; a &lt; 1: ₐlog f(x) > ₐlog g(x) ⟺ f(x) &lt; g(x)
</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Persamaan log: samakan basis lalu samakan argumen</li>
    <li>Bentuk kuadrat: substitusi misal p = ₐlog x</li>
    <li>Pertidaksamaan: tanda berubah jika basis 0 &lt; a &lt; 1</li>
    <li>Syarat: argumen logaritma harus positif</li>
  </ul>
</div>`
    },

    'integral-xii': {
        kelas: 'Kelas XII',
        judul: '∫ Integral',
        isi: `
<p>Integral adalah operasi kebalikan dari diferensial (turunan). Integral digunakan untuk menghitung luas daerah, volume, dan banyak aplikasi lainnya.</p>

<h2>Integral Tak Tentu</h2>
<div class="rumus-box">∫ xⁿ dx = xⁿ⁺¹/(n+1) + C &nbsp; (n ≠ −1)</div>
<div class="contoh-box"><strong>Contoh:</strong><br>∫ 3x² dx = x³ + C<br>∫ 4x³ dx = x⁴ + C</div>

<h2>Sifat Integral</h2>
<div class="rumus-box">
∫ [f(x) + g(x)] dx = ∫f(x)dx + ∫g(x)dx<br>
∫ k·f(x) dx = k · ∫f(x)dx
</div>

<h2>Integral Tentu</h2>
<div class="rumus-box">∫ₐᵇ f(x) dx = F(b) − F(a)</div>
<div class="contoh-box"><strong>Contoh:</strong><br>∫₁³ 2x dx = [x²]₁³ = 9 − 1 = 8</div>

<h2>Luas Daerah</h2>
<div class="rumus-box">L = ∫ₐᵇ |f(x)| dx</div>

<div class="kesimpulan-box">
  <h3>📌 Kesimpulan</h3>
  <ul>
    <li>Integral tak tentu: kebalikan turunan, hasilnya fungsi + C</li>
    <li>Integral tentu: dihitung pada interval [a, b]</li>
    <li>Integral tentu = F(b) − F(a)</li>
    <li>Digunakan untuk menghitung luas, volume, dll.</li>
  </ul>
</div>`
    }
};

// ---- Buka Modal Materi ----
function bukaMateri(id) {
    const data = MATERI_DATA[id];
    if (!data) return;

    document.getElementById('modal-kelas-badge').textContent = data.kelas;
    document.getElementById('materiModalLabel').textContent = data.judul;
    document.getElementById('materiModalBody').innerHTML = data.isi;

    const modal = new bootstrap.Modal(document.getElementById('materiModal'));
    modal.show();
}

// ---- DOMContentLoaded ----
document.addEventListener('DOMContentLoaded', function () {
    const userClass = document.body.dataset.userClass || 'X';
    selectMateri(userClass);
    selectLatihan(userClass);

    updateTime();
    setInterval(updateTime, 1000);
    setInterval(autoReload, 1000);
});
