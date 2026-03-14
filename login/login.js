document.addEventListener('DOMContentLoaded', function () {
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
