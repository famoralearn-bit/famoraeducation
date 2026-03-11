/* =============================================
   MathLearn - Register Page JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    const form            = document.querySelector('form');
    const passwordInput   = document.getElementById('password');
    const confirmInput    = document.getElementById('confirm_password');
    const strengthBar     = document.getElementById('strength-bar');
    const strengthText    = document.getElementById('strength-text');

    // ---- Password strength indicator ----
    if (passwordInput && strengthBar) {
        passwordInput.addEventListener('input', function () {
            const val = passwordInput.value;
            let score = 0;
            if (val.length >= 6)  score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = ['', 'Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
            const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e', '#10b981'];

            strengthBar.style.width  = (score * 20) + '%';
            strengthBar.style.background = colors[score] || '#ef4444';
            if (strengthText) strengthText.textContent = val.length ? levels[score] : '';
        });
    }

    // ---- Confirm password match ----
    if (confirmInput) {
        confirmInput.addEventListener('input', function () {
            if (passwordInput.value && confirmInput.value) {
                if (passwordInput.value !== confirmInput.value) {
                    confirmInput.style.borderColor = '#ef4444';
                } else {
                    confirmInput.style.borderColor = '#22c55e';
                }
            } else {
                confirmInput.style.borderColor = '';
            }
        });
    }

    // ---- Form submit validation ----
    if (form) {
        form.addEventListener('submit', function (e) {
            const nama  = document.getElementById('nama');
            const email = document.getElementById('email');
            let valid   = true;

            [nama, email, passwordInput, confirmInput].forEach(el => {
                if (el) el.classList.remove('input-error');
            });

            if (nama  && !nama.value.trim())  { nama.classList.add('input-error');  valid = false; }
            if (email && !email.value.trim()) { email.classList.add('input-error'); valid = false; }
            if (passwordInput && passwordInput.value.length < 6) {
                passwordInput.classList.add('input-error'); valid = false;
            }
            if (confirmInput && passwordInput && confirmInput.value !== passwordInput.value) {
                confirmInput.classList.add('input-error'); valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }
});
