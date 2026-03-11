/* =============================================
   MathLearn - Login Page JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Password toggle visibility (opsional, jika ada tombol)
    const togglePwd = document.getElementById('toggle-password');
    const pwdInput  = document.getElementById('password');

    if (togglePwd && pwdInput) {
        togglePwd.addEventListener('click', function () {
            const isText = pwdInput.type === 'text';
            pwdInput.type = isText ? 'password' : 'text';
            togglePwd.textContent = isText ? '👁️' : '🙈';
        });
    }

    // Form input validation feedback
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const email    = document.getElementById('email');
            const password = document.getElementById('password');
            let valid = true;

            [email, password].forEach(el => el && el.classList.remove('input-error'));

            if (email && !email.value.trim()) {
                email.classList.add('input-error');
                valid = false;
            }
            if (password && !password.value.trim()) {
                password.classList.add('input-error');
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    }
});
