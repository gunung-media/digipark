<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages\ListLaborDemands;
use App\Models\Company\LaborDemand;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\TrendValue;
use Flowframe\Trend\Trend;

class LaborDemandStat extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListLaborDemands::class;
    }
    protected function getStats(): array
    {
        $data = Trend::model(LaborDemand::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            Stat::make('Laporan Permintaan Tenaga Kerja', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
