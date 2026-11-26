import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const themeButtons = document.querySelectorAll('.theme-toggle');

    if (!themeButtons.length) {
        return;
    }

    const storedTheme = localStorage.getItem('public-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = storedTheme ? storedTheme === 'dark' : prefersDark;

    const applyTheme = (darkMode) => {
        document.documentElement.classList.toggle('dark-theme', darkMode);
        body.classList.toggle('dark-theme', darkMode);

        themeButtons.forEach((button) => {
            const icon = button.querySelector('.theme-toggle-icon');
            const darkIcon = darkMode ? '🌙' : '☀️';

            button.setAttribute('aria-pressed', String(darkMode));
            button.title = darkMode ? 'Ubah ke mode terang' : 'Ubah ke mode gelap';
            button.setAttribute('aria-label', darkMode ? 'Ubah ke mode terang' : 'Ubah ke mode gelap');

            if (icon) {
                icon.textContent = darkIcon;
            }
        });
    };

    applyTheme(isDark);

    themeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const nextDark = !body.classList.contains('dark-theme');
            localStorage.setItem('public-theme', nextDark ? 'dark' : 'light');
            applyTheme(nextDark);
        });
    });
});
