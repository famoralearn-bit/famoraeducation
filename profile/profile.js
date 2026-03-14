/* =============================================
   FamoraLearn - Profile JS
   Avatar dipilih di client, disimpan ke DB via form POST
   ============================================= */

var AVATAR_DATA = {
    'pria1':   { emoji: '👦', label: 'Pria',   gender: 'Pria' },
    'wanita1': { emoji: '👧', label: 'Wanita', gender: 'Wanita' },
};

function pilihAvatar(id) {
    if (!AVATAR_DATA[id]) return;

    // Update display besar
    var display = document.getElementById('avatarDisplay');
    if (display) display.textContent = AVATAR_DATA[id].emoji;

    // Update badge gender
    var badge = document.getElementById('avatarGenderBadge');
    if (badge) {
        badge.textContent = AVATAR_DATA[id].gender;
        badge.className = 'avatar-gender-badge gender-' + AVATAR_DATA[id].gender.toLowerCase();
    }

    // Update hidden input untuk form POST
    var input = document.getElementById('avatarInput');
    if (input) input.value = id;

    // Update border terpilih
    Object.keys(AVATAR_DATA).forEach(function(key) {
        var el = document.getElementById('av-' + key);
        if (el) {
            if (key === id) el.classList.add('selected');
            else            el.classList.remove('selected');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Sync badge gender sesuai avatar yang sudah terpilih dari PHP
    var input = document.getElementById('avatarInput');
    if (input && input.value) {
        var id = input.value;
        if (AVATAR_DATA[id]) {
            var badge = document.getElementById('avatarGenderBadge');
            if (badge) {
                badge.textContent = AVATAR_DATA[id].gender;
                badge.className = 'avatar-gender-badge gender-' + AVATAR_DATA[id].gender.toLowerCase();
            }
        }
    }

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
