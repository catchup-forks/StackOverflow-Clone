# StackOverflow Clone — Laravel 12 Refresh

This repository now showcases a modernized Laravel 12 application skeleton paired with Tailwind CSS 3 and Vite. It is intentionally minimal so you can port legacy business logic over time while still getting an immediate preview of the updated folder layout, service providers, and tooling defaults.

## Current stack

- **Laravel 12.x** with the latest `bootstrap/app.php` configuration API
- **Tailwind CSS 3** via Vite with a custom Inter-based theme
- **Vite 5** for asset bundling and hot module replacement
- **Laravel Sanctum** scaffolding for API/token auth readiness
- **PHPUnit 11** with modern testing directories (`tests/Feature`, `tests/Unit`)

## Getting started

1. Install PHP 8.2+, Node.js 18+, and Composer.
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Create an environment file and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Serve the application and assets:
   ```bash
   php artisan serve
   npm run dev
   ```

You should now see the refreshed Tailwind-powered welcome screen at `http://localhost:8000`.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
