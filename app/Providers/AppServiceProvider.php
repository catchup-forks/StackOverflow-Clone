<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register legacy bindings here.
    }

    public function boot(): void
    {
        // Bootstrap any legacy application services.
    }
}
