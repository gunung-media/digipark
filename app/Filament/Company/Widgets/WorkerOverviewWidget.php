<?php

namespace App\Filament\Company\Widgets;

use App\Models\Seeker\Seeker;
use App\Utils\FilamentUtil;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkerOverviewWidget extends BaseWidget
{
    static protected int|null $sort = 1;
    protected int | string | array $columnSpan = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Pekerja', Seeker::where('company_id', FilamentUtil::getUser()->id)->count()),
        ];
    }
}
