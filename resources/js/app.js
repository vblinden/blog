const storageKey = 'theme';
const themeToggle = document.querySelector('[data-theme-toggle]');
const themeToggleLabel = document.querySelector('[data-theme-toggle-label]');
const themeToggleIcon = document.querySelector('[data-theme-toggle-icon]');
const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

const applyTheme = (theme) => {
    const isDark = theme === 'dark';

    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = theme;

    if (themeToggle !== null) {
        themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    }

    if (themeToggleLabel !== null) {
        themeToggleLabel.textContent = isDark ? 'Light mode' : 'Dark mode';
    }

    if (themeToggleIcon !== null) {
        themeToggleIcon.textContent = isDark ? '🌕' : '☀️';
    }
};

const resolveInitialTheme = () => {
    const storedTheme = window.localStorage.getItem(storageKey);

    if (storedTheme === 'light' || storedTheme === 'dark') {
        return storedTheme;
    }

    return mediaQuery.matches ? 'dark' : 'light';
};

applyTheme(resolveInitialTheme());

themeToggle?.addEventListener('click', () => {
    const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';

    window.localStorage.setItem(storageKey, nextTheme);
    applyTheme(nextTheme);
});

mediaQuery.addEventListener('change', (event) => {
    if (window.localStorage.getItem(storageKey) !== null) {
        return;
    }

    applyTheme(event.matches ? 'dark' : 'light');
});
