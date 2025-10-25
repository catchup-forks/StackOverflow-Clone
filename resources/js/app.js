import './bootstrap';

window.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('[data-theme-toggle]');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    });
});
