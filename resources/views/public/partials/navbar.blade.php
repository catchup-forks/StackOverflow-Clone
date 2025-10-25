<nav class="navbar">
    <div class="navbar__inner">
        <a class="navbar__brand" href="/">SO Clone</a>
        <div class="flex items-center gap-6">
            <ul class="navbar__links">
                <li><a class="navbar__link" href="/">Home</a></li>
                <li><a class="navbar__link" href="/questions">Questions</a></li>
                <li><a class="navbar__link" href="/tags">Tags</a></li>
                <li><a class="navbar__link" href="/users">Users</a></li>
            </ul>
            <button
                type="button"
                class="theme-toggle"
                @click="toggleTheme()"
                x-bind:aria-pressed="darkMode"
                x-bind:title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
                x-cloak
            >
                <span class="sr-only">Toggle dark mode</span>
                <span aria-hidden="true" x-show="!darkMode">🌙</span>
                <span aria-hidden="true" x-show="darkMode">☀️</span>
            </button>
        </div>
    </div>
</nav>
