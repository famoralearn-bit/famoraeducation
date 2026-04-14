<?php
require_once '../config/config.php';

header('Content-Type: application/json; charset=utf-8');

function famorai_normalize_cache_text($text) {
    $text = mb_strtolower(trim($text));
    $text = preg_replace('/\s+/', ' ', $text);
    return $text;
}

function famorai_cache_dir() {
    return __DIR__ . DIRECTORY_SEPARATOR . 'cache';
}

function famorai_cache_key($studentClass, $model, $question) {
    return sha1('v3|' . $model . '|' . famorai_normalize_cache_text($question));
}

function famorai_get_cached_reply($cacheKey, $ttlSeconds) {
    $cacheFile = famorai_cache_dir() . DIRECTORY_SEPARATOR . $cacheKey . '.json';
    if (!is_file($cacheFile)) {
        return '';
    }

    $raw = @file_get_contents($cacheFile);
    $data = json_decode((string) $raw, true);
    if (!is_array($data) || !isset($data['reply'], $data['created_at'])) {
        return '';
    }

    if ((time() - (int) $data['created_at']) > $ttlSeconds) {
        return '';
    }

    return is_string($data['reply']) ? trim($data['reply']) : '';
}

function famorai_store_cached_reply($cacheKey, $reply) {
    $cacheDir = famorai_cache_dir();
    if (!is_dir($cacheDir)) {
        @mkdir($cacheDir, 0777, true);
    }

    if (!is_dir($cacheDir)) {
        return;
    }

    $cacheFile = $cacheDir . DIRECTORY_SEPARATOR . $cacheKey . '.json';
    $payload = json_encode([
        'created_at' => time(),
        'reply' => $reply
    ]);

    if ($payload !== false) {
        @file_put_contents($cacheFile, $payload, LOCK_EX);
    }
}

function famorai_rate_limit_dir() {
    return __DIR__ . DIRECTORY_SEPARATOR . 'rate-limit';
}

function famorai_ensure_dir($dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    return is_dir($dir);
}

function famorai_is_rate_limited($userId, $windowSeconds, $maxRequests) {
    $dir = famorai_rate_limit_dir();
    if (!famorai_ensure_dir($dir)) {
        return false;
    }

    $file = $dir . DIRECTORY_SEPARATOR . 'user-' . intval($userId) . '.json';
    $now = time();
    $timestamps = [];

    if (is_file($file)) {
        $raw = @file_get_contents($file);
        $data = json_decode((string) $raw, true);
        if (is_array($data)) {
            foreach ($data as $timestamp) {
                $timestamp = (int) $timestamp;
                if (($now - $timestamp) < $windowSeconds) {
                    $timestamps[] = $timestamp;
                }
            }
        }
    }

    if (count($timestamps) >= $maxRequests) {
        @file_put_contents($file, json_encode($timestamps), LOCK_EX);
        return true;
    }

    $timestamps[] = $now;
    @file_put_contents($file, json_encode($timestamps), LOCK_EX);
    return false;
}

function famorai_local_fallback_reply($question, $studentClass) {
    $normalized = famorai_normalize_cache_text($question);

    $faq = [
        'eksponen' => "Konsep: Eksponen adalah bentuk perpangkatan, misalnya 2^3 = 2 x 2 x 2 = 8.\n\nContoh:\n1. a^m x a^n = a^(m+n)\n2. a^m / a^n = a^(m-n)\n3. (a^m)^n = a^(m x n)\n\nJawaban akhir: Kalau mau, kirim soal eksponenmu dan FamorAI akan bantu langkahnya.",
        'logaritma' => "Konsep: Logaritma adalah kebalikan dari eksponen. Jika a^b = c, maka log_a(c) = b.\n\nContoh:\nlog_2(8) = 3 karena 2^3 = 8.\n\nJawaban akhir: Kalau ada soal logaritma tertentu, kirim soalnya ya.",
        'integral' => "Konsep: Integral adalah kebalikan dari turunan.\n\nContoh:\n∫ x^2 dx = x^3/3 + C\n∫ 2x dx = x^2 + C\n\nJawaban akhir: Kalau mau, kirim fungsi yang ingin diintegralkan.",
        'turunan' => "Konsep: Turunan menunjukkan laju perubahan suatu fungsi.\n\nContoh:\nJika f(x) = x^2, maka f'(x) = 2x.\nJika f(x) = 3x^3, maka f'(x) = 9x^2.\n\nJawaban akhir: Kirim soalnya kalau kamu mau dibantu langkah per langkah.",
        'trigonometri' => "Konsep: Trigonometri membahas hubungan sudut dan sisi.\n\nContoh:\nsin = depan / miring\ncos = samping / miring\ntan = depan / samping\n\nJawaban akhir: Kalau ada soal sudut atau identitas trig, kirim saja.",
        'peluang' => "Konsep: Peluang adalah kemungkinan suatu kejadian.\n\nRumus dasar:\nP(A) = banyak kejadian A / banyak ruang sampel\n\nJawaban akhir: Kalau ada soal peluang, kirim data soalnya agar bisa dihitung.",
        'baris' => "Konsep: Barisan adalah urutan bilangan menurut pola tertentu, sedangkan deret adalah jumlah suku-sukunya.\n\nContoh:\nBarisan aritmetika: 2, 5, 8, 11\nBeda = 3\n\nJawaban akhir: Jika kamu punya soal baris atau deret, kirim soalnya ya.",
        'matriks' => "Konsep: Matriks adalah susunan bilangan dalam baris dan kolom.\n\nContoh:\nPenjumlahan matriks dilakukan elemen per elemen.\n\nJawaban akhir: Kalau ada operasi matriks yang mau dibahas, kirim bentuk matriksnya.",
        'limit' => "Konsep: Limit adalah nilai yang didekati fungsi saat x mendekati angka tertentu.\n\nContoh:\nlim x->2 (x+1) = 3\n\nJawaban akhir: Kalau ada limit bentuk pecahan atau akar, kirim soalnya.",
    ];

    foreach ($faq as $keyword => $reply) {
        if (strpos($normalized, $keyword) !== false) {
            return $reply;
        }
    }

    return "FamorAI sedang sibuk untuk sementara. Coba kirim lagi pertanyaan matematika {$studentClass} dengan lebih spesifik, misalnya topik, rumus, atau soalnya, agar saya bantu secara ringkas.";
}

