<?php

namespace App\Providers;

use App\Models\Admin\Menu\Menu;
use App\Models\Admin\Settings\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');
        Model::unguard();
        if (Schema::hasTable('dashboard') || Schema::hasTable('menus')) {
            View::share('dashboard', Dashboard::with([
                'images' => fn($query) => $query->active(),
                'visions' => fn($query) => $query->active(),
                'testimonials' => fn($query) => $query->active()
            ])->first());
            View::share('menus', Menu::active()->with(['subMenus' => fn($query) => $query->active()])->get());
        }
    }
}
