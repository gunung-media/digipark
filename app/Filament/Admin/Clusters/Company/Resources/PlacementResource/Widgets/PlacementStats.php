<?php

namespace App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages\ListPlacements;
use App\Models\Company\Placement;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\TrendValue;
use Flowframe\Trend\Trend;

class PlacementStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListPlacements::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(Placement::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            Stat::make('Laporan Penempatan', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
