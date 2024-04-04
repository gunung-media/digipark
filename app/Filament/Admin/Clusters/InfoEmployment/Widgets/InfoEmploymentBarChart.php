<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Widgets;

use App\Models\Admin\InfoEmployment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class InfoEmploymentBarChart extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        return  "Jumlah Pengangguran Tahun {$month->format('Y')}";
    }

    protected function getData(): array
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        $data = Trend::query(InfoEmployment::query()
            ->whereYear('date_in', $month?->year))
            ->dateColumn('date_in')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('count');

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengangguran',
                    'data' => $data->map(fn (TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $d) => Carbon::parse($d->date)->format('F'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
