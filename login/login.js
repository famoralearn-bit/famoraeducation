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
                emailFeedback.textContent = val.includes('@') && !val.endsWith('@gmail.com')
                    ? 'Hanya Gmail yang diterima. Gunakan alamat @gmail.com'
                    : 'Format email tidak valid';
            }
        }
    }

    if (emailInput) {
        emailInput.addEventListener('input', validateGmail);
        emailInput.addEventListener('blur', validateGmail);
    }

    // Block submit jika bukan Gmail
    const loginForm = document.querySelector('form[method="POST"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
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

    // Toggle password visibility
    const toggleBtn = document.getElementById('toggle-password');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eye-icon');

    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = pwdInput.type === 'password';
            pwdInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }
});
