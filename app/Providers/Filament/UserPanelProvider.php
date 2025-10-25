<?php

namespace App\Providers\Filament;

use App\Filament\User\Resources\QuestionResource;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProviders\PanelProvider;
use Filament\Support\Colors\Color;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->login()
            ->default()
            ->homeUrl(fn () => QuestionResource::getUrl())
            ->colors([
                'primary' => Color::hex('#88c0d0'),
                'gray' => Color::hex('#4c566a'),
            ])
            ->brandName(config('app.name'))
            ->sidebarCollapsibleOnDesktop(false)
            ->maxContentWidth('7xl')
            ->globalSearch(false)
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->viteTheme('resources/css/app.css')
            ->userMenuItems([
                MenuItem::make()->label(__('filament-panels::layout.actions.logout.label'))
                    ->url(fn () => Filament::getLogoutUrl()),
            ]);
    }
}

