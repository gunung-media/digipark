<?php

namespace App\Livewire\Portal;

use App\Models\Admin\InfoEmployment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class InfoEmploymentLineChart extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        return  "Info Per Tahun {$month->format('Y')} (Line chart)";
    }

    protected function getData(): array
    {
        $month = !is_null($this->filters['month'] ?? null)
            ? Carbon::parse($this->filters['month'])
            : now();

        $unemployed = Trend::query(
            InfoEmployment::query()
                ->whereYear('date_in', $month->year)
        )
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('unemployed_count');

        $seeker = Trend::query(
            InfoEmployment::query()
                ->whereYear('date_in', $month->year)
        )
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('seeker_count');

        $job = Trend::query(
            InfoEmployment::query()
                ->whereYear('date_in', $month->year)
        )
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('job_count');

        $placement = Trend::query(
            InfoEmployment::query()
                ->whereYear('date_in', $month->year)
        )
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('placement_count');

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengangguran',
                    'data' => $unemployed->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'tension' => 0.1,
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Pencari Kerja',
                    'data' => $seeker->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#4BC0C0',
                    'borderColor' => '#A7ECEE',
                    'tension' => 0.1,
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Lowongan Kerja',
                    'data' => $job->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#FFCE56',
                    'borderColor' => '#FFE699',
                    'tension' => 0.1,
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Penempatan Kerja',
                    'data' => $placement->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#9966FF',
                    'borderColor' => '#D1B3FF',
                    'tension' => 0.1,
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                ],
            ],
            'labels' => $unemployed->map(fn(TrendValue $d) => Carbon::parse($d->date)->format('F'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