function famorai_local_fallback_reply_v2($question, $studentClass) {
    $normalized = famorai_normalize_cache_text($question);

    $faq = [
        'eksponen' => "Konsep: Eksponen adalah bentuk perpangkatan, misalnya 2^3 = 2 x 2 x 2 = 8.\n\nContoh:\n1. a^m x a^n = a^(m+n)\n2. a^m / a^n = a^(m-n)\n3. (a^m)^n = a^(m x n)\n4. (a x b)^n = a^n x b^n\n\nJawaban akhir: Kalau mau, kirim soal eksponenmu dan FamorAI akan bantu langkahnya.",
        'logaritma' => "Konsep: Logaritma adalah kebalikan dari eksponen. Jika a^b = c, maka log_a(c) = b.\n\nContoh:\nlog_2(8) = 3 karena 2^3 = 8.\n\nJawaban akhir: Kalau ada soal logaritma tertentu, kirim soalnya ya.",
        'integral' => "Konsep: Integral adalah kebalikan dari turunan.\n\nContoh:\nIntegral x^2 dx = x^3/3 + C\nIntegral 2x dx = x^2 + C\n\nJawaban akhir: Kalau mau, kirim fungsi yang ingin diintegralkan.",
        'turunan' => "Konsep: Turunan menunjukkan laju perubahan suatu fungsi.\n\nContoh:\nJika f(x) = x^2, maka f'(x) = 2x.\nJika f(x) = 3x^3, maka f'(x) = 9x^2.\n\nJawaban akhir: Kirim soalnya kalau kamu mau dibantu langkah per langkah.",
        'trigonometri' => "Konsep: Trigonometri membahas hubungan sudut dan sisi.\n\nContoh:\nsin = depan / miring\ncos = samping / miring\ntan = depan / samping\n\nJawaban akhir: Kalau ada soal sudut atau identitas trigonometri, kirim saja.",
        'peluang' => "Konsep: Peluang adalah kemungkinan suatu kejadian.\n\nRumus dasar:\nP(A) = banyak kejadian A / banyak ruang sampel\n\nJawaban akhir: Kalau ada soal peluang, kirim data soalnya agar bisa dihitung.",
        'baris' => "Konsep: Barisan adalah urutan bilangan menurut pola tertentu, sedangkan deret adalah jumlah suku-sukunya.\n\nContoh:\nBarisan aritmetika: 2, 5, 8, 11\nBeda = 3\n\nJawaban akhir: Jika kamu punya soal baris atau deret, kirim soalnya ya.",
        'matriks' => "Konsep: Matriks adalah susunan bilangan dalam baris dan kolom.\n\nContoh:\nPenjumlahan matriks dilakukan elemen per elemen.\n\nJawaban akhir: Kalau ada operasi matriks yang mau dibahas, kirim bentuk matriksnya.",
        'limit' => "Konsep: Limit adalah nilai yang didekati fungsi saat x mendekati angka tertentu.\n\nContoh:\nlim x->2 (x+1) = 3\n\nJawaban akhir: Kalau ada limit bentuk pecahan atau akar, kirim soalnya.",
    ];

    foreach ($faq as $keyword => $reply) {
        if (strpos($normalized, $keyword) !== false) {
            return $reply;
        }
    }

    return "FamorAI sedang sibuk untuk sementara. Coba kirim lagi pertanyaan matematika {$studentClass} dengan lebih spesifik, misalnya topik, rumus, atau soalnya, agar saya bantu secara ringkas.";
}

