<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\DashboardResource;
use App\Filament\Admin\Pages;
use App\Models\Admin\Settings\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
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
                'primary' => "#949010",
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\\Filament\\Admin\\Clusters')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
                    ->label('Konten Website')
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
                    ->label("Pergi ke Website")
                    ->url(fn () => route('portal'))
                    ->icon('heroicon-o-globe-alt')
                    ->openUrlInNewTab()
            ])
            ->brandLogo(asset('portal/images/logo.png'))
            ->brandLogoHeight('3rem')
            ->breadcrumbs(fn () => !request()->routeIs('filament.admin.resources.dashboards.edit', 'filament.admin.resources.dashboards.create'))
            ->databaseNotifications()
            ->databaseNotificationsPolling("20s");
    }
}
