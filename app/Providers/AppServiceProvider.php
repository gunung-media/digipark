<?php

namespace App\Providers;

use App\Models\Dashboard;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        View::share('dashboard', Dashboard::with(['images', 'visions'])->first());
        View::share('menus', Menu::where('is_active', 1)->with('subMenus')->get());
    }
}