function famorai_local_topic_reply($question) {
    $normalized = famorai_normalize_cache_text($question);

    $topics = [
        'eksponen' => "Konsep: Eksponen adalah perpangkatan. Bentuk umum a^n berarti a dikalikan berulang sebanyak n kali.\n\nContoh:\n1. a^m x a^n = a^(m+n)\n2. a^m / a^n = a^(m-n)\n3. (a^m)^n = a^(m x n)\n4. (a x b)^n = a^n x b^n\n\nJawaban akhir: Jika kamu punya soal eksponen, kirim soalnya dan saya bantu langkahnya.",
        'logaritma' => "Konsep: Logaritma adalah kebalikan dari eksponen. Jika a^b = c, maka log_a(c) = b.\n\nContoh:\nlog_2(8) = 3 karena 2^3 = 8.\n\nJawaban akhir: Jika ada soal logaritma tertentu, kirim soalnya ya.",
        'baris dan deret' => "Konsep: Barisan adalah urutan bilangan, sedangkan deret adalah jumlah suku-suku barisan.\n\nContoh:\nBarisan aritmetika: 2, 5, 8, 11 dengan beda 3.\nRumus suku ke-n: U_n = a + (n-1)b\n\nJawaban akhir: Kalau mau, kirim soal baris atau deretnya.",
        'baris' => "Konsep: Barisan adalah urutan bilangan, sedangkan deret adalah jumlah suku-suku barisan.\n\nContoh:\nBarisan aritmetika: 2, 5, 8, 11 dengan beda 3.\nRumus suku ke-n: U_n = a + (n-1)b\n\nJawaban akhir: Kalau mau, kirim soal baris atau deretnya.",
        'deret' => "Konsep: Barisan adalah urutan bilangan, sedangkan deret adalah jumlah suku-suku barisan.\n\nContoh:\nBarisan aritmetika: 2, 5, 8, 11 dengan beda 3.\nRumus suku ke-n: U_n = a + (n-1)b\n\nJawaban akhir: Kalau mau, kirim soal baris atau deretnya.",
        'trigonometri' => "Konsep: Trigonometri membahas hubungan sudut dan sisi.\n\nContoh:\nsin = depan / miring\ncos = samping / miring\ntan = depan / samping\n\nJawaban akhir: Kalau ada soal sudut atau identitas trigonometri, kirim saja.",
        'fungsi komposisi' => "Konsep: Fungsi komposisi menggabungkan dua fungsi. Bentuk umumnya (f o g)(x) = f(g(x)).\n\nContoh:\nJika f(x) = 2x + 1 dan g(x) = x^2, maka (f o g)(x) = 2x^2 + 1.\n\nJawaban akhir: Kalau mau, kirim fungsi yang ingin dikomposisikan.",
        'peluang' => "Konsep: Peluang adalah kemungkinan suatu kejadian.\n\nRumus dasar:\nP(A) = banyak kejadian A / banyak ruang sampel\n\nJawaban akhir: Kalau ada soal peluang, kirim data soalnya agar bisa dihitung.",
        'statistika' => "Konsep: Statistika mempelajari pengolahan data. Ukuran yang sering dipakai adalah mean, median, dan modus.\n\nContoh:\nMean = jumlah data / banyak data\n\nJawaban akhir: Kalau ada data yang ingin dihitung, kirim angkanya ya.",
        'relasi dan fungsi' => "Konsep: Relasi menghubungkan anggota dua himpunan, sedangkan fungsi memasangkan setiap anggota domain ke tepat satu anggota kodomain.\n\nContoh:\nJika f(x) = 2x + 3, maka f(2) = 7.\n\nJawaban akhir: Kalau ada soal relasi atau fungsi, kirim bentuk soalnya.",
        'relasi & fungsi' => "Konsep: Relasi menghubungkan anggota dua himpunan, sedangkan fungsi memasangkan setiap anggota domain ke tepat satu anggota kodomain.\n\nContoh:\nJika f(x) = 2x + 3, maka f(2) = 7.\n\nJawaban akhir: Kalau ada soal relasi atau fungsi, kirim bentuk soalnya.",
        'limit' => "Konsep: Limit adalah nilai yang didekati fungsi saat x mendekati nilai tertentu.\n\nContoh:\nlim x->2 (x+1) = 3\n\nJawaban akhir: Kalau ada limit bentuk pecahan atau akar, kirim soalnya.",
        'turunan' => "Konsep: Turunan menunjukkan laju perubahan suatu fungsi.\n\nContoh:\nJika f(x) = x^2, maka f'(x) = 2x.\nJika f(x) = 3x^3, maka f'(x) = 9x^2.\n\nJawaban akhir: Kirim soalnya kalau kamu mau dibantu langkah per langkah.",
        'limit dan turunan' => "Konsep: Limit adalah nilai yang didekati fungsi, sedangkan turunan adalah laju perubahan fungsi.\n\nContoh:\nlim x->2 (x+1) = 3\nJika f(x) = x^2, maka f'(x) = 2x.\n\nJawaban akhir: Kalau ada soal limit atau turunan, kirim soalnya.",
        'kaidah pencacahan' => "Konsep: Kaidah pencacahan digunakan untuk menghitung banyak cara suatu kejadian terjadi.\n\nContoh:\nPermutasi: P(n,r) = n! / (n-r)!\nKombinasi: C(n,r) = n! / (r!(n-r)!)\n\nJawaban akhir: Kalau ada soal permutasi atau kombinasi, kirim soalnya.",
        'logika matematika' => "Konsep: Logika matematika mempelajari pernyataan dan nilai kebenarannya.\n\nContoh:\nKonjungsi: p dan q\nDisjungsi: p atau q\nImplikasi: jika p maka q\n\nJawaban akhir: Kalau ada soal tabel kebenaran atau implikasi, kirim soalnya.",
        'integral' => "Konsep: Integral adalah kebalikan dari turunan.\n\nContoh:\nIntegral x^2 dx = x^3/3 + C\nIntegral 2x dx = x^2 + C\n\nJawaban akhir: Kalau mau, kirim fungsi yang ingin diintegralkan.",
    ];

    foreach ($topics as $keyword => $reply) {
        if (strpos($normalized, $keyword) !== false) {
            return $reply;
        }
    }

    return '';
}

