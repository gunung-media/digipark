<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Pages\ListCompanyLegalizations;
use App\Models\Company\CompanyLegalization;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CompanyLegalizationStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListCompanyLegalizations::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(CompanyLegalization::class)
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
