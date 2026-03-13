/* =============================================
   FamoraLearn - Profile JS
   Avatar selector with localStorage
   ============================================= */

const AVATAR_MAP = {
    'priamuda':   '👦',
    'wanitamuda': '👧',
    'pria':       '👨‍🎓',
    'wanita':     '👩‍🎓',
};

function pilihAvatar(id) {
    // Update display besar
    const display = document.getElementById('avatarDisplay');
    if (display) display.textContent = AVATAR_MAP[id] || '👤';

    // Update border terpilih
    Object.keys(AVATAR_MAP).forEach(function(key) {
        var el = document.getElementById('av-' + key);
        if (el) {
            if (key === id) el.classList.add('selected');
            else            el.classList.remove('selected');
        }
    });

    // Simpan pilihan
    try { localStorage.setItem('fl_avatar', id); } catch(e) {}
}

function muatAvatar() {
    var saved = null;
    try { saved = localStorage.getItem('fl_avatar'); } catch(e) {}
    if (saved && AVATAR_MAP[saved]) {
        pilihAvatar(saved);
    } else {
        // Default: pria muda
        pilihAvatar('priamuda');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    muatAvatar();

    // Password match live-check
    var newPwd  = document.getElementById('new_password');
    var confPwd = document.getElementById('confirm_password');
    if (newPwd && confPwd) {
        confPwd.addEventListener('input', function() {
            if (newPwd.value && confPwd.value) {
                var ok = newPwd.value === confPwd.value;
                confPwd.style.borderColor = ok ? '#22c55e' : '#ef4444';
                confPwd.style.borderWidth = '2px';
            } else {
                confPwd.style.borderColor = '';
            }
        });
    }
});