function famorai_local_topic_reply_v2($question) {
    $normalized = famorai_normalize_cache_text($question);

    $greetings = ['hai', 'halo', 'hi', 'helo', 'hello', 'pagi', 'siang', 'sore', 'malam'];
    foreach ($greetings as $greeting) {
        if ($normalized === $greeting || strpos($normalized, $greeting . ' ') === 0) {
            return "Halo! Saya FamorAI. Kamu bisa tanya materi matematika apa saja di sini, misalnya eksponen, logaritma, peluang, integral, atau kirim soal yang ingin dibahas.";
        }
    }

    // Hanya cocok PERSIS dengan teks quick prompt chip dari dashboard.
    // Pertanyaan/soal bebas dilanjutkan ke Gemini AI.
    $exactChipPrompts = [
        'jelaskan trigonometri dasar dengan contoh' =>
"Trigonometri mempelajari hubungan sudut dan sisi segitiga siku-siku.\n\nRumus Dasar (SOH-CAH-TOA):\n sin θ = sisi depan / sisi miring\n cos θ = sisi samping / sisi miring\n tan θ = sisi depan / sisi samping\n tan θ = sin θ / cos θ\n sin²θ + cos²θ = 1\n\nSudut Istimewa:\n  0°  → sin=0, cos=1, tan=0\n 30°  → sin=1/2, cos=½√3, tan=1/√3\n 45°  → sin=½√2, cos=½√2, tan=1\n 60°  → sin=½√3, cos=1/2, tan=√3\n 90°  → sin=1, cos=0, tan=tak terdefinisi\n\nContoh 1:\nTangga panjang 10 m, sudut ke lantai 60°. Tinggi dinding?\nsin 60° = tinggi/10 → tinggi = 10 × ½√3 = 5√3 ≈ 8,66 m\n\nContoh 2:\nDiketahui cos θ = 3/5. Tentukan sin θ dan tan θ!\nsin²θ = 1 − 9/25 = 16/25 → sin θ = 4/5\ntan θ = (4/5)/(3/5) = 4/3\n\nKesimpulan: Hafal sudut istimewa dan identitas Pythagoras, soal trigonometri apapun bisa ditaklukkan!",

        'apa itu fungsi komposisi dan bagaimana cara mengerjakannya?' =>
"Fungsi komposisi adalah penggabungan dua fungsi di mana hasil fungsi pertama menjadi input fungsi kedua.\n\nNotasi:\n (f ∘ g)(x) = f(g(x)) → g dikerjakan dulu\n (g ∘ f)(x) = g(f(x)) → f dikerjakan dulu\n\nLangkah:\n1. Tentukan fungsi dalam (yang dikerjakan lebih dulu)\n2. Substitusikan hasilnya ke fungsi luar\n3. Sederhanakan\n\nContoh 1:\nf(x) = 2x + 1, g(x) = x²\n(f ∘ g)(x) = f(g(x)) = f(x²) = 2x² + 1\n\nContoh 2 (nilai tertentu):\n(f ∘ g)(3) → g(3) = 9 → f(9) = 2(9)+1 = 19\n\nContoh 3 (urutan terbalik):\n(g ∘ f)(x) = g(2x+1) = (2x+1)² = 4x² + 4x + 1\n\nPerhatian: (f ∘ g) ≠ (g ∘ f) — urutan sangat berpengaruh!\n\nCara mencari fungsi invers komposisi:\nJika (f ∘ g)(x) diketahui dan f(x) diketahui, substitusi mundur untuk mencari g(x).\n\nKesimpulan: Kerjakan fungsi dalam dulu, baru fungsi luar. Kirim soalmu!",

        'jelaskan statistika dasar seperti mean median modus' =>
"Statistika mempelajari cara mengolah dan menganalisis data.\n\n=== UKURAN PEMUSATAN ===\n\n1. MEAN (Rata-rata)\nRumus: x̄ = Σx / n\nContoh: data 70, 80, 75, 90, 85\nMean = (70+80+75+90+85)/5 = 400/5 = 80\n\n2. MEDIAN (Nilai Tengah)\nLangkah: urutkan dulu!\n• n ganjil → median = data ke-(n+1)/2\n• n genap → median = rata-rata data ke-n/2 dan (n/2)+1\nContoh (n=5): 70, 75, [80], 85, 90 → Median = 80\nContoh (n=6): 70,75,[80,85],90,95 → Median = (80+85)/2 = 82,5\n\n3. MODUS\nNilai yang paling sering muncul.\nContoh: 70, 80, 80, 90, 85, 80 → Modus = 80 (muncul 3×)\n\n=== UKURAN PENYEBARAN ===\nJangkauan = data maks − data min\nKuartil: Q1 (25%), Q2=Median (50%), Q3 (75%)\nInterkuartil (IK) = Q3 − Q1\n\n=== SIMPANGAN BAKU ===\nMengukur seberapa jauh data menyebar dari mean.\ns = √(Σ(xᵢ - x̄)² / n)\n\nKesimpulan: Mean untuk data normal, median jika ada data ekstrem. Kirim datamu!",

        'apa itu relasi dan fungsi?' =>
"Relasi dan fungsi menghubungkan dua himpunan.\n\n=== RELASI ===\nRelasi adalah aturan yang memasangkan anggota himpunan A ke himpunan B.\n\nCara menyatakan relasi:\n1. Diagram panah\n2. Himpunan pasangan berurutan: {(1,a),(2,b),...}\n3. Grafik koordinat\n4. Tabel\n\n=== FUNGSI ===\nFungsi adalah relasi KHUSUS: setiap anggota domain dipasangkan dengan TEPAT SATU anggota kodomain.\n\nSyarat fungsi:\n• Setiap anggota domain punya pasangan\n• Setiap anggota domain hanya punya SATU pasangan (tidak boleh bercabang)\n\nIstilah:\n• Domain = daerah asal (A)\n• Kodomain = daerah kawan (B)\n• Range = hasil yang benar-benar tercapai ⊆ Kodomain\n\nContoh:\nf(x) = 2x + 3\nf(0)=3, f(1)=5, f(2)=7, f(-1)=1\n\nJenis fungsi:\n• Linear: f(x)=ax+b → garis lurus\n• Kuadrat: f(x)=ax²+bx+c → parabola\n• Konstan: f(x)=c → garis horizontal\n\nMenentukan apakah suatu fungsi one-to-one:\nJika f(a)=f(b) → a=b, maka fungsi injektif.\n\nKesimpulan: Semua fungsi adalah relasi, tapi tidak semua relasi adalah fungsi!",

        'jelaskan limit dan turunan dengan contoh sederhana' =>
"Limit dan turunan adalah dua fondasi kalkulus yang saling berkaitan.\n\n=== LIMIT ===\nLimit adalah nilai yang didekati f(x) ketika x mendekati nilai tertentu.\nNotasi: lim(x→a) f(x) = L\n\nCara hitung:\n1. Substitusi langsung:\n   lim(x→2)(x²+3x) = 4+6 = 10\n\n2. Faktorisasi (jika 0/0):\n   lim(x→2)(x²−4)/(x−2) = lim(x→2)(x+2)(x−2)/(x−2) = 4\n\n3. Kali sekawan (jika ada akar):\n   lim(x→0)(√(x+4)−2)/x → kalikan (√(x+4)+2)/(√(x+4)+2)\n   = lim(x→0) x / (x(√(x+4)+2)) = 1/(2+2) = 1/4\n\n=== TURUNAN ===\nTurunan = laju perubahan fungsi = kemiringan garis singgung.\nNotasi: f'(x) atau dy/dx\n\nRumus dasar:\n• d/dx(xⁿ) = n·xⁿ⁻¹\n• d/dx(k) = 0\n• d/dx(ax+b) = a\n\nContoh lengkap:\nf(x) = 3x⁴ + 2x³ − 5x + 7\nf'(x) = 12x³ + 6x² − 5\n\nAturan rantai:\nd/dx[f(g(x))] = f'(g(x))·g'(x)\nContoh: h(x)=(2x+1)³ → h'(x)=3(2x+1)²·2 = 6(2x+1)²\n\nAplikasi:\n• f'(x)=0 → titik stasioner (max/min)\n• f'(x)>0 → naik, f'(x)<0 → turun\n\nKesimpulan: Limit = fondasi, turunan = aplikasinya. Kirim soalmu!",

        'apa itu kaidah pencacahan, permutasi, dan kombinasi?' =>
"Kaidah pencacahan = cara menghitung banyaknya kemungkinan suatu kejadian.\n\n=== KAIDAH DASAR ===\n1. Aturan Penjumlahan (saling lepas)\n   A bisa m cara, B bisa n cara → A atau B = m+n cara\n   Contoh: 3 jalur darat + 2 jalur air = 5 cara ke sekolah\n\n2. Aturan Perkalian (berurutan)\n   A bisa m cara, B bisa n cara → A dan B = m×n cara\n   Contoh: 3 baju × 2 celana = 6 kombinasi\n\n=== FAKTORIAL ===\nn! = n×(n-1)×...×2×1\n5! = 120,  4! = 24,  0! = 1\n\n=== PERMUTASI (Urutan PENTING) ===\nP(n,r) = n! / (n-r)!\n\nContoh: 5 siswa dipilih 3 jadi ketua/wakil/sekretaris\nP(5,3) = 5!/2! = 120/2 = 60 cara\n\nPermutasi melingkar: (n-1)!\nContoh: 6 orang melingkar = 5! = 120 cara\n\nPermutasi dengan pengulangan: n! / (k1!·k2!·...)\nContoh: susunan huruf MATEMATIKA\n\n=== KOMBINASI (Urutan TIDAK PENTING) ===\nC(n,r) = n! / (r!·(n-r)!)\n\nContoh: 10 siswa pilih 3 untuk tim\nC(10,3) = 10!/(3!·7!) = 720/6 = 120 cara\n\nKesimpulan: Permutasi = posisi penting (AB≠BA), Kombinasi = hanya pilih (AB=BA). Kirim soalmu!",

        'jelaskan logika matematika dasar' =>
"Logika matematika mempelajari pernyataan dan nilai kebenarannya.\n\n=== PERNYATAAN ===\nKalimat yang bernilai BENAR (B) atau SALAH (S).\nContoh pernyataan: '2+2=4' (B), '5 genap' (S)\nBukan pernyataan: 'Tutup pintu!', 'x+2=5'\n\n=== 5 OPERASI LOGIKA ===\n\n1. NEGASI (~p): membalik nilai\n   ~B=S, ~S=B\n\n2. KONJUNGSI (p∧q = 'p DAN q')\n   Benar HANYA jika keduanya benar\n   B∧B=B | B∧S=S | S∧B=S | S∧S=S\n\n3. DISJUNGSI (p∨q = 'p ATAU q')\n   Salah HANYA jika keduanya salah\n   B∨B=B | B∨S=B | S∨B=B | S∨S=S\n\n4. IMPLIKASI (p→q = 'jika p maka q')\n   Salah HANYA jika p=B dan q=S\n   B→B=B | B→S=S | S→B=B | S→S=B\n\n5. BIIMPLIKASI (p↔q = 'p jika dan hanya jika q')\n   Benar jika p dan q bernilai SAMA\n   B↔B=B | B↔S=S | S↔B=S | S↔S=B\n\n=== TURUNAN IMPLIKASI p→q ===\n• Konvers:       q → p\n• Invers:        ~p → ~q\n• Kontraposisi:  ~q → ~p  ← ekuivalen dengan p→q!\n\nKesimpulan: Implikasi paling sering diuji. Ingat: hanya B→S yang salah!",

        'jelaskan rumus eksponen dengan contoh' =>
"Eksponen = perkalian berulang suatu bilangan terhadap dirinya sendiri.\naⁿ = a × a × ... × a (n kali),  a=basis, n=pangkat\nContoh: 2⁵ = 32\n\n=== 8 SIFAT EKSPONEN ===\n\n1. aᵐ × aⁿ = aᵐ⁺ⁿ\n   Contoh: 3² × 3⁴ = 3⁶ = 729\n\n2. aᵐ ÷ aⁿ = aᵐ⁻ⁿ  (a≠0)\n   Contoh: 5⁷ ÷ 5³ = 5⁴ = 625\n\n3. (aᵐ)ⁿ = aᵐˣⁿ\n   Contoh: (2³)⁴ = 2¹² = 4096\n\n4. (a×b)ⁿ = aⁿ×bⁿ\n   Contoh: (2×3)⁴ = 16×81 = 1296\n\n5. (a/b)ⁿ = aⁿ/bⁿ  (b≠0)\n   Contoh: (4/2)³ = 64/8 = 8\n\n6. a⁰ = 1  (a≠0)\n   Contoh: 5⁰=1, (-7)⁰=1\n\n7. a⁻ⁿ = 1/aⁿ  (a≠0)\n   Contoh: 2⁻³=1/8=0,125,  5⁻²=0,04\n\n8. a^(m/n) = ⁿ√(aᵐ)\n   Contoh: 8^(1/3)=∛8=2,  16^(3/4)=⁴√(16³)=8\n\n=== SOAL GABUNGAN ===\nSederhanakan: (2x³y²)³ ÷ (4x²y⁵)\n= 8x⁹y⁶ ÷ 4x²y⁵\n= 2x⁷y\n\nKesimpulan: Hafal 8 sifat ini → semua soal eksponen bisa diselesaikan! Kirim soalmu.",

        'apa itu logaritma dan bagaimana cara menghitungnya?' =>
"Logaritma adalah kebalikan (invers) dari eksponen.\n\nHubungan dasar:\nbˣ = y  ↔  ᵦlog y = x\nSyarat: b>0, b≠1, y>0\n\nContoh konversi:\n2³=8   ↔ ²log 8=3\n3⁴=81  ↔ ³log 81=4\n10³=1000 ↔ log 1000=3\n5⁰=1   ↔ ⁵log 1=0\n\n=== 6 SIFAT LOGARITMA ===\n\n1. Log Perkalian\n   ᵦlog(p×q) = ᵦlog p + ᵦlog q\n   Contoh: ²log(4×8) = 2+3 = 5 ✓\n\n2. Log Pembagian\n   ᵦlog(p/q) = ᵦlog p − ᵦlog q\n   Contoh: ²log(32/4) = 5−2 = 3 ✓\n\n3. Log Pangkat\n   ᵦlog(pⁿ) = n × ᵦlog p\n   Contoh: ²log 64 = ²log 2⁶ = 6\n\n4. Nilai Khusus\n   ᵦlog b = 1,  ᵦlog 1 = 0\n\n5. Pergantian Basis\n   ᵦlog x = (log x)/(log b)\n   Contoh: ²log 5 ≈ 0,699/0,301 ≈ 2,32\n\n6. Sifat Perpindahan\n   ᵦlog x = 1/(ₓlog b)\n\n=== CONTOH SOAL ===\nHitung: ²log 4 + ²log 8 − ²log 2\n= ²log(4×8/2) = ²log 16 = 4 ✓\n\nPersamaan log:\n²log(3x−1)=3 → 3x−1=8 → x=3\n\nKesimpulan: Kuasai 6 sifat ini → semua soal log bisa diselesaikan! Kirim soalmu.",

        'jelaskan baris dan deret aritmetika' =>
"Barisan = urutan bilangan berpola. Deret = jumlah suku-sukunya.\n\n=== BARISAN ARITMETIKA ===\nBeda antar suku berturutan selalu SAMA (tetap).\nb = U₂−U₁ = U₃−U₂ = ...\n\nRumus suku ke-n:\nUₙ = a + (n−1)b\n• a = suku pertama, b = beda\n\nContoh: 3, 7, 11, 15, ... (a=3, b=4)\nU₁₀ = 3 + 9×4 = 39\nU₂₀ = 3 + 19×4 = 79\n\n=== DERET ARITMETIKA ===\nJumlah n suku pertama:\nSₙ = n/2 × (2a + (n−1)b)\natau: Sₙ = n/2 × (U₁ + Uₙ)\n\nContoh: S₁₀ dari 3,7,11,...\nU₁₀=39\nS₁₀ = 10/2×(3+39) = 5×42 = 210 ✓\n\n=== MENCARI a DAN b DARI DUA SUKU ===\nU₄=11 dan U₇=20:\na+3b=11 ... (i)\na+6b=20 ... (ii)\n(ii)−(i): 3b=9 → b=3, a=2\nBarisan: 2,5,8,11,14,17,20,...\n\n=== BARISAN GEOMETRI (Bonus) ===\nRasio r=U₂/U₁ tetap\nUₙ = a × rⁿ⁻¹\nSₙ = a(rⁿ−1)/(r−1)  untuk r≠1\nS∞ = a/(1−r)  untuk |r|<1 (deret konvergen)\n\nContoh: 2,6,18,54,... (a=2,r=3)\nU₅ = 2×3⁴ = 162\n\nKesimpulan: Aritmetika=beda tetap, Geometri=rasio tetap. Kirim soalmu!",

        'bagaimana cara menghitung peluang suatu kejadian?' =>
"Peluang = ukuran kemungkinan suatu kejadian, nilainya antara 0 sampai 1.\n\nRumus dasar:\nP(A) = n(A) / n(S)\n• n(A) = banyak cara kejadian A terjadi\n• n(S) = banyak semua kemungkinan (ruang sampel)\n• P=0 → mustahil, P=1 → pasti\n• P(A) + P(Aᶜ) = 1\n\n=== CONTOH DASAR ===\n\nLempar 1 Dadu, n(S)=6:\nP(angka 3) = 1/6\nP(genap) = 3/6 = 1/2 → {2,4,6}\nP(>4) = 2/6 = 1/3 → {5,6}\n\nKartu Remi (52 kartu):\nP(As) = 4/52 = 1/13\nP(hati) = 13/52 = 1/4\nP(merah) = 26/52 = 1/2\n\n=== PELUANG GABUNGAN ===\n\n1. Tidak Saling Lepas:\n   P(A∪B) = P(A)+P(B)−P(A∩B)\n   Contoh: P(As atau hati)\n   = 4/52+13/52−1/52 = 16/52 = 4/13\n\n2. Saling Lepas (tidak bisa bersamaan):\n   P(A∪B) = P(A)+P(B)\n\n3. Kejadian Bebas (tidak saling mempengaruhi):\n   P(A∩B) = P(A)×P(B)\n   Contoh: P(angka koin DAN dadu 6) = 1/2×1/6 = 1/12\n\n=== FREKUENSI HARAPAN ===\nFh = P(A) × n\nContoh: Dadu 120 kali → Fh(angka 2) = 1/6×120 = 20\n\nKesimpulan: Tentukan ruang sampel dulu, baru hitung. Kirim soal peluangmu!",

        'apa itu integral dan bagaimana cara menghitungnya?' =>
"Integral adalah kebalikan (anti-turunan) dari turunan. Ada dua jenis utama.\n\n=== INTEGRAL TAK TENTU ===\nHasil selalu ditambah konstanta C.\n\nRumus dasar:\n∫ xⁿ dx = xⁿ⁺¹/(n+1) + C  (n≠−1)\n∫ k dx = kx + C\n∫ kf(x) dx = k·∫f(x) dx\n∫ [f(x)±g(x)] dx = ∫f(x) dx ± ∫g(x) dx\n\nContoh:\n∫ x³ dx = x⁴/4 + C\n∫ 5x² dx = 5x³/3 + C\n∫ (3x²+2x−7) dx = x³+x²−7x + C\n\nVerifikasi: turunkan hasilnya → harus kembali ke fungsi asal.\n\n=== TEKNIK SUBSTITUSI ===\n∫ 2x(x²+1)⁴ dx\nMisalkan u=x²+1, du=2x dx\n= ∫ u⁴ du = u⁵/5 + C = (x²+1)⁵/5 + C\n\n=== INTEGRAL TENTU ===\n∫[a,b] f(x) dx = F(b) − F(a)\nMengukur luas daerah antara kurva dan sumbu-x.\n\nContoh:\n∫[1,3] (2x+1) dx\nF(x) = x²+x\n= F(3)−F(1) = 12−2 = 10  ← luas = 10 satuan\n\n=== LUAS ANTARA DUA KURVA ===\nL = ∫[a,b] |f(x)−g(x)| dx\nContoh: antara y=x dan y=x² dari 0 ke 1\nL = ∫[0,1](x−x²) dx = [x²/2−x³/3]₀¹ = 1/2−1/3 = 1/6\n\nKesimpulan: Integral tak tentu +C, integral tentu = nilai angka. Kirim fungsimu!",
    ];

    foreach ($exactChipPrompts as $chipPrompt => $reply) {
        if ($normalized === $chipPrompt) {
            return $reply;
        }
    }

    return '';
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if (famorai_is_rate_limited($_SESSION['user_id'], 20, 6)) {
    http_response_code(429);
    echo json_encode([
        'error' => 'Terlalu banyak pertanyaan dalam waktu singkat. Coba lagi beberapa detik ya.'
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$apiKey = get_gemini_api_key();
if ($apiKey === '') {
    http_response_code(500);
    echo json_encode([
        'error' => 'Gemini API key belum dikonfigurasi di server.'
    ]);
    exit();
}

if (!function_exists('curl_init')) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Ekstensi cURL PHP belum aktif di server.'
    ]);
    exit();
}

$rawInput = file_get_contents('php://input');
$payload = json_decode($rawInput, true);

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['error' => 'Payload tidak valid.']);
    exit();
}

