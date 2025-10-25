<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SO Clone</title>
    @vite('resources/js/app.js')
</head>
<body class="min-h-screen bg-slate-50">
    @include('public.partials.navbar')

    <main class="page-container space-y-10">
        <header class="card">
            @include('public.partials.header')
        </header>

        <section class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <article class="card">
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
