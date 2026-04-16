document.addEventListener('DOMContentLoaded', function () {
    // ── Gmail validation ──────────────────────────────────────────
    const emailInput    = document.getElementById('email');
    const emailFeedback = document.getElementById('email-feedback');
    const gmailRegex    = /^[a-zA-Z0-9._%+\-]+@gmail\.com$/;

    function validateGmail() {
        const val = emailInput.value.trim();
        if (!val) {
            emailInput.classList.remove('is-valid', 'is-invalid');
            if (emailFeedback) emailFeedback.textContent = '';
            return;
        }
        if (gmailRegex.test(val)) {
            emailInput.classList.add('is-valid');
            emailInput.classList.remove('is-invalid');
            if (emailFeedback) emailFeedback.textContent = '';
        } else {
            emailInput.classList.add('is-invalid');
            emailInput.classList.remove('is-valid');
            if (emailFeedback) {
                if (val.includes('@') && !val.endsWith('@gmail.com')) {
                    emailFeedback.textContent = 'Hanya Gmail yang diterima. Gunakan alamat @gmail.com';
                } else {
                    emailFeedback.textContent = 'Format email tidak valid';
                }
            }
        }
    }

    if (emailInput) {
        emailInput.addEventListener('input', validateGmail);
        emailInput.addEventListener('blur', validateGmail);
    }

    // Block submit if email bukan Gmail
    const registerForm = document.querySelector('form[method="POST"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            const val = emailInput ? emailInput.value.trim() : '';
            if (!gmailRegex.test(val)) {
                e.preventDefault();
                if (emailInput) {
                    emailInput.classList.add('is-invalid');
                    emailInput.focus();
                }
                if (emailFeedback) emailFeedback.textContent = 'Hanya Gmail yang diterima (contoh@gmail.com)';
            }
        });
    }
    // ── End Gmail validation ──────────────────────────────────────

    const pwdInput   = document.getElementById('password');
    const confirmPwd = document.getElementById('confirm_password');
    const strengthBar  = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    const toggleBtn  = document.getElementById('toggle-password');
    const eyeIcon    = document.getElementById('eye-icon');

    // Toggle password visibility
    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = pwdInput.type === 'password';
            pwdInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    // Password strength
    if (pwdInput && strengthBar && strengthText) {
        pwdInput.addEventListener('input', function () {
            const val = this.value;
            let strength = 0;
            if (val.length >= 6)  strength++;
            if (val.length >= 10) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { pct: '0%',   color: '',          label: '' },
                { pct: '25%',  color: '#ef4444',   label: 'Sangat Lemah' },
                { pct: '50%',  color: '#f59e0b',   label: 'Lemah' },
                { pct: '75%',  color: '#3b82f6',   label: 'Cukup' },
                { pct: '90%',  color: '#10b981',   label: 'Kuat' },
                { pct: '100%', color: '#10b981',   label: 'Sangat Kuat' },
            ];
            const lv = levels[strength] || levels[0];
            strengthBar.style.width = lv.pct;
            strengthBar.style.backgroundColor = lv.color;
            strengthText.textContent = lv.label;
            strengthText.style.color = lv.color;
        });
    }

    // Confirm password live check
    if (confirmPwd && pwdInput) {
        confirmPwd.addEventListener('input', function () {
            if (this.value && this.value !== pwdInput.value) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (this.value) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.remove('is-invalid','is-valid');
            }
        });
    }
});