$messages = isset($payload['messages']) && is_array($payload['messages']) ? $payload['messages'] : [];
if (count($messages) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Pesan tidak boleh kosong.']);
    exit();
}

$studentName = isset($_SESSION['nama']) ? trim((string) $_SESSION['nama']) : 'Siswa';
$studentClass = isset($_SESSION['kelas']) ? trim((string) $_SESSION['kelas']) : 'Matematika';
$model = get_gemini_model();

$instructions = "Kamu adalah FamorAI, tutor matematika untuk platform FamoraLearn. "
    . "Bantu siswa Indonesia dengan bahasa Indonesia yang ramah, jelas, singkat, dan hemat kata. "
    . "Fokus pada matematika sekolah secara umum, tidak perlu membatasi jawaban berdasarkan kelas. "
    . "Kalau user hanya menyapa, perkenalkan diri secara singkat dan ramah tanpa memaksa langsung ke materi. "
    . "Jika ada soal hitungan, jelaskan langkah inti saja secara runtut. "
    . "Gunakan notasi matematika teks yang rapi dan sederhana, misalnya x^2, akar(16), 3/4, sin x. "
    . "Hindari LaTeX dan hindari penjelasan terlalu panjang. "
    . "Sapa siswa seperlunya sebagai {$studentName}. "
    . "Jika pertanyaan konsep, jawab dengan format singkat: Konsep, Contoh. "
    . "Jika pertanyaan soal, jawab dengan format singkat: Diketahui, Langkah, Jawaban akhir. "
    . "Batasi jawaban maksimal sekitar 120 kata kecuali user meminta detail. "
    . "Jika pertanyaan di luar matematika SMA, arahkan dengan sopan kembali ke topik matematika.";

