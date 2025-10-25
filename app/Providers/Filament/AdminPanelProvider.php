<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProviders\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::hex('#88c0d0'),
                'gray' => Color::hex('#4c566a'),
                'success' => Color::hex('#a3be8c'),
                'danger' => Color::hex('#bf616a'),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->brandName(config('app.name') . ' Admin')
            ->userMenuItems([
                MenuItem::make()->label(__('filament-panels::layout.actions.logout.label'))
                    ->url(fn () => Filament::getLogoutUrl()),
            ]);
    }
}

