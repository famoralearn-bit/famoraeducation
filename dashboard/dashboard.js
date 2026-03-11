/* =============================================
   MathLearn - Dashboard JS
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

// ---- Auto reload on 16:00 and 20:00 for Discord link ----
function autoReload() {
    const now = new Date();
    if ((now.getHours() === 16 || now.getHours() === 20)
        && now.getMinutes() === 0 && now.getSeconds() === 0) {
        location.reload();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Auto-select user's class on load (injected via PHP)
    const userClass = document.body.dataset.userClass || 'X';
    selectMateri(userClass);
    selectLatihan(userClass);

    updateTime();
    setInterval(updateTime, 1000);
    setInterval(autoReload, 1000);
});
