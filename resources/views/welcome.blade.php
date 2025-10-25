<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-950 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'StackOverflow Clone') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='20' fill='%233b82f6'/%3E%3Cpath d='M28 62h44v10H28zm4-4 2-8 26 6-2 8zm6-14 4-7 22 13-4 7zm12-17 6-6 18 20-6 6zM38 58h6v18h-6z' fill='white'/%3E%3C/svg%3E">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-slate-100 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 min-h-screen">
    <div class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-10 opacity-40">
            <div class="absolute h-64 w-64 bg-brand-500/40 blur-3xl top-10 left-10"></div>
            <div class="absolute h-72 w-72 bg-purple-500/30 blur-3xl bottom-10 right-10"></div>
        </div>
        <header class="px-6 py-4 sm:px-12 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 ring-1 ring-white/10">
                    <svg class="h-7 w-7 text-brand-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20V10m6 10V4m-3 16v-6" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-400">StackOverflow Clone</p>
                    <h1 class="text-xl font-semibold text-white">Laravel 12 + Tailwind</h1>
                </div>
            </div>
            <button data-theme-toggle class="group relative inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-white transition hover:border-white/30 hover:bg-white/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400 group-hover:bg-emerald-300"></span>
                Toggle theme
            </button>
        </header>

        <main class="px-6 pb-24 pt-10 sm:px-12">
            <section class="mx-auto max-w-5xl space-y-10">
                <div class="grid gap-12 lg:grid-cols-[1.4fr,1fr] lg:items-center">
                    <div class="space-y-6">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-200 ring-1 ring-inset ring-white/10">Freshly upgraded</span>
                        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Experience a refreshed StackOverflow-inspired UI powered by Laravel 12 and Tailwind CSS.</h2>
                        <p class="text-lg leading-8 text-slate-300">This lightweight showcase keeps things intentionally simple so you can focus on the updated project layout, modern application bootstrap, and the Tailwind-powered design system ready for your next iteration.</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="https://laravel.com/docs" class="inline-flex items-center gap-2 rounded-full bg-brand-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-brand-500/40 transition hover:bg-brand-400">
                                <span>Explore Laravel 12</span>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
                            </a>
                            <a href="https://tailwindcss.com/docs" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2 text-sm font-semibold text-white transition hover:border-white/30 hover:bg-white/10">
                                Tailwind Docs
                            </a>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-black/30 backdrop-blur">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Stack Overview</h3>
                        <dl class="mt-6 space-y-4 text-sm text-slate-200">
                            <div class="flex items-center justify-between rounded-xl bg-black/20 px-4 py-3">
                                <dt class="font-medium text-slate-300">Framework</dt>
                                <dd class="font-semibold text-white">Laravel 12.x</dd>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-black/20 px-4 py-3">
                                <dt class="font-medium text-slate-300">Frontend</dt>
                                <dd class="font-semibold text-white">Tailwind CSS 3</dd>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-black/20 px-4 py-3">
                                <dt class="font-medium text-slate-300">Bundler</dt>
                                <dd class="font-semibold text-white">Vite 5</dd>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-black/20 px-4 py-3">
                                <dt class="font-medium text-slate-300">Auth Ready</dt>
                                <dd class="font-semibold text-white">Sanctum</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                        <h4 class="text-lg font-semibold text-white">Modern project layout</h4>
                        <p class="mt-3 text-sm text-slate-300">Opinionated directories for HTTP, console, providers, routes, and configuration that align with Laravel 12 defaults.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                        <h4 class="text-lg font-semibold text-white">Tailwind-first styling</h4>
                        <p class="mt-3 text-sm text-slate-300">Utility classes paired with a subtle gradient background, glassmorphism cards, and typography built on Inter.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                        <h4 class="text-lg font-semibold text-white">Ready for expansion</h4>
                        <p class="mt-3 text-sm text-slate-300">Start wiring up real features, port your legacy logic, or connect APIs while keeping the new skeleton intact.</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="px-6 pb-10 sm:px-12">
            <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-4 text-sm text-slate-400 sm:flex-row">
                <p>&copy; {{ now()->year }} StackOverflow Clone. Built with Laravel 12.</p>
                <div class="flex items-center gap-3">
                    <a href="https://github.com/laravel/laravel" class="transition hover:text-white">GitHub</a>
                    <span aria-hidden="true" class="text-slate-500">·</span>
                    <a href="https://laravel.com" class="transition hover:text-white">laravel.com</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
