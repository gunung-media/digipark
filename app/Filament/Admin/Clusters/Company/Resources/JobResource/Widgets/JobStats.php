<?php

namespace App\Filament\Admin\Clusters\Company\Resources\JobResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages\ListJobs;
use App\Models\Company\Job;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class JobStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListJobs::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(Job::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            Stat::make('Laporan Lowongan', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
