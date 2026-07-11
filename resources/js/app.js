const themeToggle = document.querySelector('[data-theme-toggle]');

const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.dataset.theme = theme;
    localStorage.setItem('theme', theme);
    themeToggle?.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    themeToggle?.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
};

if (themeToggle) {
    const currentTheme = document.documentElement.dataset.theme === 'dark' ? 'dark' : 'light';
    applyTheme(currentTheme);

    themeToggle.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        applyTheme(nextTheme);
    });
}
