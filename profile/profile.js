/* =============================================
   MathLearn - Profile Page JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Password match live check
    const newPwd  = document.getElementById('new_password');
    const confPwd = document.getElementById('confirm_password');

    if (newPwd && confPwd) {
        confPwd.addEventListener('input', function () {
            if (newPwd.value && confPwd.value) {
                confPwd.style.borderColor = newPwd.value === confPwd.value ? '#22c55e' : '#ef4444';
            } else {
                confPwd.style.borderColor = '';
            }
        });
    }
});
