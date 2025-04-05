<?php

namespace App\Filament\Company\Clusters\Seeker\Resources\ClaimJhtResource\Widgets;

use App\Filament\Company\Clusters\Seeker\Resources\ClaimJhtResource\Pages\ListClaimJhts;
use App\Models\Seeker\ClaimJht;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\TrendValue;
use Flowframe\Trend\Trend;

class ClaimJhtStat extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListClaimJhts::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(ClaimJht::class)
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
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
