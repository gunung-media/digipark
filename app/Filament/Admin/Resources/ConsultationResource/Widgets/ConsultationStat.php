<?php

namespace App\Filament\Admin\Resources\ConsultationResource\Widgets;

use App\Models\Admin\Consultation;
use App\Models\Company\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ConsultationStat extends BaseWidget
{
    protected function getStats(): array
    {
        $data = Trend::model(Consultation::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            Stat::make('Jumlah Konsultasi', Consultation::all()->count())
                ->chart(
                    $data
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
