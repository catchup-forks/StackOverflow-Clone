<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SO Clone</title>
    <script>
        (() => {
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

            const applyTheme = (isDark) => {
                document.documentElement.classList.toggle('dark', isDark);
                document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
                document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
            };

            try {
                const storedTheme = window.localStorage.getItem('theme');
                const isDark = storedTheme === 'dark' || (!storedTheme && prefersDark);
                applyTheme(isDark);
            } catch (error) {
                applyTheme(prefersDark);
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="transition-colors duration-300">
    @include('public.partials.navbar')

    <main class="page-container space-y-10 transition-colors duration-300">
        <header class="card">
            @include('public.partials.header')
        </header>

        <section class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <article class="card">
                @if (session('status'))
                    <div class="alert alert--success mb-6 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert--danger mb-6">
                        <p class="font-semibold">Please fix the following issues:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </article>

            <aside class="card">
                @yield('side-menu')
            </aside>
        </section>

        <footer class="card">
            @include('public.partials.footer')
        </footer>
    </main>
</body>
</html>
