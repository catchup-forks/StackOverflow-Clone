import '../css/app.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('themeSwitcher', () => ({
    darkMode: false,
    storedPreference: null,

    init() {
        try {
            const savedTheme = window.localStorage.getItem('theme');
            if (savedTheme === 'dark' || savedTheme === 'light') {
                this.storedPreference = savedTheme;
                this.darkMode = savedTheme === 'dark';
            } else {
                this.darkMode = this.prefersDark();
            }
        } catch (error) {
            this.darkMode = this.prefersDark();
        }

        this.updateDom(this.darkMode);

        const mediaQuery = this.getMediaQuery();
        if (mediaQuery) {
            mediaQuery.addEventListener('change', (event) => {
                if (this.storedPreference === null) {
                    this.darkMode = event.matches;
                    this.updateDom(this.darkMode);
                }
            });
        }

        this.$watch('darkMode', (value) => {
            this.updateDom(value);
        });
    },

    toggleTheme() {
        this.darkMode = !this.darkMode;
        this.storedPreference = this.darkMode ? 'dark' : 'light';

        try {
            window.localStorage.setItem('theme', this.storedPreference);
        } catch (error) {
            // Ignore storage failures (e.g. private mode)
        }
    },

    updateDom(value) {
        document.documentElement.classList.toggle('dark', value);
        document.documentElement.setAttribute('data-theme', value ? 'dark' : 'light');
        document.documentElement.style.colorScheme = value ? 'dark' : 'light';
    },

    prefersDark() {
        const mediaQuery = this.getMediaQuery();
        return mediaQuery ? mediaQuery.matches : false;
    },

    getMediaQuery() {
        if (typeof window === 'undefined' || !window.matchMedia) {
            return null;
        }

        return window.matchMedia('(prefers-color-scheme: dark)');
    },
}));

Alpine.start();

console.info('Legacy StackOverflow clone assets compiled with Vite.');
