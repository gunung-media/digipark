<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Admin\News\News;
use App\Models\Admin\News\NewsCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('News Active', News::active()->count()),
            Stat::make('News Non Active', News::where('status', 0)->count()),
            Stat::make('News Category', NewsCategory::count()),
        ];
    }
}