$contents = [];
$recentMessages = array_slice($messages, -6);
$lastUserMessage = '';

foreach ($recentMessages as $message) {
    if (!is_array($message)) {
        continue;
    }

    $role = isset($message['role']) ? (string) $message['role'] : '';
    $content = isset($message['content']) ? trim((string) $message['content']) : '';

    if ($content === '') {
        continue;
    }

    if (mb_strlen($content) > 600) {
        $content = mb_substr($content, 0, 600);
    }

    if ($role === 'user') {
        $lastUserMessage = $content;
    }

    $contents[] = [
        'role' => $role === 'assistant' ? 'model' : 'user',
        'parts' => [
            ['text' => $content]
        ]
    ];
}

if (count($contents) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Tidak ada pesan yang bisa diproses.']);
    exit();
}

$user_input = strtolower($lastUserMessage);

if (
    strpos($user_input, 'siapa yang buat') !== false ||
    strpos($user_input, 'siapa pembuat') !== false ||
    strpos($user_input, 'who made you') !== false
) {
    echo json_encode([
        "reply" => "FamoraAI dibuat oleh FamoraEducation, dibuat oleh sekelompok pelajar SMK jurusan TJKT.
        yang didirikan pada tahun 2026 oleh CEO bernama Aldino Galuh Tristanto."
    ]);
    exit();
}

