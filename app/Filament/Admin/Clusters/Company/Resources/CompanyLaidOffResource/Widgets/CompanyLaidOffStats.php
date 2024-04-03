<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Pages\ListCompanyLaidOffs;
use App\Models\Company\CompanyLaidOff;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CompanyLaidOffStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListCompanyLaidOffs::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(CompanyLaidOff::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Laporan PHK', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
