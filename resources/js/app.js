import './bootstrap';

// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const sidebar = document.querySelector('.app-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('open');
        });

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    }
});