if (mb_strlen($lastUserMessage) > 250) {
    $contents = [[
        'role' => 'user',
        'parts' => [
            ['text' => $lastUserMessage]
        ]
    ]];
}

$localTopicReply = $lastUserMessage !== '' ? famorai_local_topic_reply_v2($lastUserMessage) : '';
if ($localTopicReply !== '') {
    echo json_encode([
        'reply' => $localTopicReply,
        'local' => true
    ]);
    exit();
}

$shouldUseCache = $lastUserMessage !== '' && count($contents) <= 4;
$cacheTtlSeconds = 6 * 60 * 60;
$cacheKey = '';

if ($shouldUseCache) {
    $cacheKey = famorai_cache_key($studentClass, $model, $lastUserMessage);
    $cachedReply = famorai_get_cached_reply($cacheKey, $cacheTtlSeconds);
    if ($cachedReply !== '') {
        echo json_encode([
            'reply' => $cachedReply,
            'cached' => true
        ]);
        exit();
    }
}

$requestBody = [
    'system_instruction' => [
        'parts' => [
            ['text' => $instructions]
        ]
    ],
    'contents' => $contents,
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 220
    ]
];
$url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent';

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'x-goog-api-key: ' . $apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($requestBody),
    CURLOPT_TIMEOUT => 45
]);

