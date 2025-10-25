import '../css/app.css';

const storageKey = 'theme';
const mediaQuery = typeof window !== 'undefined' && window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

const getStoredTheme = () => {
    try {
        return window.localStorage.getItem(storageKey);
    } catch (error) {
        return null;
    }
};

const setStoredTheme = (value) => {
    try {
        if (value === null) {
            window.localStorage.removeItem(storageKey);
            return;
        }

        window.localStorage.setItem(storageKey, value);
    } catch (error) {
        // Ignore storage failures (e.g. private browsing)
    }
};

const applyTheme = (theme) => {
    const root = document.documentElement;
    const isDark = theme === 'dark';

    root.classList.toggle('dark', isDark);
    root.setAttribute('data-theme', isDark ? 'dark' : 'light');
    root.style.colorScheme = isDark ? 'dark' : 'light';
};

const syncToggleState = (toggles, theme) => {
    toggles.forEach((toggle) => {
        toggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        toggle.setAttribute('data-theme-active', theme);
        const nextTitle = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
        toggle.setAttribute('title', nextTitle);
        toggle.setAttribute('aria-label', nextTitle);

        const sun = toggle.querySelector('[data-theme-toggle-icon="sun"]');
        const moon = toggle.querySelector('[data-theme-toggle-icon="moon"]');

        if (sun) {
            sun.hidden = theme !== 'dark';
        }

        if (moon) {
            moon.hidden = theme === 'dark';
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const toggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));

    if (toggles.length === 0) {
        return;
    }

    let storedPreference = getStoredTheme();
    const root = document.documentElement;
    let currentTheme = storedPreference ?? (root.classList.contains('dark') ? 'dark' : 'light');

    applyTheme(currentTheme);
    syncToggleState(toggles, currentTheme);

    const setTheme = (nextTheme, persist = true) => {
        currentTheme = nextTheme;
        applyTheme(nextTheme);
        syncToggleState(toggles, nextTheme);

        if (persist) {
            storedPreference = nextTheme;
            setStoredTheme(nextTheme);
        }
    };

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';
            setTheme(nextTheme);
        });
    });

    if (mediaQuery) {
        mediaQuery.addEventListener('change', (event) => {
            if (storedPreference === null) {
                setTheme(event.matches ? 'dark' : 'light', false);
            }
        });
    }
});

console.info('Legacy StackOverflow clone assets compiled with Vite and Nord theme.');
