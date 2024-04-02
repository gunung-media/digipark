<?php

namespace App\Providers\Filament;

use App\Filament\Resources\DashboardResource;
use App\Models\Admin\Settings\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->navigationItems([
                NavigationItem::make('Website Content')
                    ->url(
                        fn () =>
                        Dashboard::count() === 0
                            ? DashboardResource::getUrl('create')
                            :  DashboardResource::getUrl('edit', ['record' => Dashboard::first()])
                    )
                    ->icon('heroicon-o-presentation-chart-line')
                    ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.dashboards.edit', 'filament.admin.resources.dashboards.create'))
                    ->group('Settings'),
                NavigationItem::make('Website')
                    ->label("Go to website")
                    ->url(fn () => route('portal'))
                    ->icon('heroicon-o-globe-alt')
                    ->openUrlInNewTab()
            ])
            ->breadcrumbs(fn () => !request()->routeIs('filament.admin.resources.dashboards.edit', 'filament.admin.resources.dashboards.create'))
            ->databaseNotifications()
            ->databaseNotificationsPolling("20s");
    }
}