$responseBody = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($responseBody === false) {
    http_response_code(502);
    echo json_encode([
        'error' => 'Gagal terhubung ke Gemini.',
        'details' => $curlError
    ]);
    exit();
}

$responseData = json_decode($responseBody, true);
if (!is_array($responseData)) {
    http_response_code(502);
    echo json_encode([
        'error' => 'Respons Gemini tidak valid.'
    ]);
    exit();
}

if ($httpCode >= 400) {
    $errorMessage = 'Permintaan ke Gemini gagal.';
    if (isset($responseData['error']['message']) && is_string($responseData['error']['message'])) {
        $errorMessage = $responseData['error']['message'];
    }

    if ($httpCode === 429) {
        $fallbackReply = famorai_local_fallback_reply_v2($lastUserMessage, $studentClass);
        echo json_encode([
            'reply' => $fallbackReply,
            'fallback' => true
        ]);
        exit();
    }

    http_response_code($httpCode);
    echo json_encode(['error' => $errorMessage]);
    exit();
}

$replyText = '';
if (
    isset($responseData['candidates'][0]['content']['parts'])
    && is_array($responseData['candidates'][0]['content']['parts'])
) {
    foreach ($responseData['candidates'][0]['content']['parts'] as $part) {
        if (is_array($part) && isset($part['text']) && is_string($part['text'])) {
            $replyText .= $part['text'];
        }
    }
}

if ($replyText === '') {
    http_response_code(502);
    echo json_encode([
        'error' => 'Gemini tidak mengembalikan jawaban teks.'
    ]);
    exit();
}

$replyText = trim($replyText);

if ($shouldUseCache && $cacheKey !== '') {
    famorai_store_cached_reply($cacheKey, $replyText);
}

echo json_encode([
    'reply' => $replyText
]);
