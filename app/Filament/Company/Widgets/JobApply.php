<?php

namespace App\Filament\Company\Widgets;

use App\Models\Seeker\JobApplicant;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class JobApply extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pengapply';

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $data = Trend::query(
            JobApplicant::whereHas('job', function ($query) {
                $query->where('company_id', auth('company')->user()->id);
            })
        )->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth()
        )
            ->perDay()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengapply',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d M, Y')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
