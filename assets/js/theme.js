/* =============================================
   MathLearn - Theme Toggle (shared)
   ============================================= */

function toggleTheme() {
    const body = document.body;
    const icon = document.getElementById('theme-icon');
    const text = document.getElementById('theme-text');
    const isDark = body.getAttribute('data-theme') === 'dark';

    if (isDark) {
        body.setAttribute('data-theme', 'light');
        if (icon) icon.textContent = '☀️';
        if (text) text.textContent = 'Light';
        localStorage.setItem('theme', 'light');
    } else {
        body.setAttribute('data-theme', 'dark');
        if (icon) icon.textContent = '🌙';
        if (text) text.textContent = 'Dark';
        localStorage.setItem('theme', 'dark');
    }
}

function loadTheme() {
    const saved = localStorage.getItem('theme') || 'dark';
    document.body.setAttribute('data-theme', saved);
    const icon = document.getElementById('theme-icon');
    const text = document.getElementById('theme-text');
    if (saved === 'light') {
        if (icon) icon.textContent = '☀️';
        if (text) text.textContent = 'Light';
    } else {
        if (icon) icon.textContent = '🌙';
        if (text) text.textContent = 'Dark';
    }
}

document.addEventListener('DOMContentLoaded', loadTheme);
