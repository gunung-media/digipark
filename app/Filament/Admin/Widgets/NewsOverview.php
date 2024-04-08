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
            Stat::make('Berita Aktif', News::active()->count()),
            Stat::make('Berita Tidak Aktif', News::where('status', 0)->count()),
            Stat::make('Kategori', NewsCategory::count()),
        ];
    }
}
